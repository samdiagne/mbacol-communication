<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Services\Payment\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Page de simulation de paiement (mode sandbox)
     */
    public function simulate(Request $request, Order $order)
    {
        $method = $request->query('method', 'wave');
        
        return view('payment.simulate', [
            'order' => $order,
            'method' => $method,
        ]);
    }

    /**
     * Confirmation de paiement simulé
     */
    public function simulateConfirm(Request $request, Order $order)
    {
        $action = $request->input('action'); // success ou cancel

        $payment = Payment::where('order_id', $order->id)->latest()->first();

        if ($action === 'success' && $payment) {
            // Marquer comme payé
            $this->paymentService->confirmPayment($payment);
            
            return redirect()->route('order.confirmation', $order)
                ->with('success', '✅ Paiement simulé avec succès !');
        } else {
            // Paiement annulé
            if ($payment) {
                $payment->update(['payment_status' => 'cancelled']);
            }
            
            return redirect()->route('checkout')
                ->with('error', '❌ Paiement annulé. Veuillez réessayer.');
        }
    }

    /**
     * Callback succès (production)
     */
    public function success(Order $order)
    {
        $payment = Payment::where('order_id', $order->id)->latest()->first();

        if ($payment && $payment->payment_status === 'completed') {
            return redirect()->route('order.confirmation', $order);
        }

        // Vérifier le statut auprès de l'opérateur
        $gateway = $this->paymentService->getGateway($order->payment_method);
        $status = $gateway->checkStatus($payment->transaction_id);

        if ($status['success'] && $status['status'] === 'completed') {
            $this->paymentService->confirmPayment($payment);
            return redirect()->route('order.confirmation', $order);
        }

        return redirect()->route('checkout')
            ->with('error', 'Erreur de vérification du paiement');
    }

    /**
     * Callback erreur (production)
     */
    public function error(Order $order)
    {
        $payment = Payment::where('order_id', $order->id)->latest()->first();
        
        if ($payment) {
            $payment->update(['payment_status' => 'failed']);
        }

        return redirect()->route('checkout')
            ->with('error', 'Le paiement a échoué. Veuillez réessayer.');
    }

    /**
     * Webhook (production)
     */
    public function webhook(Request $request, string $provider)
    {
        try {
            $gateway = $this->paymentService->getGateway($provider);
            
            if (!$gateway->validateWebhook($request->all())) {
                return response()->json(['error' => 'Invalid signature'], 403);
            }

            // Traiter le webhook selon le provider
            $transactionId = $request->input('transaction_id');
            $status = $request->input('status');

            $payment = Payment::where('transaction_id', $transactionId)->first();

            if ($payment && $status === 'completed') {
                $this->paymentService->confirmPayment($payment);
            }

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            \Log::error('Webhook error: ' . $e->getMessage());
            return response()->json(['error' => 'Processing failed'], 500);
        }
    }
}