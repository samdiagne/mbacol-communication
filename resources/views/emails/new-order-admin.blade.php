<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .alert { background: #3b82f6; color: white; padding: 20px; border-radius: 8px; text-align: center; }
        .content { background: #fff; padding: 30px; border: 1px solid #e5e7eb; margin-top: 20px; }
        .btn { display: inline-block; background: #3b82f6; color: white; padding: 12px 30px; text-decoration: none; border-radius: 6px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="alert">
            <h1 style="margin: 0;">🔔 Nouvelle Commande !</h1>
        </div>

        <div class="content">
            <h2>Commande #{{ $order->order_number }}</h2>
            
            <p><strong>Client :</strong> {{ $order->customer_name }}</p>
            <p><strong>Email :</strong> {{ $order->customer_email }}</p>
            <p><strong>Téléphone :</strong> {{ $order->customer_phone }}</p>
            <p><strong>Adresse :</strong> {{ $order->customer_address }}, {{ $order->customer_city }}</p>

            <h3>Articles ({{ $order->items->count() }})</h3>
            @foreach($order->items as $item)
            <p>• {{ $item->product_name }} × {{ $item->quantity }}</p>
            @endforeach

            <h3 style="color: #3b82f6;">Total: {{ $order->formatted_total }}</h3>
            <p>
                <strong>Paiement :</strong> @if($order->payment_method === 'paydunya')
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
            </p>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('admin.orders.show', $order) }}" class="btn">
                    Voir la commande
                </a>
            </div>
        </div>
    </div>
</body>
</html>