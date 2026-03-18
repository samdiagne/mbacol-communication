<?php

namespace App\Services\Payment;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    /**
     * Traiter un paiement selon la méthode choisie
     */
    public function processPayment(Order $order, ?string $phoneNumber = null): array
    {
        // Cash à la livraison = pas de paiement en ligne
        if ($order->payment_method === 'cash') {
            return $this->processCashPayment($order);
        }

        // Tous les autres modes passent par PayDunya
        // Wave, Orange Money, Free Money, Carte = tous via PayDunya
        try {
            $gateway = new PayDunyaGateway();
            $result = $gateway->initiate($order, $phoneNumber);

            if ($result['success']) {
                // Créer l'enregistrement Payment
                Payment::create([
                    'order_id' => $order->id,
                    'payment_method' => 'paydunya', // ✅ Gateway = PayDunya
                    'transaction_id' => $result['transaction_id'],
                    'payment_status' => 'pending',
                    'amount' => $order->total,
                    'phone_number' => $phoneNumber,
                    'response_data' => json_encode($result),
                ]);

                Log::info('Payment initiated via PayDunya', [
                    'order_id' => $order->id,
                    'selected_method' => $order->payment_method, // wave, orange_money, etc.
                    'transaction_id' => $result['transaction_id'],
                ]);
            }

            return $result;

        } catch (\Exception $e) {
            Log::error('Payment processing error: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Erreur lors du traitement du paiement',
            ];
        }
    }

    /**
     * Traiter un paiement cash (pas de paiement en ligne)
     */
    private function processCashPayment(Order $order): array
    {
        Payment::create([
            'order_id' => $order->id,
            'payment_method' => 'cash',
            'payment_status' => 'pending',
            'amount' => $order->total,
        ]);

        return [
            'success' => true,
            'message' => 'Commande enregistrée. Paiement à la livraison.',
        ];
    }

    /**
     * Confirmer un paiement (appelé par le webhook)
     */
    public function confirmPayment(Payment $payment): bool
    {
        $payment->update([
            'payment_status' => 'completed',
            'paid_at' => now(),
        ]);

        // Mettre à jour la commande
        $payment->order->update([
            'payment_status' => 'paid',
            'status' => 'confirmed',
        ]);

        return true;
    }
}