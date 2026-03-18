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
use App\Mail\NewOrderAdmin;
use App\Models\CartItem;

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
        Log::info('PayDunya Webhook received', [
            'payload' => $request->all()
        ]);

        try {

            /*
            |----------------------------------------------------------
            | Validation signature PayDunya
            |----------------------------------------------------------
            */

            $isValid = $this->gateway->validateWebhook($request->all());

            if (!$isValid && !$this->gateway->isTestMode()) {

                Log::warning('Invalid PayDunya webhook signature');

                return response()->json([
                    'error' => 'Invalid signature'
                ], 403);
            }

            /*
            |----------------------------------------------------------
            | Récupération des données
            |----------------------------------------------------------
            */

            $allData = $request->all();
            $data = $allData['data'] ?? [];

            $token = null;

            if (isset($data['invoice']['token'])) {
                $token = $data['invoice']['token'];
            } elseif (isset($data['token'])) {
                $token = $data['token'];
            } elseif (isset($allData['invoice']['token'])) {
                $token = $allData['invoice']['token'];
            } elseif (isset($allData['token'])) {
                $token = $allData['token'];
            }

            if (!$token) {

                Log::error('PayDunya webhook token missing');

                return response()->json([
                    'error' => 'Token missing'
                ], 400);
            }

            Log::info('PayDunya token extracted', [
                'token' => $token
            ]);

            /*
            |----------------------------------------------------------
            | Détection provider paiement
            |----------------------------------------------------------
            */

            $paymentProvider = $data['payment_method'] ?? null;

            $paymentProvider = match(strtolower($paymentProvider ?? '')) {
                'wave' => 'wave',
                'orange_money' => 'orange_money',
                'free_money' => 'free_money',
                'visa', 'mastercard' => 'card',
                default => 'unknown'
            };

            /*
            |----------------------------------------------------------
            | Recherche paiement
            |----------------------------------------------------------
            */

            $payment = Payment::where('transaction_id', $token)
                ->with('order')
                ->first();

            if (!$payment) {

                Log::warning('Payment not found for token', [
                    'token' => $token
                ]);

                return response()->json([
                    'message' => 'Payment not found'
                ], 404);
            }

            $order = $payment->order;

            /*
            |----------------------------------------------------------
            | Protection double webhook
            |----------------------------------------------------------
            */

            if ($payment->payment_status === 'completed') {

                Log::info('Payment already processed', [
                    'token' => $token
                ]);

                return response()->json([
                    'message' => 'Already processed'
                ], 200);
            }

            /*
            |----------------------------------------------------------
            | Vérification API PayDunya
            |----------------------------------------------------------
            */

            if (!$this->gateway->isTestMode()) {

                $verification = $this->gateway->checkStatus($token);

                if (!$verification || ($verification['status'] ?? null) !== 'completed') {

                    Log::warning('Payment verification failed', [
                        'token' => $token,
                        'verification' => $verification
                    ]);

                    return response()->json([
                        'message' => 'Payment not completed'
                    ], 400);
                }
            }

            /*
            |----------------------------------------------------------
            | Transaction base de données
            |----------------------------------------------------------
            */

            try {

                DB::beginTransaction();

                $payment->update([
                    'payment_status' => 'completed',
                    'paid_at' => now(),
                    'payment_provider' => $paymentProvider
                ]);

                $order->update([
                    'payment_status' => 'paid',
                    'status' => 'confirmed'
                ]);

                /*
                |----------------------------------------
                | Vider panier utilisateur
                |----------------------------------------
                */

                if ($order->user_id) {

                    CartItem::where('user_id', $order->user_id)->delete();
                }

                DB::commit();

            } catch (\Exception $e) {

                DB::rollBack();

                Log::error('PayDunya webhook DB error', [
                    'error' => $e->getMessage(),
                    'token' => $token
                ]);

                return response()->json([
                    'error' => 'Database error'
                ], 500);
            }

            /*
            |----------------------------------------------------------
            | Envoi emails en queue
            |----------------------------------------------------------
            */

            try {

                Mail::to($order->customer_email)
                    ->queue(new OrderConfirmation($order));

                Mail::to(config('mail.admin_email'))
                    ->queue(new NewOrderAdmin($order));

            } catch (\Exception $e) {

                Log::error('PayDunya webhook mail error', [
                    'error' => $e->getMessage(),
                    'order_id' => $order->id
                ]);
            }

            Log::info('PayDunya payment processed successfully', [
                'order_id' => $order->id,
                'token' => $token
            ]);

            return response()->json([
                'message' => 'Payment processed successfully'
            ], 200);

        } catch (\Exception $e) {

            Log::error('PayDunya webhook fatal error', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'error' => 'Server error'
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
