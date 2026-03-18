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
                        
                        <!-- Wave -->
                        <label class="flex items-start p-4 border-2 rounded-xl cursor-pointer transition-all {{ $payment_method === 'wave' ? 'border-cyan-500 bg-gradient-to-r from-cyan-50 to-blue-50 ring-2 ring-cyan-200' : 'border-gray-200 hover:border-cyan-300 hover:bg-gray-50' }}">
                            <input type="radio" 
                                wire:model.live="payment_method" 
                                value="wave" 
                                class="mt-1 h-5 w-5 text-cyan-600">
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <!-- Logo Wave -->
                                        <div class="w-12 h-12 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-full flex items-center justify-center shadow-md">
                                            <div class="text-center">
                                                <div class="text-white font-black text-[10px] leading-none">WAVE</div>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="font-bold text-gray-900 text-base">Wave</span>
                                            <p class="text-xs text-gray-500">Paiement mobile instantané</p>
                                        </div>
                                    </div>
                                    @if($payment_method === 'wave')
                                        <svg class="w-6 h-6 text-cyan-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                </div>
                            </div>
                        </label>

                        <!-- Orange Money -->
                        <label class="flex items-start p-4 border-2 rounded-xl cursor-pointer transition-all {{ $payment_method === 'orange_money' ? 'border-orange-500 bg-gradient-to-r from-orange-50 to-red-50 ring-2 ring-orange-200' : 'border-gray-200 hover:border-orange-300 hover:bg-gray-50' }}">
                            <input type="radio" 
                                wire:model.live="payment_method" 
                                value="orange_money" 
                                class="mt-1 h-5 w-5 text-orange-600">
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <!-- Logo Orange Money -->
                                        <div class="w-12 h-12 white rounded-full flex items-center justify-center shadow-md">
                                            <div class="text-center">
                                                <div class="text-orange-600 font-black text-[20px] leading-none">OM</div>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="font-bold text-gray-900 text-base">Orange Money</span>
                                            <p class="text-xs text-gray-500">Paiement via compte Orange</p>
                                        </div>
                                    </div>
                                    @if($payment_method === 'orange_money')
                                        <svg class="w-6 h-6 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                </div>
                            </div>
                        </label>

                        <!-- Free Money -->
                        <label class="flex items-start p-4 border-2 rounded-xl cursor-pointer transition-all {{ $payment_method === 'free_money' ? 'border-blue-700 bg-gradient-to-r from-blue-50 to-indigo-50 ring-2 ring-blue-200' : 'border-gray-200 hover:border-blue-300 hover:bg-gray-50' }}">
                            <input type="radio" 
                                wire:model.live="payment_method" 
                                value="free_money" 
                                class="mt-1 h-5 w-5 text-blue-700">
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <!-- Logo Free Money -->
                                        <div class="w-12 h-12 bg-gradient-to-br from-blue-900 to-blue-700 rounded-full flex items-center justify-center shadow-md">
                                            <div class="text-center">
                                                <div class="text-yellow-400 font-black text-[10px] leading-none">mixx</div>
                                                <div class="text-yellow-400 text-[6px] font-bold">by Free</div>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="font-bold text-gray-900 text-base">Free Money (Mixx)</span>
                                            <p class="text-xs text-gray-500">Paiement via compte Free</p>
                                        </div>
                                    </div>
                                    @if($payment_method === 'free_money')
                                        <svg class="w-6 h-6 text-blue-700" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                </div>
                            </div>
                        </label>

                        <!-- Carte Bancaire (Visa/Mastercard) -->
                        <label class="flex items-start p-4 border-2 rounded-xl cursor-pointer transition-all {{ $payment_method === 'card' ? 'border-blue-600 bg-gradient-to-r from-blue-50 to-purple-50 ring-2 ring-blue-200' : 'border-gray-200 hover:border-blue-300 hover:bg-gray-50' }}">
                            <input type="radio" 
                                wire:model.live="payment_method" 
                                value="card" 
                                class="mt-1 h-5 w-5 text-blue-600">
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <!-- Logo Carte -->
                                        <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-purple-600 rounded-xl flex items-center justify-center shadow-md">
                                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <rect x="2" y="6" width="20" height="12" rx="2" stroke="currentColor" fill="none"/>
                                                <path d="M2 10h20M7 15h3" stroke-linecap="round"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <span class="font-bold text-gray-900 text-base">Carte Bancaire</span>
                                            <div class="flex items-center gap-2 mt-0.5">
                                                <span class="text-xs text-gray-500">Visa, Mastercard</span>
                                            </div>
                                        </div>
                                    </div>
                                    @if($payment_method === 'card')
                                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                </div>
                            </div>
                        </label>

                        <!-- Cash à la livraison -->
                        <label class="flex items-start p-4 border-2 rounded-xl cursor-pointer transition-all {{ $payment_method === 'cash' ? 'border-green-600 bg-gradient-to-r from-green-50 to-emerald-50 ring-2 ring-green-200' : 'border-gray-200 hover:border-green-300 hover:bg-gray-50' }}">
                            <input type="radio" 
                                wire:model.live="payment_method" 
                                value="cash" 
                                class="mt-1 h-5 w-5 text-green-600">
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <!-- Logo Cash -->
                                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center shadow-md">
                                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <span class="font-bold text-gray-900 text-base">Espèces à la livraison</span>
                                            <p class="text-xs text-gray-500">Payez en cash lors de la réception</p>
                                        </div>
                                    </div>
                                    @if($payment_method === 'cash')
                                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                </div>
                            </div>
                        </label>
                    </div>
                    
                    <!-- Badge sécurité (en bas de tous les modes) -->
                    <div class="mt-4 p-3 bg-gray-50 rounded-lg border border-gray-200">
                        <div class="flex items-center gap-2 text-xs text-gray-600">
                            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-medium">Tous les paiements sont 100% sécurisés</span>
                            <span class="text-gray-400">•</span>
                            <span class="text-gray-500">Powered by PayDunya</span>
                        </div>
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
                        <span wire:loading.remove>Valider la commande</span>
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