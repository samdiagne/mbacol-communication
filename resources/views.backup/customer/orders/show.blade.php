@extends('layouts.customer')

@section('title', 'Commande ' . $order->order_number)

@section('content')
<div class="mb-6">
    <a href="{{ route('customer.orders.index') }}" class="text-primary-600 hover:text-primary-800 mb-4 inline-block">
        ← Retour à mes commandes
    </a>
    <h1 class="text-3xl font-bold text-gray-900">Commande {{ $order->order_number }}</h1>
    <p class="text-gray-600">Passée le {{ $order->created_at->format('d/m/Y à H:i') }}</p>
</div>

<!-- Tracking -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h2 class="font-bold text-lg mb-4">Suivi de commande</h2>
    
    <div class="relative">
        <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200"></div>
        
        <div class="space-y-6">
            <!-- En attente -->
            <div class="relative flex items-start">
                <div class="w-8 h-8 rounded-full {{ in_array($order->status, ['pending', 'confirmed', 'processing', 'shipped', 'delivered']) ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center z-10">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="font-semibold">Commande reçue</p>
                    <p class="text-sm text-gray-600">{{ $order->created_at->format('d/m/Y à H:i') }}</p>
                </div>
            </div>

            <!-- Confirmée -->
            <div class="relative flex items-start">
                <div class="w-8 h-8 rounded-full {{ in_array($order->status, ['confirmed', 'processing', 'shipped', 'delivered']) ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center z-10">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="font-semibold">Commande confirmée</p>
                    <p class="text-sm text-gray-600">{{ in_array($order->status, ['confirmed', 'processing', 'shipped', 'delivered']) ? 'Confirmée' : 'En attente' }}</p>
                </div>
            </div>

            <!-- En préparation -->
            <div class="relative flex items-start">
                <div class="w-8 h-8 rounded-full {{ in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center z-10">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="font-semibold">En préparation</p>
                    <p class="text-sm text-gray-600">{{ in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'Préparée' : 'En attente' }}</p>
                </div>
            </div>

            <!-- Expédiée -->
            <div class="relative flex items-start">
                <div class="w-8 h-8 rounded-full {{ in_array($order->status, ['shipped', 'delivered']) ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center z-10">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="font-semibold">Expédiée</p>
                    <p class="text-sm text-gray-600">{{ in_array($order->status, ['shipped', 'delivered']) ? 'En cours de livraison' : 'En attente' }}</p>
                </div>
            </div>

            <!-- Livrée -->
            <div class="relative flex items-start">
                <div class="w-8 h-8 rounded-full {{ $order->status === 'delivered' ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center z-10">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="font-semibold">Livrée</p>
                    <p class="text-sm text-gray-600">{{ $order->status === 'delivered' ? 'Commande livrée' : 'En attente' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Produits -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h2 class="font-bold text-lg mb-4">Articles commandés</h2>
    <div class="space-y-4">
        @foreach($order->items as $item)
        <div class="flex gap-4 pb-4 border-b last:border-0">
            <div class="w-20 h-20 bg-gray-100 rounded flex-shrink-0">
                @if($item->product && $item->product->main_image)
                    <img src="{{ asset('storage/' . $item->product->main_image) }}" 
                         class="w-full h-full object-cover rounded">
                @endif
            </div>
            <div class="flex-1">
                <h3 class="font-semibold">{{ $item->product_name }}</h3>
                <p class="text-sm text-gray-600">Quantité: {{ $item->quantity }}</p>
                <p class="text-sm text-gray-600">{{ number_format($item->price, 0, ',', ' ') }} FCFA × {{ $item->quantity }}</p>
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

<!-- Infos -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Livraison -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="font-bold mb-4">Adresse de livraison</h3>
        <p class="text-gray-700">
            {{ $order->customer_name }}<br>
            {{ $order->customer_address }}<br>
            {{ $order->customer_city }}<br>
            {{ $order->customer_phone }}
        </p>
    </div>

    <!-- Paiement -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="font-bold mb-4">Paiement</h3>
        <p class="text-gray-700 mb-2">
            <strong>Mode :</strong> {{ $order->payment_method_label }}
        </p>
        <p>
            @if($order->payment_status === 'paid')
                <span class="px-3 py-1 bg-green-100 text-green-800 text-sm font-semibold rounded-full">
                    ✓ Payée
                </span>
            @else
                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-sm font-semibold rounded-full">
                    ⏳ {{ $order->payment_status_label }}
                </span>
            @endif
        </p>
    </div>
</div>
@endsection