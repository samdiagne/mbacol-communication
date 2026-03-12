<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'payment_method',
        'transaction_id',
        'payment_status',
        'amount',
        'phone_number',
        'response_data',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    // Relations
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Accesseurs
    public function getPaymentMethodLabelAttribute()
    {
        // Note: payment_method dans la table Payment = toujours 'paydunya' ou 'cash'
        // Le choix réel (wave, orange_money, etc.) est dans order.payment_method
        
        if ($this->payment_method === 'cash') {
            return 'Espèces à la livraison';
        }
        
        if ($this->payment_method === 'paydunya') {
            // Récupérer le choix réel depuis la commande
            $orderMethod = $this->order->payment_method ?? 'paydunya';
            
            return match($orderMethod) {
                'wave' => 'Wave',
                'orange_money' => 'Orange Money',
                'free_money' => 'Free Money (Mixx)',
                'card' => 'Carte Bancaire',
                default => 'Paiement en ligne',
            };
        }
        
        return $this->payment_method;
    }

    public function getStatusLabelAttribute()
    {
        return match($this->payment_status) {
            'pending' => 'En attente',
            'completed' => 'Payé',
            'failed' => 'Échoué',
            'cancelled' => 'Annulé',
            default => $this->payment_status,
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->payment_status) {
            'pending' => 'yellow',
            'completed' => 'green',
            'failed' => 'red',
            'cancelled' => 'gray',
            default => 'gray',
        };
    }
}