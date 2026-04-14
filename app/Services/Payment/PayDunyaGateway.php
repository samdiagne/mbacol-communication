<?php

namespace App\Services\Payment;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PayDunyaGateway implements PaymentGatewayInterface
{
    private string $baseUrl;
    private string $masterKey;
    private string $privateKey;
    private string $token;
    private bool $testMode;

    public function __construct()
    {
        $this->testMode = config('paydunya.mode') === 'test';
        $this->baseUrl = $this->testMode 
            ? 'https://app.paydunya.com/sandbox-api/v1'
            : 'https://app.paydunya.com/api/v1';
            
        $this->masterKey = config('paydunya.master_key');
        $this->privateKey = config('paydunya.private_key');
        $this->token = config('paydunya.token');
        $this->validateUrls();
    }

    /**
     * Initier un paiement PayDunya
     */
    public function initiate(Order $order, ?string $phoneNumber = null): array
    {
        try {
            // Headers requis par PayDunya
            $headers = [
                'PAYDUNYA-MASTER-KEY' => $this->masterKey,
                'PAYDUNYA-PRIVATE-KEY' => $this->privateKey,
                'PAYDUNYA-TOKEN' => $this->token,
                'Content-Type' => 'application/json',
            ];

            // Préparer les items de la commande
            $items = [];
            foreach ($order->items as $item) {
                $items[] = [
                    'name' => $item->product_name,
                    'quantity' => $item->quantity,
                    'unit_price' => (string) $item->price,
                    'total_price' => (string) $item->total,
                    'description' => '',
                ];
            }

            // Données de la facture
            $payload = [
                'invoice' => [
                    'total_amount' => (float) $order->total,
                    'description' => "Commande #{$order->order_number}",
                    'items' => $items,
                ],
                'store' => [
                    'name' => config('paydunya.store_name', 'Mbacol Communication'),
                    'tagline' => config('paydunya.store_tagline', 'E-commerce Sénégal'),
                    'postal_address' => $order->customer_address ?? '',
                    'phone' => $order->customer_phone ?? '',
                    'logo_url' => config('paydunya.store_logo', ''),
                    'website_url' => config('paydunya.store_url'),
                ],
                'actions' => [
                    'cancel_url' => config('paydunya.urls.cancel_url'),
                    'return_url' => config('paydunya.urls.return_url'),
                    'callback_url' => config('paydunya.urls.callback_url'),
                ],
                'custom_data' => [
                    'order_id' => (string) $order->id,
                    'order_number' => $order->order_number,
                    'customer_name' => $order->customer_name,
                    'customer_email' => $order->customer_email,
                    'customer_phone' => $order->customer_phone,
                ],
            ];

            // Log de la requête
            if (config('paydunya.log_requests')) {
                Log::info('PayDunya: Initiate payment', [
                    'order_id' => $order->id,
                    'amount' => $order->total,
                    'mode' => $this->testMode ? 'test' : 'live',
                ]);
            }

            // Appel API PayDunya (retry natif Laravel)
            $response = Http::withHeaders($headers)
                ->timeout(30)
                ->retry(3, 1000)
                ->post($this->baseUrl . '/checkout-invoice/create', $payload);

            if (!$response->successful()) {
                Log::error('PayDunya API Error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return [
                    'success' => false,
                    'message' => 'Erreur de connexion à PayDunya',
                ];
            }

            $data = $response->json();

            // Vérifier la réponse
            if (isset($data['response_code']) && $data['response_code'] === '00') {
                return [
                    'success' => true,
                    'transaction_id' => $data['token'],
                    'checkout_url' => $data['response_text'],
                    'message' => 'Redirection vers la page de paiement...',
                ];
            }

            return [
                'success' => false,
                'message' => $data['response_text'] ?? 'Erreur lors de la création de la facture',
            ];

        } catch (\Exception $e) {
            Log::error('PayDunya Exception: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Erreur de connexion au service de paiement',
            ];
        }
    }

    /**
     * Vérifier le statut d'un paiement
     */
    public function checkStatus(string $transactionId): array
    {
        try {
            $headers = [
                'PAYDUNYA-MASTER-KEY' => $this->masterKey,
                'PAYDUNYA-PRIVATE-KEY' => $this->privateKey,
                'PAYDUNYA-TOKEN' => $this->token,
            ];

            $response = Http::withHeaders($headers)
                ->timeout(30)
                ->get($this->baseUrl . '/checkout-invoice/confirm/' . $transactionId);

            if (!$response->successful()) {
                return [
                    'success' => false,
                    'status' => 'failed',
                ];
            }

            $data = $response->json();

            // PayDunya renvoie un statut
            $status = strtolower($data['status'] ?? '');

            $invoiceAmount = (float) ($data['invoice']['total_amount'] ?? 0);
            
            return [
                'success' => true,
                'status' => $status === 'completed' ? 'completed' : 'pending',
                'transaction_id' => $transactionId,
                'data' => [
                    'amount' => $invoiceAmount,
                    'receipt_url' => $data['receipt_url'] ?? null,
                    'customer' => $data['customer'] ?? [],
                    'payment_method' => $data['customer']['payment_method'] ?? 'unknown',
                ],
            ];

        } catch (\Exception $e) {
            Log::error('PayDunya Status Check Error: ' . $e->getMessage());
            
            return [
                'success' => false,
                'status' => 'failed',
            ];
        }
    }

    /**
     * Valider la signature du webhook PayDunya
     */
    public function validateWebhook(array $data): bool
    {
        // Mode test → bypass signature (pour debug)
        if ($this->testMode) {
            Log::info('PayDunya Webhook: Skipping hash validation (TEST MODE)');
            return true;
        }

        // Extraire le hash reçu
        $receivedHash = $data['hash'] ?? null;
        
        if (empty($receivedHash)) {
            Log::warning('PayDunya Webhook: Missing hash in payload');
            return false;
        }

        // Extraire le payload data
        $payload = $data['data'] ?? null;
        
        if (empty($payload)) {
            Log::warning('PayDunya Webhook: Missing data in payload');
            return false;
        }

        // PayDunya calcule le hash avec HMAC-SHA512
        // Hash = HMAC-SHA512(JSON(data), MASTER_KEY)
        $expectedHash = hash_hmac(
            'sha512',
            json_encode($payload),
            $this->masterKey
        );

        Log::info('PayDunya Webhook: Hash validation', [
            'received' => substr($receivedHash, 0, 20) . '...',
            'expected' => substr($expectedHash, 0, 20) . '...',
            'match' => hash_equals($expectedHash, $receivedHash),
        ]);

        return hash_equals($expectedHash, $receivedHash);
    }

    /**
     * Valider que les URLs de callback sont en HTTPS en production
     */
    private function validateUrls(): void
    {
        if (!$this->testMode) {
            $urls = [
                'cancel_url' => config('paydunya.urls.cancel_url'),
                'return_url' => config('paydunya.urls.return_url'),
                'callback_url' => config('paydunya.urls.callback_url'),
            ];

            foreach ($urls as $name => $url) {
                if (!str_starts_with($url, 'https://')) {
                    throw new \Exception("PayDunya {$name} must be HTTPS in production mode. Got: {$url}");
                }
            }
        }
    }

    /**
     * Obtenir les informations de configuration pour debug
     */
    public function getConfig(): array
    {
        return [
            'mode' => $this->testMode ? 'test' : 'live',
            'base_url' => $this->baseUrl,
            'has_master_key' => !empty($this->masterKey),
            'has_private_key' => !empty($this->privateKey),
            'has_token' => !empty($this->token),
        ];
    }

    public function isTestMode(): bool
{
    return $this->testMode;
}
}