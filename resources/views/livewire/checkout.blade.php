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
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        💳 Mode de paiement <span class="text-red-500">*</span>
                    </label>
                    <div class="space-y-3">
                        <!-- Wave -->
                        <label class="flex items-start p-4 border-2 rounded-xl cursor-pointer transition-all {{ $payment_method === 'wave' ? 'border-primary-600 bg-primary-50' : 'border-gray-200 hover:border-primary-300' }}">
                            <input type="radio" 
                                wire:model.live="payment_method" 
                                value="wave" 
                                class="mt-1 h-5 w-5 text-primary-600 focus:ring-primary-500">
                            <div class="ml-3 flex-1">
                                <div class="flex items-center justify-between">
                                    <span class="font-semibold text-gray-900">Wave</span>
                                    <div class="flex items-center gap-1 bg-green-100 px-2 py-1 rounded-full">
                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-xs font-semibold text-green-700">Recommandé</span>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">Paiement sécurisé via Wave Money</p>
                            </div>
                        </label>

                        <!-- Orange Money -->
                        <label class="flex items-start p-4 border-2 rounded-xl cursor-pointer transition-all {{ $payment_method === 'orange_money' ? 'border-primary-600 bg-primary-50' : 'border-gray-200 hover:border-primary-300' }}">
                            <input type="radio" 
                                wire:model.live="payment_method" 
                                value="orange_money" 
                                class="mt-1 h-5 w-5 text-primary-600 focus:ring-primary-500">
                            <div class="ml-3 flex-1">
                                <span class="font-semibold text-gray-900">Orange Money</span>
                                <p class="text-sm text-gray-600 mt-1">Paiement via votre compte Orange Money</p>
                            </div>
                        </label>

                        <!-- Cash -->
                        <label class="flex items-start p-4 border-2 rounded-xl cursor-pointer transition-all {{ $payment_method === 'cash' ? 'border-primary-600 bg-primary-50' : 'border-gray-200 hover:border-primary-300' }}">
                            <input type="radio" 
                                wire:model.live="payment_method" 
                                value="cash" 
                                class="mt-1 h-5 w-5 text-primary-600 focus:ring-primary-500">
                            <div class="ml-3 flex-1">
                                <span class="font-semibold text-gray-900">Espèces à la livraison</span>
                                <p class="text-sm text-gray-600 mt-1">Payez en espèces lors de la réception</p>
                            </div>
                        </label>
                    </div>
                    @error('payment_method')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Numéro de téléphone Mobile Money (si Wave ou Orange Money) -->
                @if(in_array($payment_method, ['wave', 'orange_money']))
                <div class="mb-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-blue-500 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div class="flex-1">
                            <h4 class="font-semibold text-blue-900 mb-2">
                                Numéro {{ $payment_method === 'wave' ? 'Wave' : 'Orange Money' }}
                            </h4>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Numéro de téléphone <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 text-sm">🇸🇳 +221</span>
                                </div>
                                <input type="tel" 
                                    wire:model="payment_phone"
                                    placeholder="77 123 45 67"
                                    maxlength="9"
                                    class="block w-full pl-20 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('payment_phone') @enderror">
                            </div>
                            <p class="text-xs text-gray-600 mt-1">
                                ℹ️ Entrez le numéro lié à votre compte {{ $payment_method === 'wave' ? 'Wave' : 'Orange Money' }}
                            </p>
                            @error('payment_phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                @endif


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