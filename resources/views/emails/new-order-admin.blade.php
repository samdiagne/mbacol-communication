<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🛍️ Nouvelle commande #{{ $order->order_number }}</title>
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
            max-width: 650px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .header {
            background: linear-gradient(135deg, #141dce 0%, #e03529 100%);
            padding: 35px 30px;
            text-align: center;
            color: white;
        }
        
        .logo img {
            height: 50px;
            margin-bottom: 15px;
        }
        
        .header h1 {
            font-size: 26px;
            margin: 0 0 8px 0;
        }
        
        .content {
            padding: 35px 30px;
        }
        
        .alert-new {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-size: 15px;
        }
        
        .order-number {
            display: inline-block;
            background: #dbeafe;
            color: #1e40af;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 22px;
            font-weight: 700;
            margin: 15px 0;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin: 25px 0;
        }
        
        .info-card {
            background: #f9fafb;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #0284c7;
        }
        
        .info-card-title {
            font-weight: 700;
            color: #0284c7;
            margin-bottom: 12px;
            font-size: 16px;
        }
        
        .info-line {
            margin: 8px 0;
            font-size: 14px;
        }
        
        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: #1f2937;
            margin: 30px 0 15px 0;
            padding-bottom: 8px;
            border-bottom: 2px solid #e5e7eb;
        }
        
        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 14px;
        }
        
        .product-table th {
            background: #f3f4f6;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            color: #374151;
            border-bottom: 2px solid #e5e7eb;
        }
        
        .product-table td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .product-table .total-row td {
            font-weight: 700;
            padding-top: 15px;
            border-top: 2px solid #e5e7eb;
            border-bottom: none;
        }
        
        .grand-total {
            font-size: 20px;
            color: #0284c7;
            text-align: right;
            margin: 15px 0;
        }
        
        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }
        
        .badge-paid {
            background: #dcfce7;
            color: #166534;
        }
        
        .badge-pending {
            background: #fef3c7;
            color: #92400e;
        }
        
        .action-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 10px;
            margin: 30px 0;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            text-align: center;
            font-size: 14px;
        }
        
        .btn-call {
            background: #4762c6;
            color: white !important;
        }
        
        .btn-whatsapp {
            background: #25D366;
            color: white !important;
        }
        
        .btn-map {
            background: #d9cf5c;
            color: white !important;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #0284c7 0%, #c026d3 100%);
            color: white !important;
            padding: 14px 28px;
            margin: 20px 0;
            display: inline-block;
        }
        
        .footer {
            background: #1f2937;
            color: white;
            padding: 25px;
            text-align: center;
            font-size: 13px;
        }
        
        @media only screen and (max-width: 600px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
            
            .action-buttons {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <!-- Header -->
        <div class="header">
            <div class="logo">
                {{-- ⚠️ MÊME LIEN LOGO QUE L'EMAIL CLIENT --}}
                <img src="https://res.cloudinary.com/dangqmau0/image/upload/ar_1:1,c_auto,w_2000/mbacol_logo_y25xc8.png" alt="Mbacol Communication" height="50">
            </div>
            <h1>🛍️ Nouvelle Commande Reçue</h1>
            <p>Une commande vient d'être passée sur le site</p>
        </div>
        
        <!-- Content -->
        <div class="content">
            <div class="alert-new">
                <strong>⚡ Action requise :</strong> Une nouvelle commande nécessite votre attention.
            </div>
            
            <div class="order-number">
                Commande #{{ $order->order_number }}
            </div>
            
            <div style="color: #6b7280; font-size: 14px; margin-bottom: 25px;">
                📅 {{ $order->created_at->locale('fr')->isoFormat('dddd D MMMM YYYY à HH:mm') }}
            </div>
            
            <!-- Info Client & Paiement -->
            <div class="info-grid">
                <!-- Client -->
                <div class="info-card">
                    <div class="info-card-title">👤 Informations Client</div>
                    <div class="info-line"><strong>{{ $order->customer_name }}</strong></div>
                    <div class="info-line">📧 {{ $order->customer_email }}</div>
                    <div class="info-line">📞 {{ $order->customer_phone }}</div>
                </div><br>
                
                <!-- Paiement -->
                <div class="info-card" style="border-color: #10b981;">
                    <div class="info-card-title" style="color: #10b981;">💳 Paiement</div>
                    <div class="info-line">
                        <strong>Méthode :</strong>
                        @if($order->payment_method === 'paydunya')
                            PayDunya
                        @elseif($order->payment_method === 'cash')
                            Espèces
                        @else
                            {{ $order->payment_method_label }}
                        @endif
                    </div>
                    <div class="info-line">
                        <strong>Statut :</strong>
                        @if($order->payment_status === 'paid')
                            <span class="badge badge-paid">✅ Payé</span>
                        @else
                            <span class="badge badge-pending">⏳ En attente</span>
                        @endif
                    </div>
                    <div class="info-line" style="margin-top: 10px; font-size: 18px; font-weight: 700; color: #10b981;">
                        {{ $order->formatted_total }}
                    </div>
                </div>
            </div>
            
            <!-- Adresse de livraison -->
            <div class="info-card" style="border-color: #f59e0b;">
                <div class="info-card-title" style="color: #f59e0b;">🚚 Adresse de Livraison</div>
                <div class="info-line">
                   📍{{ $order->customer_address }}<br><br>
                    {{ $order->customer_city }}, Sénégal<br><br>
                </div>
            </div>
            
            <!-- Articles -->
            <div class="section-title">📦 Articles Commandés ({{ $order->items->count() }})</div>
            
            <table class="product-table">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th style="text-align: center;">Qté</th>
                        <th style="text-align: right;">Prix Unit.</th>
                        <th style="text-align: right;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td><strong>{{ $item->product_name }}</strong></td>
                        <td style="text-align: center;">{{ $item->quantity }}</td>
                        <td style="text-align: right;">{{ number_format($item->price, 0, ',', ' ') }} F</td>
                        <td style="text-align: right;"><strong>{{ number_format($item->price * $item->quantity, 0, ',', ' ') }} F</strong></td>
                    </tr>
                    @endforeach
                    
                    <tr>
                        <td colspan="3" style="text-align: right; padding-top: 15px; border-top: 2px solid #e5e7eb;">Sous-total</td>
                        <td style="text-align: right; padding-top: 15px; border-top: 2px solid #e5e7eb;">{{ number_format($order->subtotal, 0, ',', ' ') }} F</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: right;">Livraison</td>
                        <td style="text-align: right;">{{ number_format($order->shipping_cost, 0, ',', ' ') }} F</td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="3" style="text-align: right; font-size: 18px; color: #0284c7;">TOTAL</td>
                        <td style="text-align: right; font-size: 18px; color: #0284c7;">{{ $order->formatted_total }}</td>
                    </tr>
                </tbody>
            </table>
            
            <!-- Actions rapides -->
            <div class="section-title">⚡ Actions Rapides</div>
            
            <div class="action-buttons">
                <a href="tel:{{ $order->customer_phone }}" class="btn btn-call">
                    📞 Appeler
                </a><br>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->customer_phone) }}" class="btn btn-whatsapp" target="_blank">
                    💬 WhatsApp
                </a><br>
                <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($order->customer_address . ' ' . $order->customer_city) }}" class="btn btn-map" target="_blank">
                    📍 Localiser
                </a><br>
            </div>
            
            <!-- Bouton admin -->
            <div style="text-align: center; margin: 25px 0;">
                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-primary">
                    🔐 Gérer la Commande
                </a>
            </div>
            
            <!-- Checklist -->
            <div class="info-card" style="border-color: #8b5cf6; background: #faf5ff;">
                <div class="info-card-title" style="color: #7c3aed;">✅ Checklist</div>
                <div class="info-line">☐ Vérifier le paiement</div>
                <div class="info-line">☐ Préparer la commande</div>
                <div class="info-line">☐ Contacter le client</div>
                <div class="info-line">☐ Organiser la livraison</div>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p><strong>Notification automatique - Mbacol Communication</strong></p>
            <p>Ne pas répondre à cet email</p>
        </div>
    </div>
</body>
</html>