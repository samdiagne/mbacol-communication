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

                <!-- Modes de paiement acceptés (informatif) -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h2 class="text-xl font-bold mb-1">💳 Modes de paiement acceptés</h2>
                    <p class="text-sm text-gray-500 mb-5">Vous choisirez votre mode de paiement sur la page sécurisée PayDunya après validation.</p>

                    <div class="grid grid-cols-5 gap-3">
                        <!-- Wave -->
                        <div class="flex flex-col items-center gap-2">
                            <div class="w-14 h-14 rounded-xl border border-gray-100 shadow-sm flex items-center justify-center bg-white p-1 overflow-hidden">
                                <img src="{{ asset('images/payment/wave.webp') }}" alt="Wave" class="max-w-full max-h-full object-contain">
                            </div>
                            <span class="text-xs text-gray-600 font-medium text-center">Wave</span>
                        </div>

                        <!-- Orange Money -->
                        <div class="flex flex-col items-center gap-2">
                            <div class="w-14 h-14 rounded-xl border border-gray-100 shadow-sm flex items-center justify-center bg-white p-1 overflow-hidden">
                                <img src="{{ asset('images/payment/orange-money.webp') }}" alt="Orange Money" class="max-w-full max-h-full object-contain">
                            </div>
                            <span class="text-xs text-gray-600 font-medium text-center">Orange Money</span>
                        </div>

                        <!-- Mixx by Yass -->
                        <div class="flex flex-col items-center gap-2">
                            <div class="w-14 h-14 rounded-xl border border-gray-100 shadow-sm flex items-center justify-center bg-white p-1 overflow-hidden">
                                <img src="{{ asset('images/payment/mixx-yass.webp') }}" alt="Mixx By Yass" class="max-w-full max-h-full object-contain">
                            </div>
                            <span class="text-xs text-gray-600 font-medium text-center">Mixx By Yass</span>
                        </div>

                        <!-- Visa -->
                        <div class="flex flex-col items-center gap-2">
                            <div class="w-14 h-14 rounded-xl border border-gray-100 shadow-sm flex items-center justify-center bg-white p-1 overflow-hidden">
                                <img src="{{ asset('images/payment/visa.webp') }}" alt="Visa" class="max-w-full max-h-full object-contain">
                            </div>
                            <span class="text-xs text-gray-600 font-medium text-center">Visa</span>
                        </div>

                        <!-- Mastercard -->
                        <div class="flex flex-col items-center gap-2">
                            <div class="w-14 h-14 rounded-xl border border-gray-100 shadow-sm flex items-center justify-center bg-white p-1 overflow-hidden">
                                <img src="{{ asset('images/payment/mastercard.webp') }}" alt="Mastercard" class="max-w-full max-h-full object-contain">
                            </div>
                            <span class="text-xs text-gray-600 font-medium text-center">Mastercard</span>
                        </div>
                    </div>

                    <!-- Badge sécurité -->
                    <div class="mt-5 p-3 bg-gray-50 rounded-lg border border-gray-200">
                        <div class="flex items-center gap-2 text-xs text-gray-600">
                            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-medium">Tous les paiements sont 100% sécurisés</span>
                            <span class="text-gray-400">•</span>
                            <span class="text-gray-500">Powered by PayDunya</span>
                        </div>
                    </div>
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