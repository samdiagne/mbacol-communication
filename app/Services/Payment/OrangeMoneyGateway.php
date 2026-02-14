<?php

namespace App\Services\Payment;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OrangeMoneyGateway implements PaymentGatewayInterface
{
    private string $apiUrl;
    private string $merchantKey;
    private bool $sandboxMode;

    public function __construct()
    {
        $this->apiUrl = config('payment.orange.api_url', 'https://api.orange.com');
        $this->merchantKey = config('payment.orange.merchant_key', '');
        $this->sandboxMode = config('payment.orange.sandbox', true);
    }

    public function initiate(Order $order, string $phoneNumber): array
    {
        if ($this->sandboxMode) {
            return $this->simulatePayment($order, $phoneNumber);
        }

        // API Orange Money (à adapter selon leur documentation)
        try {
            // Obtenir un token OAuth
            $tokenResponse = $this->getAccessToken();
            
            if (!$tokenResponse['success']) {
                return $tokenResponse;
            }

            // Initier le paiement
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $tokenResponse['token'],
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl . '/omcoreapis/1.0.2/mp/pay', [
                'subscriber_msisdn' => $phoneNumber,
                'merchant_msisdn' => config('payment.orange.merchant_phone'),
                'amount' => $order->total,
                'currency' => 'XOF',
                'order_id' => $order->order_number,
                'reference' => 'Mbacol-' . $order->id,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'success' => true,
                    'transaction_id' => $data['transaction_id'] ?? 'OM-' . uniqid(),
                    'message' => 'Paiement initié. Veuillez valider sur votre téléphone.',
                ];
            }

            return [
                'success' => false,
                'message' => 'Erreur Orange Money',
                'error' => $response->json('message') ?? 'Erreur inconnue',
            ];

        } catch (\Exception $e) {
            Log::error('Orange Money Error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Erreur de connexion à Orange Money',
            ];
        }
    }

    public function checkStatus(string $transactionId): array
    {
        if ($this->sandboxMode) {
            return [
                'success' => true,
                'status' => 'completed',
                'transaction_id' => $transactionId,
            ];
        }

        try {
            $response = Http::get($this->apiUrl . '/transactions/' . $transactionId);
            
            if ($response->successful()) {
                return [
                    'success' => true,
                    'status' => $response->json('status') ?? 'pending',
                    'transaction_id' => $transactionId,
                ];
            }

            return ['success' => false];
        } catch (\Exception $e) {
            Log::error('Orange Money Status Check Error: ' . $e->getMessage());
            return ['success' => false];
        }
    }

    public function validateWebhook(array $data): bool
    {
        // Validation signature webhook Orange Money
        return true; // À implémenter avec vraie clé secrète
    }

    private function getAccessToken(): array
    {
        // OAuth Orange Money - à implémenter selon leur doc
        // Pour l'instant, retourne un token fictif
        return ['success' => true, 'token' => 'dummy-token'];
    }

    private function simulatePayment(Order $order, string $phoneNumber): array
    {
        $transactionId = 'OM-SIM-' . strtoupper(uniqid());
        
        Log::info('Orange Money Simulation', [
            'order' => $order->order_number,
            'amount' => $order->total,
            'phone' => $phoneNumber,
            'transaction_id' => $transactionId,
        ]);

        return [
            'success' => true,
            'transaction_id' => $transactionId,
            'checkout_url' => route('payment.simulate', ['order' => $order, 'method' => 'orange_money']),
            'message' => '✅ Mode Sandbox - Orange Money simulé',
            'sandbox' => true,
        ];
    }
}