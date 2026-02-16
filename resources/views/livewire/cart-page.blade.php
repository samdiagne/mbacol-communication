<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Mon panier</h1>
            <p class="text-gray-600">{{ $cartItems->count() }} article(s)</p>
        </div>

        @if($cartItems->count() > 0)
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 lg:gap-8">
            
            <!-- Liste des produits -->
            <div class="lg:col-span-2 space-y-4">
                @foreach($cartItems as $item)
                <div wire:key="cart-item-{{ $item->id }}" 
                    class="bg-white rounded-xl shadow-sm p-4 sm:p-6">

                    <div class="flex flex-col sm:flex-row sm:items-center gap-4 sm:gap-6">

                        <!-- Image -->
                        <div class="w-20 h-20 sm:w-24 sm:h-24 flex-shrink-0 bg-gray-100 rounded-lg overflow-hidden mx-auto sm:mx-0">
                            @if($item->product->main_image)
                                <img src="{{ asset('storage/' . $item->product->main_image) }}" 
                                    alt="{{ $item->product->name }}" 
                                    class="w-full h-full object-cover">
                            @endif
                        </div>

                        <!-- Infos -->
                        <div class="flex-1 text-center sm:text-left">
                            <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-1">
                                <a href="{{ route('product.show', $item->product) }}" 
                                class="hover:text-primary-600 transition">
                                    {{ $item->product->name }}
                                </a>
                            </h3>

                            <p class="text-sm text-gray-500 mb-2">
                                {{ $item->product->category->name }}
                            </p>

                            <p class="text-lg font-bold text-gray-900">
                                {{ number_format($item->price, 0, ',', ' ') }} FCFA
                            </p>
                        </div>

                        <!-- Quantité + Prix + Delete -->
                        <div class="flex flex-col sm:flex-row items-center gap-4 sm:gap-6">

                            <!-- Quantité -->
                            <div class="flex items-center border border-gray-300 rounded-lg">
                                <button wire:click="decrementQuantity({{ $item->id }})" 
                                        type="button"
                                        class="px-3 py-2 hover:bg-gray-100 transition"
                                        @if($item->quantity <= 1) disabled @endif>
                                    −
                                </button>

                                <span class="px-4 py-2 font-semibold min-w-[2.5rem] text-center">
                                    {{ $item->quantity }}
                                </span>

                                <button wire:click="incrementQuantity({{ $item->id }})" 
                                        type="button"
                                        class="px-3 py-2 hover:bg-gray-100 transition"
                                        @if($item->quantity >= $item->product->stock) disabled @endif>
                                    +
                                </button>
                            </div>

                            <!-- Sous-total -->
                            <div class="text-center sm:text-right">
                                <p class="text-lg font-bold text-primary-600">
                                    {{ number_format($item->quantity * $item->price, 0, ',', ' ') }} FCFA
                                </p>
                            </div>

                            <!-- Supprimer -->
                            <button wire:click="removeItem({{ $item->id }})" 
                                    type="button"
                                    class="text-red-500 hover:text-red-700 transition">
                                🗑
                            </button>
                        </div>

                    </div>
                </div>
                @endforeach
                <!-- Vider le panier -->
                <button wire:click="clearCart" 
                        type="button"
                        class="text-red-600 hover:text-red-800 font-semibold">
                    Vider le panier
                </button>
            </div>

            <!-- Résumé -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-6 sticky top-4">
                    <h2 class="text-xl font-bold mb-6">Résumé de la commande</h2>
                    
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Sous-total</span>
                            <span class="font-semibold">{{ number_format($subtotal, 0, ',', ' ') }} FCFA</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Livraison</span>
                            <span class="font-semibold">{{ number_format($shippingCost, 0, ',', ' ') }} FCFA</span>
                        </div>
                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex justify-between">
                                <span class="text-lg font-bold">Total</span>
                                <span class="text-2xl font-bold text-primary-600">{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('checkout') }}" 
                       class="block w-full bg-primary-600 hover:bg-primary-700 text-white font-bold py-4 rounded-lg text-center transition duration-200 mb-3">
                        Finaliser votre commande
                    </a>
                    
                    <a href="{{ route('shop') }}" 
                       class="block w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 rounded-lg text-center transition duration-200">
                        Voir d'autres articles
                    </a>
                </div>
            </div>
        </div>

        @else
        <!-- Panier vide -->
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <svg class="w-24 h-24 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Votre panier est vide</h2>
            <p class="text-gray-600 mb-8">Découvrez nos produits et ajoutez-les à votre panier !</p>
            <a href="{{ route('shop') }}" 
               class="inline-block bg-primary-600 hover:bg-primary-700 text-white font-bold py-3 px-8 rounded-lg transition duration-200">
                Découvrir la boutique
            </a>
        </div>
        @endif
    </div>
</div>