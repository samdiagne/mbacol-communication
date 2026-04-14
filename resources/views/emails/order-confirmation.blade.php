<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation commande #{{ $order->order_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif;
            background: #f3f4f6;
            padding: 20px;
            color: #1f2937;
            line-height: 1.6;
        }
        
        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .header {
            background: linear-gradient(135deg, #141dce 0%, #e03529 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }
        
        .logo {
            margin-bottom: 20px;
        }
        
        .logo img {
            height: 50px;
            max-width: 200px;
        }
        
        .header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 10px 0;
        }
        
        .header p {
            font-size: 16px;
            opacity: 0.95;
            margin: 0;
        }
        
        .content {
            padding: 40px 30px;
        }
        
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #1f2937;
        }
        
        .order-number {
            display: inline-block;
            background: #eff6ff;
            color: #0284c7;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 20px;
            font-weight: 700;
            margin: 20px 0;
        }
        
        .date {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 30px;
        }
        
        .info-box {
            background: #f9fafb;
            border-left: 4px solid #0284c7;
            padding: 20px;
            border-radius: 8px;
            margin: 25px 0;
        }
        
        .info-box strong {
            color: #0284c7;
            font-size: 16px;
            display: block;
            margin-bottom: 12px;
        }
        
        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: #1f2937;
            margin: 30px 0 15px 0;
            padding-bottom: 8px;
            border-bottom: 2px solid #e5e7eb;
        }
        
        .item {
            padding: 15px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .item:last-child {
            border-bottom: none;
        }
        
        .item-name {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 8px;
        }
        
        .item-details {
            color: #6b7280;
            font-size: 14px;
        }
        
        .item-total {
            font-weight: 700;
            color: #0284c7;
            margin-top: 5px;
        }
        
        .total-table {
            width: 100%;
            margin: 25px 0;
            font-size: 15px;
        }
        
        .total-table td {
            padding: 8px 0;
        }
        
        .total-table .grand-total td {
            padding-top: 15px;
            border-top: 2px solid #e5e7eb;
            font-size: 20px;
            font-weight: 700;
            color: #0284c7;
        }
        
        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }
        
        .badge-success {
            background: #dcfce7;
            color: #166534;
        }
        
        .badge-pending {
            background: #fef3c7;
            color: #92400e;
        }
        
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #0284c7 0%, #c026d3 100%);
            color: white !important;
            padding: 14px 32px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            margin: 20px 0;
            box-shadow: 0 4px 6px rgba(2, 132, 199, 0.25);
        }
        
        .btn:hover {
            opacity: 0.9;
        }
        
        .alert {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 20px;
            border-radius: 8px;
            margin: 25px 0;
        }
        
        .alert strong {
            color: #92400e;
            display: block;
            margin-bottom: 8px;
        }
        
        .footer {
            background: #1f2937;
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .footer p {
            margin: 5px 0;
            font-size: 14px;
        }
        
        .footer a {
            color: #60a5fa;
            text-decoration: none;
        }
        
        .contact-box {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            padding: 20px;
            border-radius: 8px;
            margin: 25px 0;
        }
        
        .contact-box strong {
            display: block;
            margin-bottom: 12px;
            color: #0c4a6e;
        }
        
        .contact-item {
            margin: 8px 0;
            color: #0c4a6e;
        }
        
        @media only screen and (max-width: 600px) {
            body {
                padding: 10px;
            }
            
            .content {
                padding: 25px 20px;
            }
            
            .header {
                padding: 30px 20px;
            }
            
            .header h1 {
                font-size: 24px;
            }
            
            .btn {
                display: block;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <!-- Texte preview (visible dans la liste des emails) -->
    <div style="display:none;max-height:0;overflow:hidden;">
        ✅ Votre commande {{ $order->order_number }} a bien été reçue. Merci pour votre confiance !
    </div>
    
    <div class="email-wrapper">
        <!-- Header -->
        <div class="header">
            <div class="logo">
                {{-- ⚠️ REMPLACE CE LIEN PAR TON LOGO HÉBERGÉ SUR IMGBB --}}
                <img src="https://res.cloudinary.com/dangqmau0/image/upload/ar_1:1,c_auto,w_2000/mbacol_logo_y25xc8.png" alt="Mbacol Communication" height="50">
            </div>
            <h1>🎉 Merci pour votre commande !</h1>
            <p>Votre commande a bien été enregistrée</p>
        </div>
        
        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Bonjour <strong>{{ $order->customer_name }}</strong>,
            </div>
            
            <p style="margin-bottom: 20px;">
                Nous avons bien reçu votre commande et nous vous remercions pour votre confiance. 
                Nous préparons votre colis avec soin.
            </p>
            
            <div class="order-number">
                Commande #{{ $order->order_number }}
            </div>
            
            <div class="date">
                📅 Passée le {{ $order->created_at->locale('fr')->isoFormat('dddd D MMMM YYYY à HH:mm') }}
            </div>
            
            <!-- Adresse de livraison -->
            <div class="info-box">
                <strong>🚚 Informations de livraison</strong>
                <div>
                    {{ $order->customer_name }}<br>
                    {{ $order->customer_address }}<br>
                    {{ $order->customer_city }}, Sénégal<br>
                    📞 {{ $order->customer_phone }}
                </div>
            </div>
            
            <!-- Articles commandés -->
            <div class="section-title">
                📦 Récapitulatif de votre commande ({{ $order->items->count() }} article{{ $order->items->count() > 1 ? 's' : '' }})
            </div>
            
            @foreach($order->items as $item)
            <div class="item">
                <div class="item-name">{{ $item->product_name }}</div>
                <div class="item-details">
                    Quantité : {{ $item->quantity }} × {{ number_format($item->price, 0, ',', ' ') }} FCFA
                </div>
                <div class="item-total">
                    Total : {{ number_format($item->price * $item->quantity, 0, ',', ' ') }} FCFA
                </div>
            </div>
            @endforeach
            
            <!-- Totaux -->
            <table class="total-table">
                <tr>
                    <td>Sous-total</td>
                    <td align="right">{{ number_format($order->subtotal, 0, ',', ' ') }} FCFA</td>
                </tr>
                <tr>
                    <td>Frais de livraison</td>
                    <td align="right">{{ number_format($order->shipping_cost, 0, ',', ' ') }} FCFA</td>
                </tr>
                <tr class="grand-total">
                    <td>TOTAL</td>
                    <td align="right">{{ $order->formatted_total }}</td>
                </tr>
            </table>
            
            <!-- Informations paiement -->
            <div class="info-box">
                <strong>💳 Informations de paiement</strong>
                <div>
                    <strong>Méthode :</strong> 
                    @if($order->payment_method === 'paydunya')
                        Paiement en ligne (PayDunya)
                    @elseif($order->payment_method === 'cash')
                        Espèces à la livraison
                    @else
                        {{ $order->payment_method_label }}
                    @endif
                    <br><br>
                    
                    <strong>Statut :</strong> 
                    @if($order->payment_status === 'paid')
                        <span class="badge badge-success">✅ Payé</span>
                    @else
                        <span class="badge badge-pending">⏳ En attente</span>
                    @endif
                </div>
            </div>
            
            <!-- Délai de livraison -->
            <div class="info-box" style="border-color: #10b981; background: #f0fdf4;">
                <strong style="color: #065f46;">🚚 Livraison estimée</strong>
                <div style="color: #065f46;">
                    @if($order->customer_city === 'Dakar')
                        <strong>24 à 48 heures</strong> pour Dakar
                    @else
                        <strong>3 à 5 jours ouvrés</strong> pour les régions
                    @endif
                </div>
            </div>
            
            <!-- Alert paiement si cash -->
            @if($order->payment_method === 'cash')
            <div class="alert">
                <strong>💰 Paiement à la livraison</strong>
                Préparez le montant exact de <strong>{{ $order->formatted_total }}</strong> 
                pour faciliter la livraison.
            </div>
            @endif
            
            <!-- Bouton suivi -->
            <div style="text-align: center; margin: 25px 0;">
                <a href="{{ route('customer.orders.index') }}" class="btn">
                    📦 Suivre ma commande
                </a>
            </div>
            
            <!-- Contact -->
            <div class="contact-box">
                <strong>💬 Besoin d'aide ?</strong>
                <div class="contact-item">📞 WhatsApp : <a href="https://wa.me/221784465192" style="color: #0c4a6e;">+221 78 446 51 92</a></div>
                <div class="contact-item">📧 Email : contact@mbacol313.com</div>
                <div class="contact-item">⏰ Lun-Sam : 8h00 - 20h00</div>
            </div>
            
            <p style="text-align: center; color: #6b7280; font-size: 14px; margin-top: 30px;">
                Merci de faire confiance à Mbacol Communication ! 🎉
            </p>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p><strong>Mbacol Communication</strong></p>
            <p>Colobane rue 43×45, Dakar, Sénégal</p>
            <p>📞 +221 78 446 51 92 • 📧 contact@mbacol313.com</p>
            <p style="margin-top: 15px; font-size: 12px; opacity: 0.8;">
                © {{ date('Y') }} Mbacol Communication. Tous droits réservés.
            </p>
        </div>
    </div>
</body>
</html>