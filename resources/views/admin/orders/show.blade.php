@extends('layouts.admin')

@section('title', 'Commande ' . $order->order_number)

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.orders.index') }}" class="text-primary-600 hover:text-primary-800 mb-4 inline-block">
        ← Retour aux commandes
    </a>
    <div class="flex justify-between items-start">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Commande {{ $order->order_number }}</h1>
            <p class="text-gray-600">{{ $order->created_at->format('d/m/Y à H:i') }}</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Détails -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Produits -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4">Articles commandés</h2>
            <div class="space-y-4">
                @foreach($order->items as $item)
                <div class="flex gap-4 pb-4 border-b last:border-0">
                    <div class="w-20 h-20 bg-gray-100 rounded flex-shrink-0">
                        @if($item->product && $item->product->main_image)
                            <img src="{{ asset('storage/' . $item->product->main_image) }}" class="w-full h-full object-cover rounded">
                        @endif
                    </div>
                    <div class="flex-1">
                        <h3 class="font-semibold">{{ $item->product_name }}</h3>
                        <p class="text-sm text-gray-600">Quantité: {{ $item->quantity }}</p>
                        <p class="text-sm text-gray-600">Prix unitaire: {{ number_format($item->price, 0, ',', ' ') }} FCFA</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold">{{ $item->formatted_total }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Totaux -->
            <div class="mt-6 pt-6 border-t space-y-2">
                <div class="flex justify-between text-sm">
                    <span>Sous-total</span>
                    <span>{{ number_format($order->subtotal, 0, ',', ' ') }} FCFA</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span>Livraison</span>
                    <span>{{ number_format($order->shipping_cost, 0, ',', ' ') }} FCFA</span>
                </div>
                <div class="flex justify-between text-lg font-bold pt-2 border-t">
                    <span>Total</span>
                    <span class="text-primary-600">{{ $order->formatted_total }}</span>
                </div>
            </div>
        </div>

        <!-- Infos client -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4">Informations client</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600">Nom</p>
                    <p class="font-semibold">{{ $order->customer_name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Email</p>
                    <p class="font-semibold">{{ $order->customer_email }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Téléphone</p>
                    <p class="font-semibold">{{ $order->customer_phone }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Ville</p>
                    <p class="font-semibold">{{ $order->customer_city }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-sm text-gray-600">Adresse</p>
                    <p class="font-semibold">{{ $order->customer_address }}</p>
                </div>
            </div>
        </div>

        <!-- Notes -->
        @if($order->notes)
        <div class="bg-yellow-50 rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-2">Notes du client</h2>
            <p class="text-gray-700">{{ $order->notes }}</p>
        </div>
        @endif
    </div>

    <!-- Actions -->
    <div class="space-y-6">
        
        <!-- Statut commande -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-bold mb-4">Statut de la commande</h3>
            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                @csrf
                @method('PATCH')
                <select name="status" class="w-full px-4 py-2 border rounded-lg mb-3" onchange="this.form.submit()">
                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>En attente</option>
                    <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Confirmée</option>
                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>En préparation</option>
                    <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Expédiée</option>
                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Livrée</option>
                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Annulée</option>
                </select>
            </form>
            <p class="text-sm text-gray-500">Statut actuel: <strong>{{ $order->status_label }}</strong></p>
        </div>

        <!-- Statut paiement -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-bold mb-4">Statut du paiement</h3>
            <form action="{{ route('admin.orders.update-payment-status', $order) }}" method="POST">
                @csrf
                @method('PATCH')
                <select name="payment_status" class="w-full px-4 py-2 border rounded-lg mb-3" onchange="this.form.submit()">
                    <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>En attente</option>
                    <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Payée</option>
                    <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Échouée</option>
                    <option value="refunded" {{ $order->payment_status === 'refunded' ? 'selected' : '' }}>Remboursée</option>
                </select>
            </form>
            <p class="text-sm text-gray-500">
                Mode: <strong>{{ $order->payment_method_label }}</strong><br>
                Statut: <strong>{{ $order->payment_status_label }}</strong>
            </p>
        </div>

        <!-- Infos -->
        <div class="bg-gray-50 rounded-lg p-6">
            <h3 class="font-bold mb-3">Informations</h3>
            <div class="space-y-2 text-sm">
                <p><strong>Créée:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Mise à jour:</strong> {{ $order->updated_at->format('d/m/Y H:i') }}</p>
                @if($order->user_id)
                <p><strong>Client connecté:</strong> Oui</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection