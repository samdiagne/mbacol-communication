<?php

namespace App\Services\Payment;

use App\Models\Order;

interface PaymentGatewayInterface
{
    /**
     * Initialiser un paiement
     */
    public function initiate(Order $order, string $phoneNumber): array;

    /**
     * Vérifier le statut d'un paiement
     */
    public function checkStatus(string $transactionId): array;

    /**
     * Valider un paiement (webhook)
     */
    public function validateWebhook(array $data): bool;
}