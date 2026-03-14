<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Service WhatsApp - DÉSACTIVÉ pour l'instant
     * 
     * Ce service sera activé plus tard avec Meta WhatsApp Business API
     * Pour l'activer : configurer .env avec WHATSAPP_ENABLED=true
     */
    
    private bool $enabled;

    public function __construct()
    {
        // Désactivé par défaut
        $this->enabled = config('services.whatsapp.enabled', false);
    }

    /**
     * Envoyer confirmation de commande au client
     */
    public function sendOrderConfirmationToCustomer(Order $order): bool
    {
        if (!$this->enabled) {
            Log::info('WhatsApp désactivé - notification client ignorée', [
                'order_id' => $order->id
            ]);
            return false;
        }

        // TODO: Implémenter l'envoi WhatsApp avec Meta API
        Log::info('WhatsApp: Confirmation client à implémenter', [
            'order_id' => $order->id,
            'customer_phone' => $order->customer_phone,
        ]);

        return true;
    }

    /**
     * Envoyer notification de nouvelle commande à l'admin
     */
    public function sendNewOrderToAdmin(Order $order): bool
    {
        if (!$this->enabled) {
            Log::info('WhatsApp désactivé - notification admin ignorée', [
                'order_id' => $order->id
            ]);
            return false;
        }

        // TODO: Implémenter l'envoi WhatsApp avec Meta API
        Log::info('WhatsApp: Notification admin à implémenter', [
            'order_id' => $order->id,
        ]);

        return true;
    }

    /**
     * Vérifier si WhatsApp est activé
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }
}