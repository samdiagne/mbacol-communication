@extends('layouts.app')

@section('title', 'Commande confirmée')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    <!-- Succès -->
    <div class="text-center mb-12">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-6">
            <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Commande confirmée !</h1>
        <p class="text-xl text-gray-600">Merci pour votre commande</p>
    </div>

    <!-- Détails commande -->
    <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
        <div class="border-b border-gray-200 pb-6 mb-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Numéro de commande</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $order->order_number }}</p>
                </div>
                <div class="text-right">
                    <span class="inline-block px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold">
                        {{ $order->status_label }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Infos client -->
        <div class="mb-6">
            <h3 class="font-bold text-lg mb-3">Informations de livraison</h3>
            <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                <p><span class="font-semibold">Nom :</span> {{ $order->customer_name }}</p>
                <p><span class="font-semibold">Email :</span> {{ $order->customer_email }}</p>
                <p><span class="font-semibold">Téléphone :</span> {{ $order->customer_phone }}</p>
                <p><span class="font-semibold">Adresse :</span> {{ $order->customer_address }}, {{ $order->customer_city }}</p>
            </div>
        </div>

        <!-- Produits -->
        <div class="mb-6">
            <h3 class="font-bold text-lg mb-3">Articles commandés</h3>
            <div class="space-y-3">
                @foreach($order->items as $item)
                <div class="flex justify-between py-2">
                    <div>
                        <p class="font-semibold">{{ $item->product_name }}</p>
                        <p class="text-sm text-gray-600">Quantité: {{ $item->quantity }}</p>
                    </div>
                    <p class="font-semibold">{{ $item->formatted_total }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Totaux -->
        <div class="border-t border-gray-200 pt-4 space-y-2">
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

        <!-- Paiement -->
        <div class="mt-6 p-4 bg-blue-50 rounded-lg">
            <p class="font-semibold mb-2">Mode de paiement : {{ $order->payment_method_label }}</p>
            @if($order->payment_method !== 'cash')
                <p class="text-sm text-gray-700">Vous recevrez les instructions de paiement par email et SMS.</p>
            @else
                <p class="text-sm text-gray-700">Préparez le montant exact pour la livraison.</p>
            @endif
        </div>
    </div>

    <!-- Actions -->
    <div class="text-center">
        <a href="{{ route('shop') }}" 
           class="inline-block bg-primary-600 hover:bg-primary-700 text-white font-bold py-3 px-8 rounded-lg transition duration-200">
            Continuer mes achats
        </a>
    </div>
</div>
@endsection