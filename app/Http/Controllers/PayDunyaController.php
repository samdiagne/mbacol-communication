<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Services\Payment\PayDunyaGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;

class PayDunyaController extends Controller
{
    private PayDunyaGateway $gateway;
    
    public function __construct(PayDunyaGateway $gateway)
    {
        $this->gateway = $gateway;
    }
    
    /**
     * 🔄 Return URL - Redirection après paiement (UX seulement)
     * 
     * ⚠️ IMPORTANT : Ne JAMAIS marquer la commande comme payée ici
     * Cette URL peut être manipulée par l'utilisateur
     * Seul le webhook fait foi
     */
    public function return(Request $request)
    {

        /*if (!config('services.paydunya.enabled')) {
        return redirect()->back()->with('error', 'Paiement désactivé en mode local');
        }*/
        
        $token = $request->query('token');
        
        Log::info('PayDunya Return URL accessed', ['token' => $token]);
        
        if (!$token) {
            return redirect()->route('checkout')->with('error', 'Transaction invalide');
        }
        
        $payment = Payment::where('transaction_id', $token)->first();
        
        if (!$payment) {
            Log::warning('PayDunya Return: Payment not found', ['token' => $token]);
            return redirect()->route('checkout')->with('error', 'Paiement introuvable');
        }
        
        $order = $payment->order;
        
        /* ✅ MODE TEST : Forcer la confirmation si payment pending
        if ($payment->payment_status === 'pending' && config('paydunya.mode') === 'test') {
            Log::info('PayDunya Return: TEST MODE - forcing payment confirmation');
            
            try {
                DB::beginTransaction();
                
                // Marquer comme payé
                $payment->update([
                    'payment_status' => 'completed',
                    'paid_at' => now(),
                    'notes' => 'Paiement confirmé via return URL (TEST MODE)',
                ]);
                
                $order->update([
                    'payment_status' => 'paid',
                    'status' => 'confirmed',
                ]);
                
                // Vider panier
                if ($order->user_id) {
                    \App\Models\CartItem::where('user_id', $order->user_id)->delete();
                    Log::info('PayDunya Return: Cart cleared', ['user_id' => $order->user_id]);
                }
                
                // Envoyer emails
                try {
                    Mail::to($order->customer_email)->send(new OrderConfirmation($order));
                    Mail::to(config('mail.from.address'))->send(new \App\Mail\NewOrderAdmin($order));
                    Log::info('PayDunya Return: Emails sent');
                } catch (\Exception $e) {
                    Log::error('PayDunya Return: Email error', ['error' => $e->getMessage()]);
                }
                
                DB::commit();
                Log::info('PayDunya Return: Payment confirmed successfully');
                
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('PayDunya Return: Error', ['error' => $e->getMessage()]);
            }
        }*/
        
        // Si déjà payé, rediriger
        if ($payment->payment_status === 'completed') {
            Log::info('PayDunya Return: Redirecting to confirmation');
            return redirect()->route('order.confirmation', $order)
                ->with('success', 'Paiement confirmé !');
        }
        
        // Sinon, page d'attente
        return view('payment.pending', compact('order', 'payment'));
    }
    
    /**
     * ❌ Cancel URL - Paiement annulé par l'utilisateur
     */
    public function cancel(Request $request)
    {
        $token = $request->query('token');
        
        Log::info('PayDunya Cancel URL accessed', ['token' => $token]);
        
        if ($token) {
            $payment = Payment::where('transaction_id', $token)->first();
            
            if ($payment && $payment->payment_status === 'pending') {
                $payment->update([
                    'payment_status' => 'cancelled',
                    'notes' => 'Paiement annulé par le client',
                ]);
                
                $payment->order->update([
                    'status' => 'cancelled',
                ]);
                
                Log::info('PayDunya: Payment cancelled', [
                    'order_id' => $payment->order_id,
                ]);
            }
        }
        
        return redirect()->route('checkout')
            ->with('error', 'Paiement annulé. Vous pouvez réessayer.');
    }
    
    /**
     * 🔐 WEBHOOK - SEULE SOURCE DE VÉRITÉ
     * 
     * C'est ICI et SEULEMENT ICI qu'on marque la commande comme payée
     * 
     * Sécurité :
     * 1. Validation signature
     * 2. Double vérification API
     * 3. Idempotence
     * 4. Transaction atomique
     * 5. Logs détaillés
     */
    public function webhook(Request $request)
    {
        $startTime = microtime(true);

        try {
            // Log 1 : Requête reçue
            Log::info('=== PayDunya Webhook START ===');
            Log::info('PayDunya Webhook received', [
                'ip' => $request->ip(),
                'method' => $request->method(),
                'full_body' => $request->all(),
            ]);

            // Log 2 : Validation signature
            $isValid = $this->gateway->validateWebhook($request->all());

            Log::info('PayDunya Webhook: Validation result', [
                'valid' => $isValid,
                'mode' => $this->gateway->isTestMode() ? 'test' : 'live',
            ]);

            // ✅ En mode test, on accepte même si signature invalide (pour debug)
            if (!$isValid && !$this->gateway->isTestMode()) {
                Log::warning('PayDunya Webhook: Invalid signature in LIVE mode - REJECT');
                return response()->json(['error' => 'Invalid signature'], 403);
            }

            if (!$isValid && $this->gateway->isTestMode()) {
                Log::warning('PayDunya Webhook: Invalid signature in TEST mode - CONTINUE ANYWAY');
            }

            Log::info('PayDunya Webhook: Signature valid ✓');

            // Log 3 : Extraction token - TOUTES LES POSSIBILITÉS
            $allData = $request->all();
            $data = $request->input('data', []);
            
            // Essayer TOUTES les structures possibles
            $token = null;
            
            // Structure 1 : data.invoice.token
            if (isset($data['invoice']['token'])) {
                $token = $data['invoice']['token'];
                Log::info('Token found in data.invoice.token', ['token' => $token]);
            }
            // Structure 2 : data.token
            elseif (isset($data['token'])) {
                $token = $data['token'];
                Log::info('Token found in data.token', ['token' => $token]);
            }
            // Structure 3 : invoice.token
            elseif (isset($allData['invoice']['token'])) {
                $token = $allData['invoice']['token'];
                Log::info('Token found in invoice.token', ['token' => $token]);
            }
            // Structure 4 : token direct
            elseif (isset($allData['token'])) {
                $token = $allData['token'];
                Log::info('Token found in token', ['token' => $token]);
            }

            Log::info('PayDunya Webhook: Token extraction result', [
                'token' => $token,
                'full_structure' => json_encode($allData),
            ]);

            if (!$token) {
                Log::error('PayDunya Webhook: Missing token - STOP', [
                    'tried_paths' => [
                        'data.invoice.token',
                        'data.token',
                        'invoice.token',
                        'token'
                    ],
                    'available_keys' => array_keys($allData),
                    'data_keys' => isset($data) ? array_keys($data) : [],
                ]);
                return response()->json(['error' => 'Missing token'], 400);
            }

            Log::info('PayDunya Webhook: Token extracted successfully ✓', ['token' => $token]);

            // ✅ AJOUTER ICI : Extraire le provider (Wave, OM, etc.)
            $paymentProvider = null;

            // PayDunya envoie le moyen de paiement utilisé dans data.customer ou data.invoice
            if (isset($data['customer']['payment_method'])) {
                $paymentProvider = $data['customer']['payment_method'];
            } elseif (isset($data['invoice']['payment_method'])) {
                $paymentProvider = $data['invoice']['payment_method'];
            } elseif (isset($allData['payment_method'])) {
                $paymentProvider = $allData['payment_method'];
            }

            // Normaliser les noms
            $paymentProvider = match(strtolower($paymentProvider ?? '')) {
                'wave', 'wave_senegal' => 'wave',
                'orange', 'orange_money', 'orange_money_senegal' => 'orange_money',
                'free', 'free_money' => 'free_money',
                'card', 'visa', 'mastercard', 'credit_card' => 'card',
                default => 'paydunya', // Par défaut si non détecté
            };

            Log::info('PayDunya Webhook: Payment provider detected', [
                'provider' => $paymentProvider,
            ]);

            // Log 4 : Recherche paiement
            Log::info('PayDunya Webhook: Searching for payment...');
            
            $payment = Payment::where('transaction_id', $token)->with('order')->first();
            
            if (!$payment) {
                Log::error('PayDunya Webhook: Payment NOT FOUND - STOP', [
                    'token' => $token,
                    'searched_in' => 'payments.transaction_id',
                ]);
                return response()->json(['error' => 'Payment not found'], 404);
            }

            Log::info('PayDunya Webhook: Payment found ✓', [
                'payment_id' => $payment->id,
                'order_id' => $payment->order_id,
                'current_status' => $payment->payment_status,
            ]);

            // Log 5 : Idempotence check
            if ($payment->payment_status === 'completed') {
                Log::info('PayDunya Webhook: Already completed (idempotent) - STOP');
                return response()->json(['message' => 'Already processed'], 200);
            }

            // Log 6 : Verification
            Log::info('PayDunya Webhook: Starting verification...');
            
            Log::info('PayDunya Webhook: Calling API to verify status...', [
                'mode' => $this->gateway->isTestMode() ? 'test' : 'live',
            ]);
            $verification = $this->gateway->checkStatus($token);
            Log::info('PayDunya Webhook: API response', $verification);

            if (!$verification['success'] || $verification['status'] !== 'completed') {
                Log::warning('PayDunya Webhook: Verification FAILED - STOP', [
                    'verification' => $verification,
                ]);
                return response()->json(['error' => 'Payment not completed'], 400);
            }

            // ✅ AJOUTER : Vérifier que le paiement n'est pas trop vieux
            if ($payment->created_at->lt(now()->subHours(48))) {
                Log::warning('PayDunya Webhook: Payment too old', [
                    'payment_id' => $payment->id,
                    'created_at' => $payment->created_at,
                ]);
                return response()->json(['error' => 'Payment too old'], 400);
            }

            Log::info('PayDunya Webhook: Verification passed ✓');

            // Log 7 : Database update
            Log::info('PayDunya Webhook: Starting database transaction...');

            DB::beginTransaction();

            try {
                Log::info('PayDunya Webhook: Updating payment record...');
                
                $payment->update([
                    'payment_status' => 'completed',
                    'paid_at' => now(),
                    'payment_provider' => $paymentProvider, // ✅ AJOUTER
                    'receipt_url' => $verification['data']['receipt_url'] ?? null,
                    'notes' => 'Paiement confirmé via webhook PayDunya',
                ]);

                Log::info('PayDunya Webhook: Updating order record...');
                
                $payment->order->update([
                    'payment_status' => 'paid',
                    'status' => 'confirmed',
                    'payment_provider' => $paymentProvider, // ✅ AJOUTER
                ]);

                DB::commit();
                
                Log::info('PayDunya Webhook: Database transaction committed ✓');

                // Log 8 : Clear cart
                Log::info('PayDunya Webhook: Clearing cart...');
                
                $order = $payment->order;
                if ($order->user_id) {
                    $cartCount = \App\Models\CartItem::where('user_id', $order->user_id)->count();
                    \App\Models\CartItem::where('user_id', $order->user_id)->delete();
                    Log::info('PayDunya Webhook: Cart cleared ✓', [
                        'user_id' => $order->user_id,
                        'items_deleted' => $cartCount,
                    ]);
                } else {
                    Log::info('PayDunya Webhook: No user_id, skipping cart clear');
                }

                // Log 9 : Send emails
                Log::info('PayDunya Webhook: Sending emails...');

                try {
                    // Email client
                    Mail::to($order->customer_email)->send(new OrderConfirmation($order));
                    Log::info('PayDunya Webhook: Customer email sent ✓', [
                        'to' => $order->customer_email
                    ]);
                    
                    // Email admin
                    Mail::to(config('mail.admin_email'))->send(new \App\Mail\NewOrderAdmin($order));
                    Log::info('PayDunya Webhook: Admin email sent ✓', [
                        'to' => config('admin.email')
                    ]);
                } catch (\Exception $e) {
                    Log::error('PayDunya Webhook: Email error (non-blocking)', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    // Ne pas bloquer la commande si email échoue
                }

                $duration = round((microtime(true) - $startTime) * 1000, 2);
                
                Log::info('=== PayDunya Webhook SUCCESS ===', [
                    'order_id' => $payment->order_id,
                    'order_number' => $order->order_number,
                    'amount' => $payment->amount,
                    'duration_ms' => $duration,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Payment confirmed',
                    'order_id' => $payment->order_id,
                ], 200);

            } catch (\Exception $e) {
                DB::rollBack();
                
                Log::error('PayDunya Webhook: Database transaction FAILED', [
                    'error' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]);
                
                throw $e;
            }

        } catch (\Exception $e) {
            Log::error('=== PayDunya Webhook EXCEPTION ===', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'error' => 'Internal server error',
                'message' => config('app.debug') ? $e->getMessage() : 'Processing failed',
            ], 500);
        }
    }
    
    /**
     * 🔍 Debug endpoint (à supprimer en production)
     */
    public function debug()
    {
        if (!config('app.debug')) {
            abort(404);
        }
        
        return response()->json([
            'paydunya_config' => $this->gateway->getConfig(),
            'recent_payments' => Payment::where('payment_method', 'paydunya')
                ->latest()
                ->take(5)
                ->get(),
        ]);
    }
    
}
