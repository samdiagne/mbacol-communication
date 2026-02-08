@extends('layouts.customer')

@section('title', 'Mes commandes')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Mes commandes</h1>
    <p class="text-gray-600">Suivez l'état de vos commandes</p>
</div>

@if($orders->count() > 0)
    <div class="space-y-4">
        @foreach($orders as $order)
        <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
            <div class="p-6">
                <div class="flex flex-wrap justify-between items-start gap-4 mb-4">
                    <div>
                        <p class="text-sm text-gray-600">Commande</p>
                        <p class="font-mono font-bold text-lg text-primary-600">{{ $order->order_number }}</p>
                        <p class="text-sm text-gray-500">{{ $order->created_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    
                    <div class="text-right">
                        <p class="text-2xl font-bold text-gray-900">{{ $order->formatted_total }}</p>
                        <p class="text-sm text-gray-600">{{ $order->items->count() }} article(s)</p>
                    </div>
                </div>

                <!-- Statuts -->
                <div class="flex flex-wrap gap-2 mb-4">
                    @if($order->status === 'delivered')
                        <span class="px-3 py-1 bg-green-100 text-green-800 text-sm font-semibold rounded-full">
                            ✓ {{ $order->status_label }}
                        </span>
                    @elseif($order->status === 'cancelled')
                        <span class="px-3 py-1 bg-red-100 text-red-800 text-sm font-semibold rounded-full">
                            ✕ {{ $order->status_label }}
                        </span>
                    @elseif($order->status === 'shipped')
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-semibold rounded-full">
                            🚚 {{ $order->status_label }}
                        </span>
                    @else
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-sm font-semibold rounded-full">
                            ⏳ {{ $order->status_label }}
                        </span>
                    @endif

                    @if($order->payment_status === 'paid')
                        <span class="px-3 py-1 bg-green-100 text-green-800 text-sm font-semibold rounded-full">
                            💳 Payée
                        </span>
                    @elseif($order->payment_status === 'pending')
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-sm font-semibold rounded-full">
                            💳 Paiement en attente
                        </span>
                    @endif
                </div>

                <!-- Produits (aperçu) -->
                <div class="flex gap-2 mb-4 overflow-x-auto pb-2">
                    @foreach($order->items->take(4) as $item)
                    <div class="w-16 h-16 bg-gray-100 rounded flex-shrink-0">
                        @if($item->product && $item->product->main_image)
                            <img src="{{ asset('storage/' . $item->product->main_image) }}" 
                                 alt="{{ $item->product_name }}" 
                                 class="w-full h-full object-cover rounded">
                        @endif
                    </div>
                    @endforeach
                    @if($order->items->count() > 4)
                    <div class="w-16 h-16 bg-gray-200 rounded flex-shrink-0 flex items-center justify-center">
                        <span class="text-sm font-semibold text-gray-600">+{{ $order->items->count() - 4 }}</span>
                    </div>
                    @endif
                </div>

                <!-- Action -->
                <div class="flex justify-between items-center pt-4 border-t">
                    <div class="text-sm text-gray-600">
                        <span class="font-semibold">Livraison :</span> {{ $order->customer_city }}
                    </div>
                    <a href="{{ route('customer.orders.show', $order) }}" 
                       class="text-primary-600 hover:text-primary-800 font-semibold">
                        Voir les détails →
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if($orders->hasPages())
    <div class="mt-6">
        {{ $orders->links() }}
    </div>
    @endif

@else
    <div class="bg-white rounded-lg shadow p-12 text-center">
        <div class="text-6xl mb-4">📦</div>
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Aucune commande</h2>
        <p class="text-gray-600 mb-8">Vous n'avez pas encore passé de commande</p>
        <a href="{{ route('shop') }}" 
           class="inline-block bg-primary-600 hover:bg-primary-700 text-white font-bold py-3 px-8 rounded-lg transition">
            Découvrir la boutique
        </a>
    </div>
@endif
@endsection