@extends('layouts.admin')

@section('title', 'Commande ' . $order->order_number)

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.orders.index') }}" 
       class="inline-flex items-center text-primary-600 hover:text-primary-800 mb-4 font-semibold transition-colors group">
        <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Retour aux commandes
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
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
            <h2 class="text-xl font-bold mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                Articles commandés
            </h2>
            <div class="space-y-4">
                @foreach($order->items as $item)
                <div class="flex gap-4 pb-4 border-b last:border-0">
                    <div class="w-20 h-20 bg-gray-100 rounded-lg flex-shrink-0 overflow-hidden">
                        @if($item->product && $item->product->main_image)
                            <x-product-image 
                                :src="asset('storage/' . $item->product->main_image)"
                                :product="$item->product"
                                class="w-full h-full object-cover hover:scale-110 transition-transform duration-200" />
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-900">{{ $item->product_name }}</h3>
                        <p class="text-sm text-gray-600 mt-1">Quantité: <span class="font-medium">{{ $item->quantity }}</span></p>
                        <p class="text-sm text-gray-600">Prix unitaire: <span class="font-medium">{{ number_format($item->price, 0, ',', ' ') }} FCFA</span></p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-lg text-primary-600">{{ $item->formatted_total }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Totaux -->
            <div class="mt-6 pt-6 border-t space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Sous-total</span>
                    <span class="font-semibold">{{ number_format($order->subtotal, 0, ',', ' ') }} FCFA</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Livraison</span>
                    <span class="font-semibold">{{ number_format($order->shipping_cost, 0, ',', ' ') }} FCFA</span>
                </div>
                <div class="flex justify-between text-lg font-bold pt-2 border-t">
                    <span>Total</span>
                    <span class="text-primary-600">{{ $order->formatted_total }}</span>
                </div>
            </div>
        </div>

        <!-- Infos client -->
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
            <h2 class="text-xl font-bold mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Informations client
            </h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Nom</p>
                    <p class="font-semibold text-gray-900">{{ $order->customer_name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Email</p>
                    <p class="font-semibold break-words break-all text-gray-900">{{ $order->customer_email }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Téléphone</p>
                    <p class="font-semibold text-gray-900">{{ $order->customer_phone }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Ville</p>
                    <p class="font-semibold text-gray-900">{{ $order->customer_city }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-sm text-gray-600 mb-1">Adresse</p>
                    <p class="font-semibold text-gray-900">{{ $order->customer_address }}</p>
                </div>
            </div>
        </div>

        <!-- Notes -->
        @if($order->notes)
        <div class="bg-yellow-50 rounded-xl shadow-lg p-6 border border-yellow-200">
            <h2 class="text-xl font-bold mb-2 flex items-center text-yellow-800">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                </svg>
                Notes du client
            </h2>
            <p class="text-gray-700">{{ $order->notes }}</p>
        </div>
        @endif
    </div>

    <!-- Actions -->
    <div class="space-y-6">
        
        <!-- Statut commande -->
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100" x-data="{ statusChanged: false, originalStatus: '{{ $order->status }}' }">
            <h3 class="font-bold mb-4 flex items-center text-gray-900">
                <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Statut de la commande
            </h3>
            
            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                @csrf
                @method('PATCH')
                
                <select name="status" 
                        @change="statusChanged = ($event.target.value !== originalStatus)"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl mb-3 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>⏳ En attente</option>
                    <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>✅ Confirmée</option>
                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>🔄 En préparation</option>
                    <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>🚚 Expédiée</option>
                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>✓ Livrée</option>
                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>❌ Annulée</option>
                </select>

                <!-- Bouton de validation -->
                <button type="submit" 
                        x-show="statusChanged"
                        x-transition
                        class="w-full bg-gradient-to-r from-primary-600 to-secondary-600 text-white font-bold py-3 rounded-xl hover:shadow-lg transform hover:scale-[1.02] transition-all duration-200 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Valider le changement
                </button>
            </form>
            
            <div class="mt-3 p-3 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-600">
                    Statut actuel: <strong class="text-gray-900">{{ $order->status_label }}</strong>
                </p>
            </div>
        </div>

        <!-- Statut paiement -->
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100" x-data="{ paymentChanged: false, originalPayment: '{{ $order->payment_status }}' }">
            <h3 class="font-bold mb-4 flex items-center text-gray-900">
                <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
                Statut du paiement
            </h3>
            
            <form action="{{ route('admin.orders.update-payment-status', $order) }}" method="POST">
                @csrf
                @method('PATCH')
                
                <select name="payment_status" 
                        @change="paymentChanged = ($event.target.value !== originalPayment)"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl mb-3 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
                    <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>⏳ En attente</option>
                    <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>✅ Payée</option>
                    <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>❌ Échouée</option>
                    <option value="refunded" {{ $order->payment_status === 'refunded' ? 'selected' : '' }}>↩️ Remboursée</option>
                </select>

                <!-- Bouton de validation -->
                <button type="submit" 
                        x-show="paymentChanged"
                        x-transition
                        class="w-full bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold py-3 rounded-xl hover:shadow-lg transform hover:scale-[1.02] transition-all duration-200 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Valider le changement
                </button>
            </form>
            
            <div class="mt-3 p-3 bg-gray-50 rounded-lg space-y-1">
                <p class="text-sm text-gray-600">
                    Mode: <strong class="text-gray-900">{{ $order->payment_method_label }}</strong>
                </p>
                <p class="text-sm text-gray-600">
                    Statut: <strong class="text-gray-900">{{ $order->payment_status_label }}</strong>
                </p>
            </div>
        </div>

        <!-- Infos -->
        <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl shadow-lg p-6 border border-gray-200">
            <h3 class="font-bold mb-3 flex items-center text-gray-900">
                <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Informations
            </h3>
            <div class="space-y-2 text-sm">
                <p class="flex items-center">
                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <strong class="text-gray-700">Créée:</strong> 
                    <span class="ml-1 text-gray-900">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                </p>
                <p class="flex items-center">
                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    <strong class="text-gray-700">Mise à jour:</strong> 
                    <span class="ml-1 text-gray-900">{{ $order->updated_at->format('d/m/Y H:i') }}</span>
                </p>
                @if($order->user_id)
                <p class="flex items-center">
                    <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <strong class="text-gray-700">Client connecté:</strong> 
                    <span class="ml-1 text-green-600 font-semibold">Oui</span>
                </p>
                @endif
            </div>
        </div>

        <!-- Actions rapides (optionnel) -->
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
            <h3 class="font-bold mb-3 text-gray-900">Actions rapides</h3>
            <div class="space-y-2">
                <a href="mailto:{{ $order->customer_email }}" 
                   class="w-full flex items-center justify-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Envoyer un email
                </a>
                <a href="tel:{{ $order->customer_phone }}" 
                   class="w-full flex items-center justify-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    Appeler le client
                </a>
            </div>
        </div>
    </div>
</div>
@endsection