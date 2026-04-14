<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- En-tête avec animation -->
        <div class="scroll-reveal mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">🛒 Mon panier</h1>
            <p class="text-gray-600">
                {{ $cartItems->count() }} {{ $cartItems->count() > 1 ? 'articles' : 'article' }}
            </p>
        </div>

        @if($cartItems->count() > 0)
        @php
            $cartMessage = "Bonjour, je souhaite commander ces articles 🛒\n\n";
            $totalCart = 0;
            foreach($cartItems as $item) {
                $productName = $item->product ? $item->product->name : ($item->product_name ?? 'Produit');
                $quantity = $item->quantity;
                $price = $item->price;
                $subtotal = $price * $quantity;
                $totalCart += $subtotal;
                $cartMessage .= "• " . $productName . " (x" . $quantity . ")\n";
                $cartMessage .= "  → " . number_format($price, 0, ',', ' ') . " FCFA × " . $quantity . " = " . number_format($subtotal, 0, ',', ' ') . " FCFA\n";
                if ($item->product) {
                    $cartMessage .= route('product.show', $item->product) . "\n";
                }
                $cartMessage .= "\n";
            }
            $cartMessage .= "━━━━━━━━━━━━━━\n";
            $cartMessage .= "💰 TOTAL : " . number_format($totalCart, 0, ',', ' ') . " FCFA\n\n";
            $cartMessage .= "📍 Je souhaite passer commande.\n";
            $cartMessage .= "Pouvez-vous me confirmer la disponibilité et les modalités de livraison ?\n\n";
            $cartMessage .= "Merci ! 🙏\n\n";
            $cartMessage .= "━━━━━━━━━━━━━━\n";
            $cartMessage .= "Enregistrer la commande (admin) :\n";
            $cartMessage .= route('admin.orders.index');
        @endphp
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 lg:gap-8">
            
            <!-- Liste des produits -->
            <div class="xl:col-span-2 space-y-4">
                @foreach($cartItems as $index => $item)
                <div wire:key="cart-item-{{ $item->id }}" 
                     class="scroll-reveal-scale bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 p-4 sm:p-6">

                    <div class="flex flex-col sm:flex-row sm:items-center gap-4 sm:gap-6">

                        <!-- Image -->
                        <div class="w-20 h-20 sm:w-24 sm:h-24 flex-shrink-0 bg-gray-100 rounded-lg overflow-hidden mx-auto sm:mx-0">
                            @if($item->product && $item->product->main_image)
                                <x-product-image 
                                    :src="asset('storage/' . $item->product->main_image)"
                                    :product="$item->product"
                                    class="w-full h-full object-cover" />
                            @elseif($item->product_name)
                                <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                    <div class="text-center p-2">
                                        <svg class="w-8 h-8 mx-auto text-gray-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <p class="text-xs text-gray-500">{{ Str::limit($item->product_name, 20) }}</p>
                                    </div>
                                </div>
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Infos produit -->
                        <div class="flex-1 text-center sm:text-left">
                            <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-1">
                                @if($item->product)
                                <a href="{{ route('product.show', $item->product) }}" 
                                   class="hover:text-primary-600 transition">
                                    {{ $item->product->name }}
                                </a>
                                @else
                                <span>{{ $item->product_name ?? 'Produit indisponible' }}</span>
                                @endif
                            </h3>

                            @if($item->product && $item->product->category)
                            <p class="text-sm text-gray-500 mb-2">
                                {{ $item->product->category->name }}
                            </p>
                            @endif

                            <p class="text-lg font-bold text-gray-900">
                                {{ number_format($item->price, 0, ',', ' ') }} FCFA
                            </p>

                            <!-- Stock warning -->
                            @if($item->product && $item->product->stock <= 5 && $item->product->stock > 0)
                            <p class="text-xs text-orange-600 font-semibold mt-1">
                                ⚠️ Plus que {{ $item->product->stock }} en stock !
                            </p>
                            @elseif($item->product && $item->product->stock == 0)
                            <p class="text-xs text-red-600 font-semibold mt-1">
                                ❌ Rupture de stock
                            </p>
                            @endif
                        </div>

                        <!-- Actions (Quantité + Prix + Supprimer) -->
                        <div class="flex flex-col sm:flex-row items-center gap-4 sm:gap-6">

                            <!-- Contrôles quantité SIMPLIFIÉ -->
                        <div class="flex items-center border-2 border-gray-300 rounded-lg">
                            <!-- Bouton - -->
                            <button wire:click="decrementQuantity({{ $item->id }})" 
                                    type="button"
                                    class="px-3 py-2 hover:bg-gray-100 transition"
                                    @if($item->quantity <= 1) disabled @endif>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                </svg>
                            </button>

                            <!-- Quantité -->
                            <span class="px-4 py-2 font-bold text-gray-900 min-w-[3rem] text-center">
                                {{ $item->quantity }}
                            </span>

                            <!-- Bouton + -->
                            <button wire:click="incrementQuantity({{ $item->id }})" 
                                    type="button"
                                    class="px-3 py-2 hover:bg-gray-100 transition"
                                    @if($item->product && $item->quantity >= $item->product->stock) disabled @endif>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </button>
                        </div>

                            <!-- Sous-total ligne -->
                            <div class="text-center sm:text-right min-w-[120px]">
                                <p class="text-xs text-gray-500 mb-1">Sous-total</p>
                                <p class="text-lg font-bold text-primary-600">
                                    {{ number_format($item->quantity * $item->price, 0, ',', ' ') }} FCFA
                                </p>
                            </div>

                            <!-- Bouton supprimer -->
                            <button wire:click="removeItem({{ $item->id }})" 
                                    wire:loading.attr="disabled"
                                    wire:loading.class="opacity-50 cursor-wait"
                                    wire:target="removeItem({{ $item->id }})"
                                    type="button"
                                    class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-all duration-200 group"
                                    title="Supprimer cet article">
                                <svg wire:loading.remove wire:target="removeItem({{ $item->id }})" 
                                    class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                <svg wire:loading wire:target="removeItem({{ $item->id }})" 
                                    class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </button>
                        </div>

                    </div>
                </div>
                @endforeach
                
                <!-- Bouton vider le panier -->
                <div class="flex justify-end">
                    <button wire:click="clearCart" 
                            type="button"
                            class="text-red-600 hover:text-red-800 font-semibold flex items-center gap-2 px-4 py-2 hover:bg-red-50 rounded-lg transition group">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Vider le panier
                    </button>
                </div>
            </div>

            <!-- Résumé de commande (Sticky) -->
            <div class="xl:col-span-1">
                <div class="bg-white rounded-xl shadow-md p-6 sticky top-24">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Résumé
                    </h2>
                    
                    <!-- Détails prix -->
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between text-base">
                            <span class="text-gray-600">Sous-total ({{ $cartItems->sum('quantity') }} articles)</span>
                            <span class="font-semibold text-gray-900">{{ number_format($subtotal, 0, ',', ' ') }} FCFA</span>
                        </div>
                        
                        <!-- Info livraison (sans montant fixe) -->
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-3 rounded-r-lg">
                            <div class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div class="text-xs text-blue-800">
                                    <p class="font-semibold mb-1">🚚 Frais de livraison</p>
                                    <p>Entre <strong>1 500 et 5 000 FCFA</strong> selon votre zone (calculés au checkout)</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @php
                        $paymentsEnabled = filter_var(env('PAYMENTS_ENABLED', true), FILTER_VALIDATE_BOOLEAN);
                    @endphp

                    <!-- Bouton principal avec compteur -->
                    @if($paymentsEnabled)
                        <a href="{{ route('checkout') }}" 
                        class="relative block w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-5 px-6 rounded-xl text-center transition-all duration-300 shadow-lg hover:shadow-2xl transform hover:-translate-y-1 mb-3 group overflow-hidden">
                            <!-- Pulse animation -->
                            <div class="absolute inset-0 bg-white/10 rounded-xl animate-pulse"></div>
                            <span class="relative flex items-center justify-center gap-3">
                                <div class="relative">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    <span class="absolute -top-2 -right-2 w-5 h-5 bg-white text-blue-700 text-xs font-bold rounded-full flex items-center justify-center">
                                        {{ $cartItems->count() }}
                                    </span>
                                </div>
                                <span class="text-lg">Passer la commande</span>
                                <svg class="w-6 h-6 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </span>
                        </a>
                    @else
                        <!-- Message service indisponible -->
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-xl mb-3 text-yellow-800">
                            ⚠️ Paiement en ligne temporairement indisponible. 
                            Vous pouvez passer votre commande via WhatsApp ci-dessous.
                        </div>
                    @endif

                    <!-- Bouton WhatsApp -->
                    <div class="relative mb-3">
                        <span class="absolute -top-2 -right-2 z-10 bg-red-500 text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center ring-2 ring-white">
                            {{ $cartItems->count() }}
                        </span>
                        <a href="https://wa.me/221784465192?text={{ rawurlencode($cartMessage) }}"
                           target="_blank"
                           class="flex items-center justify-center gap-2 w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-4 rounded-xl transition-colors">
                            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                            Commander via WhatsApp
                        </a>
                    </div>

                    <!-- Bouton secondaire minimal -->
                    <a href="{{ route('shop') }}"
                    class="block w-full text-gray-600 hover:text-primary-600 font-semibold py-3 text-center transition-colors group">
                        <span class="flex items-center justify-center gap-2">
                            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            <span>Continuer mes achats</span>
                        </span>
                    </a>

                    <!-- Badges confiance -->
                    <div class="mt-6 pt-6 border-t border-gray-200 space-y-3">
                        <div class="flex items-center gap-3 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Paiement sécurisé</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Livraison rapide à Dakar</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Support client 7j/7</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


        @else
        <!-- Panier vide (amélioré) -->
        <div class="scroll-reveal bg-white rounded-xl shadow-lg p-12 text-center max-w-2xl mx-auto">
            <div class="w-32 h-32 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Votre panier est vide</h2>
            <p class="text-gray-600 mb-8 text-lg">Découvrez nos produits et profitez de nos offres exclusives !</p>
            <a href="{{ route('shop') }}" 
               class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white font-bold py-4 px-8 rounded-xl transition duration-200 shadow-lg hover:shadow-xl group">
                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                Découvrir la boutique
            </a>
        </div>
        @endif
    </div>
</div>