<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Finaliser ma commande</h1>

    @if (session()->has('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
            <p class="text-red-700">{{ session('error') }}</p>
        </div>
    @endif

    <form wire:submit.prevent="placeOrder">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Formulaire -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Informations personnelles -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold mb-4">Informations personnelles</h2>
                    
                    <div class="space-y-4">
                        <!-- Nom complet -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nom complet <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   wire:model="customer_name"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('customer_name') @enderror">
                            @error('customer_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" 
                                   wire:model="customer_email"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('customer_email') @enderror">
                            @error('customer_email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Téléphone -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Téléphone <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" 
                                   wire:model="customer_phone"
                                   placeholder="+221 XX XXX XX XX"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('customer_phone') @enderror">
                            @error('customer_phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Adresse de livraison -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold mb-4">📍 Adresse de livraison</h2>
                    
                    <div class="space-y-6">
                        <!-- Zone de livraison (Component) -->
                        <div>
                            <x-delivery-zone-selector />
                        </div>

                        <!-- Ville (optionnel, garde ou enlève selon besoin) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Ville <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                wire:model="customer_city"
                                value="Dakar"
                                readonly
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 cursor-not-allowed">
                        </div>

                        <!-- Adresse complète -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Adresse détaillée <span class="text-red-500">*</span>
                            </label>
                            <textarea wire:model="customer_address"
                                    rows="3"
                                    placeholder="Indiquez votre adresse exacte : quartier, rue, numéro, point de repère..."
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('customer_address') @enderror"></textarea>
                            @error('customer_address')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">
                                💡 Plus l'adresse est précise, plus la livraison sera rapide
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Modes de paiement -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h2 class="text-xl font-bold mb-4">💳 Mode de paiement</h2>
                    
                    <div class="space-y-3">
                        <!-- PayDunya - Tous les moyens -->
                        <label class="flex items-start p-5 border-2 rounded-xl cursor-pointer transition-all {{ $payment_method === 'paydunya' ? 'border-primary-600 bg-gradient-to-br from-primary-50 to-secondary-50 ring-2 ring-primary-200' : 'border-gray-200 hover:border-primary-300 hover:bg-gray-50' }}">
                            <input type="radio" 
                                wire:model.live="payment_method" 
                                value="paydunya" 
                                class="mt-1 h-5 w-5 text-primary-600">
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-bold text-gray-900 text-lg">Paiement en ligne</span>
                                    <div class="flex items-center gap-1 bg-green-100 px-3 py-1 rounded-full">
                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-xs font-bold text-green-700">Recommandé</span>
                                    </div>
                                </div>
                                
                                <p class="text-sm text-gray-600 mb-3">
                                    Paiement sécurisé avec tous les moyens de paiement
                                </p>
                                
                                <!-- Logos moyens de paiement -->
                                <div class="flex flex-wrap items-center gap-2">
                                    <div class="flex items-center gap-1.5 bg-white px-3 py-1.5 rounded-lg border border-gray-200 shadow-sm">
                                        <div class="w-6 h-6 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center">
                                            <span class="text-white text-xs">W</span>
                                        </div>
                                        <span class="text-xs font-semibold text-gray-700">Wave</span>
                                    </div>
                                    
                                    <div class="flex items-center gap-1.5 bg-white px-3 py-1.5 rounded-lg border border-gray-200 shadow-sm">
                                        <div class="w-6 h-6 bg-gradient-to-br from-orange-500 to-red-500 rounded-full flex items-center justify-center">
                                            <span class="text-white text-xs">OM</span>
                                        </div>
                                        <span class="text-xs font-semibold text-gray-700">Orange Money</span>
                                    </div>
                                    
                                    <div class="flex items-center gap-1.5 bg-white px-3 py-1.5 rounded-lg border border-gray-200 shadow-sm">
                                        <div class="w-6 h-6 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full flex items-center justify-center">
                                            <span class="text-white text-xs">F</span>
                                        </div>
                                        <span class="text-xs font-semibold text-gray-700">Free Money</span>
                                    </div>
                                    
                                    <div class="flex items-center gap-1.5 bg-white px-3 py-1.5 rounded-lg border border-gray-200 shadow-sm">
                                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                            <rect width="24" height="16" y="4" rx="2" fill="currentColor" opacity="0.2"/>
                                            <path d="M4 8h16M4 12h8" stroke="currentColor" stroke-width="1.5" fill="none"/>
                                        </svg>
                                        <span class="text-xs font-semibold text-gray-700">Carte Bancaire</span>
                                    </div>
                                </div>
                                
                                <!-- Badge sécurisé -->
                                <div class="mt-3 flex items-center gap-2 text-xs text-gray-500">
                                    <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="font-medium">Paiement 100% sécurisé</span>
                                    <span>•</span>
                                    <span>Powered by PayDunya</span>
                                </div>
                            </div>
                        </label>

                        <!-- Cash -->
                        <label class="flex items-start p-4 border-2 rounded-xl cursor-pointer transition-all {{ $payment_method === 'cash' ? 'border-primary-600 bg-primary-50' : 'border-gray-200 hover:border-primary-300' }}">
                            <input type="radio" 
                                wire:model.live="payment_method" 
                                value="cash" 
                                class="mt-1 h-5 w-5 text-primary-600">
                            <div class="ml-3 flex-1">
                                <span class="font-semibold text-gray-900">Espèces à la livraison</span>
                                <p class="text-sm text-gray-600 mt-1">Payez en espèces lors de la réception</p>
                            </div>
                        </label>
                    </div>
                    
                    @error('payment_method')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Notes -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold mb-4">Notes (optionnel)</h2>
                    <textarea wire:model="notes"
                              rows="3"
                              placeholder="Instructions spéciales pour la livraison..."
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"></textarea>
                </div>
            </div>

            <!-- Résumé commande -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-6 sticky top-4">
                    <h2 class="text-xl font-bold mb-6">Résumé</h2>
                    
                    <!-- Produits -->
                    <div class="space-y-3 mb-6 max-h-64 overflow-y-auto">
                        @foreach($cartItems as $item)
                        <div class="flex gap-3">
                            <div class="w-16 h-16 bg-gray-100 rounded flex-shrink-0">
                                @if($item->product->main_image)
                                    <img src="{{ asset('storage/' . $item->product->main_image) }}" 
                                         alt="{{ $item->product->name }}" 
                                         class="w-full h-full object-cover rounded">
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ $item->product->name }}</p>
                                <p class="text-sm text-gray-500">Qté: {{ $item->quantity }}</p>
                                <p class="text-sm font-semibold">{{ number_format($item->quantity * $item->price, 0, ',', ' ') }} FCFA</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Totaux -->
                    <div class="border-t border-gray-200 pt-4 space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Sous-total</span>
                            <span class="font-semibold">{{ number_format($subtotal, 0, ',', ' ') }} FCFA</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Livraison</span>
                            <span class="font-semibold">
                                @if($shippingCost > 0)
                                    {{ number_format($shippingCost, 0, ',', ' ') }} FCFA
                                @else
                                    <span class="text-gray-400">Sélectionnez une zone</span>
                                @endif
                            </span>
                        </div>
                        <div class="border-t border-gray-200 pt-3">
                            <div class="flex justify-between">
                                <span class="text-lg font-bold">Total</span>
                                <span class="text-2xl font-bold text-primary-600">
                                    {{ number_format($total, 0, ',', ' ') }} FCFA
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Bouton commander -->
                    <button type="submit"
                            wire:loading.attr="disabled"
                            class="w-full mt-6 bg-primary-600 hover:bg-primary-700 text-white font-bold py-4 rounded-lg transition duration-200 disabled:opacity-50">
                        <span wire:loading.remove>Confirmer la commande</span>
                        <span wire:loading>Traitement...</span>
                    </button>

                    <a href="{{ route('cart') }}" 
                       class="block w-full mt-3 text-center text-gray-600 hover:text-gray-900 font-semibold py-2">
                        ← Retour au panier
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>