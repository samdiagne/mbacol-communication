<?php

namespace App\Services\Payment;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WavePaymentGateway implements PaymentGatewayInterface
{
    private string $apiUrl;
    private string $apiKey;
    private bool $sandboxMode;

    public function __construct()
    {
        $this->apiUrl = config('payment.wave.api_url');
        $this->apiKey = config('payment.wave.api_key');
        $this->sandboxMode = config('payment.wave.sandbox', true);
    }

    public function initiate(Order $order, string $phoneNumber): array
    {
        // MODE SANDBOX - Simulation
        if ($this->sandboxMode) {
            return $this->simulatePayment($order, $phoneNumber);
        }

        // MODE PRODUCTION - Vraie API Wave
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl . '/checkout/sessions', [
                'amount' => $order->total,
                'currency' => 'XOF',
                'client_reference' => $order->order_number,
                'success_url' => route('payment.success', $order),
                'error_url' => route('payment.error', $order),
                'customer' => [
                    'name' => $order->customer_name,
                    'email' => $order->customer_email,
                    'phone' => $phoneNumber,
                ],
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'transaction_id' => $response->json('id'),
                    'checkout_url' => $response->json('wave_launch_url'),
                    'message' => 'Paiement initié avec succès',
                ];
            }

            return [
                'success' => false,
                'message' => 'Erreur lors de l\'initialisation du paiement',
                'error' => $response->json('message'),
            ];

        } catch (\Exception $e) {
            Log::error('Wave Payment Error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Erreur de connexion à Wave',
            ];
        }
    }

    public function checkStatus(string $transactionId): array
    {
        if ($this->sandboxMode) {
            // Simulation : retourne succès aléatoire
            return [
                'success' => true,
                'status' => 'completed',
                'transaction_id' => $transactionId,
            ];
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
            ])->get($this->apiUrl . '/checkout/sessions/' . $transactionId);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'status' => $response->json('status'),
                    'transaction_id' => $transactionId,
                ];
            }

            return ['success' => false];

        } catch (\Exception $e) {
            Log::error('Wave Status Check Error: ' . $e->getMessage());
            return ['success' => false];
        }
    }

    public function validateWebhook(array $data): bool
    {
        // Validation signature webhook Wave
        return true; // À implémenter avec vraie clé secrète
    }

    /**
     * Simulation pour le développement
     */
    private function simulatePayment(Order $order, string $phoneNumber): array
    {
        $transactionId = 'WAVE-SIM-' . strtoupper(uniqid());
        
        Log::info('Wave Payment Simulation', [
            'order' => $order->order_number,
            'amount' => $order->total,
            'phone' => $phoneNumber,
            'transaction_id' => $transactionId,
        ]);

        return [
            'success' => true,
            'transaction_id' => $transactionId,
            'checkout_url' => route('payment.simulate', ['order' => $order, 'method' => 'wave']),
            'message' => '✅ Mode Sandbox - Paiement simulé',
            'sandbox' => true,
        ];
    }
}