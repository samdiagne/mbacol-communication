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
                    <h2 class="text-xl font-bold mb-4">Adresse de livraison</h2>
                    
                    <div class="space-y-4">
                        <!-- Ville -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Ville <span class="text-red-500">*</span>
                            </label>
                            <select wire:model="customer_city"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('customer_city') @enderror">
                                <option value="Dakar">Dakar</option>
                                <option value="Pikine">Pikine</option>
                                <option value="Guédiawaye">Guédiawaye</option>
                                <option value="Rufisque">Rufisque</option>
                                <option value="Thiès">Thiès</option>
                                <option value="Saint-Louis">Saint-Louis</option>
                                <option value="Autre">Autre</option>
                            </select>
                            @error('customer_city')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Adresse complète -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Adresse complète <span class="text-red-500">*</span>
                            </label>
                            <textarea wire:model="customer_address"
                                      rows="3"
                                      placeholder="Quartier, rue, numéro, point de repère..."
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('customer_address') @enderror"></textarea>
                            @error('customer_address')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Paiement -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold mb-4">Mode de paiement</h2>

                    <div class="space-y-3">

                        <!-- Wave -->
                        <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer 
                            {{ $payment_method === 'wave' ? 'border-primary-600 bg-primary-50' : 'border-gray-200' }}">
                            <input type="radio"
                                name="payment_method"
                                wire:model="payment_method"
                                value="wave"
                                class="text-primary-600 focus:ring-primary-500">
                            <span class="ml-3 flex-1">
                                <span class="block font-semibold">Wave</span>
                                <span class="text-sm text-gray-500">Paiement mobile instantané</span>
                            </span>
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded">
                                Populaire
                            </span>
                        </label>

                        <!-- Orange Money -->
                        <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer 
                            {{ $payment_method === 'orange_money' ? 'border-primary-600 bg-primary-50' : 'border-gray-200' }}">
                            <input type="radio"
                                name="payment_method"
                                wire:model="payment_method"
                                value="orange_money"
                                class="text-primary-600 focus:ring-primary-500">
                            <span class="ml-3">
                                <span class="block font-semibold">Orange Money</span>
                                <span class="text-sm text-gray-500">Paiement mobile Orange</span>
                            </span>
                        </label>

                        <!-- Free Money -->
                        <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer 
                            {{ $payment_method === 'free_money' ? 'border-primary-600 bg-primary-50' : 'border-gray-200' }}">
                            <input type="radio"
                                name="payment_method"
                                wire:model="payment_method"
                                value="free_money"
                                class="text-primary-600 focus:ring-primary-500">
                            <span class="ml-3">
                                <span class="block font-semibold">Free Money</span>
                                <span class="text-sm text-gray-500">Paiement mobile Free</span>
                            </span>
                        </label>

                        <!-- Cash -->
                        <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer 
                            {{ $payment_method === 'cash' ? 'border-primary-600 bg-primary-50' : 'border-gray-200' }}">
                            <input type="radio"
                                name="payment_method"
                                wire:model="payment_method"
                                value="cash"
                                class="text-primary-600 focus:ring-primary-500">
                            <span class="ml-3">
                                <span class="block font-semibold">
                                    Paiement à la livraison (Dakar uniquement)
                                </span>
                                <span class="text-sm text-gray-500">
                                    Espèces à la réception
                                </span>
                            </span>
                        </label>

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
                            <span class="font-semibold">{{ number_format($shippingCost, 0, ',', ' ') }} FCFA</span>
                        </div>
                        <div class="border-t border-gray-200 pt-3">
                            <div class="flex justify-between">
                                <span class="text-lg font-bold">Total</span>
                                <span class="text-2xl font-bold text-primary-600">{{ number_format($total, 0, ',', ' ') }} FCFA</span>
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