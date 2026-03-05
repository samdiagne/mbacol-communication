<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #3b82f6 0%, #ef4444 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #fff; padding: 30px; border: 1px solid #e5e7eb; }
        .order-number { font-size: 24px; font-weight: bold; color: #3b82f6; margin: 20px 0; }
        .info-box { background: #f9fafb; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .item { border-bottom: 1px solid #e5e7eb; padding: 15px 0; }
        .item:last-child { border-bottom: none; }
        .total { font-size: 20px; font-weight: bold; color: #3b82f6; text-align: right; margin-top: 20px; }
        .footer { background: #1f2937; color: white; padding: 20px; text-align: center; border-radius: 0 0 10px 10px; }
        .btn { display: inline-block; background: #3b82f6; color: white; padding: 12px 30px; text-decoration: none; border-radius: 6px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin: 0;">
                <span style="color: white;">Mbacol</span>
                <span style="color: #fecaca;">Communication</span>
            </h1>
            <p style="margin: 10px 0 0 0; font-size: 18px;">Merci pour votre commande !</p>
        </div>

        <div class="content">
            <h2>Bonjour {{ $order->customer_name }},</h2>
            
            <p>Nous avons bien reçu votre commande et nous vous en remercions !</p>

            <div class="order-number">
                Commande #{{ $order->order_number }}
            </div>

            <div class="info-box">
                <strong>Détails de livraison :</strong><br>
                {{ $order->customer_name }}<br>
                {{ $order->customer_address }}<br>
                {{ $order->customer_city }}<br>
                Tél: {{ $order->customer_phone }}
            </div>

            <h3>Récapitulatif de votre commande</h3>

            @foreach($order->items as $item)
            <div class="item">
                <strong>{{ $item->product_name }}</strong><br>
                Quantité: {{ $item->quantity }} × {{ number_format($item->price, 0, ',', ' ') }} FCFA<br>
                <strong>Total: {{ $item->formatted_total }}</strong>
            </div>
            @endforeach

            <div style="margin-top: 20px; padding-top: 20px; border-top: 2px solid #3b82f6;">
                <table width="100%" style="font-size: 14px;">
                    <tr>
                        <td>Sous-total</td>
                        <td align="right">{{ number_format($order->subtotal, 0, ',', ' ') }} FCFA</td>
                    </tr>
                    <tr>
                        <td>Livraison</td>
                        <td align="right">{{ number_format($order->shipping_cost, 0, ',', ' ') }} FCFA</td>
                    </tr>
                    <tr style="font-size: 18px; font-weight: bold; color: #3b82f6;">
                        <td style="padding-top: 10px;">TOTAL</td>
                        <td align="right" style="padding-top: 10px;">{{ $order->formatted_total }}</td>
                    </tr>
                </table>
            </div>

            <div class="info-box" style="margin-top: 20px;">
                <strong>Mode de paiement :</strong> 
                @if($order->payment_method === 'paydunya')
                    @switch($order->payment_provider)
                        @case('wave')
                            Wave
                            @break
                        @case('orange_money')
                            Orange Money
                            @break
                        @case('free_money')
                            Free Money
                            @break
                        @case('card')
                            Carte Bancaire
                            @break
                        @default
                            Paiement en ligne (PayDunya)
                    @endswitch
                @elseif($order->payment_method === 'cash')
                    Espèces à la livraison
                @else
                    {{ ucfirst($order->payment_method) }}
                @endif
                <br>
                <strong>Statut :</strong> {{ $order->payment_status_label }}
            </div>

            @if($order->payment_method !== 'cash')
            <p style="background: #fef3c7; padding: 15px; border-left: 4px solid #f59e0b; border-radius: 4px;">
                📱 <strong>Instructions de paiement :</strong><br>
                Vous recevrez un SMS avec les instructions pour finaliser votre paiement via {{ $order->payment_method_label }}.
            </p>
            @endif

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('customer.orders.show', $order) }}" class="btn">
                    Suivre ma commande
                </a>
            </div>

            <p>Si vous avez des questions, n'hésitez pas à nous contacter :</p>
            <p>
                📞 +221 XX XXX XX XX<br>
                📧 contact@mbacol.sn
            </p>
        </div>

        <div class="footer">
            <p style="margin: 0;">© {{ date('Y') }} Mbacol Communication - Tous droits réservés</p>
            <p style="margin: 5px 0 0 0; font-size: 12px;">Dakar, Sénégal</p>
        </div>
    </div>
</body>
</html>