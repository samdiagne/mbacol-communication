<?php

namespace App\Services\Payment;

use App\Models\Order;
use App\Models\Payment;

class PaymentService
{
    public function getGateway(string $method): PaymentGatewayInterface
    {
        return match($method) {
            'wave' => new WavePaymentGateway(),
            'orange_money' => new OrangeMoneyGateway(),
            default => throw new \Exception('Méthode de paiement non supportée'),
        };
    }

    public function processPayment(Order $order, ?string $phoneNumber = null): array
    {
        // Cash à la livraison
        if ($order->payment_method === 'cash') {
            return $this->processCashPayment($order);
        }

        // Paiement mobile money
        try {
            $gateway = $this->getGateway($order->payment_method);
            $result = $gateway->initiate($order, $phoneNumber);

            if ($result['success']) {
                // Créer l'enregistrement Payment
                Payment::create([
                    'order_id' => $order->id,
                    'payment_method' => $order->payment_method,
                    'transaction_id' => $result['transaction_id'],
                    'payment_status' => 'pending',
                    'amount' => $order->total,
                    'phone_number' => $phoneNumber,
                    'response_data' => json_encode($result),
                ]);
            }

            return $result;
        } catch (\Exception $e) {
            \Log::error('Payment processing error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Erreur lors du traitement du paiement',
            ];
        }
    }

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

    public function confirmPayment(Payment $payment): bool
    {
        $payment->update([
            'payment_status' => 'completed',
            'paid_at' => now(),
        ]);

        // Mettre à jour la commande
        $payment->order->update([
            'payment_status' => 'paid',
        ]);

        return true;
    }
}