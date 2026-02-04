<div>
    @if($product->stock > 0)
        <div class="flex items-center gap-4 mb-4">
            <!-- Sélecteur de quantité -->
            <div class="flex items-center border border-gray-300 rounded-lg">
                <button wire:click="decrement" class="px-4 py-3 hover:bg-gray-100 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                    </svg>
                </button>
                <input type="number" 
                       wire:model.live="quantity" 
                       min="1" 
                       max="{{ $product->stock }}"
                       class="w-16 text-center border-0 focus:ring-0 font-semibold"
                       readonly>
                <button wire:click="increment" class="px-4 py-3 hover:bg-gray-100 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </button>
            </div>

            <!-- Bouton Ajouter -->
            <button wire:click="addToCart" 
                    class="flex-1 bg-primary-600 hover:bg-primary-700 text-white font-bold py-4 px-8 rounded-lg transition duration-200 flex items-center justify-center text-lg">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Ajouter au panier
            </button>
        </div>

        <!-- Notification -->
        <div x-data="{ show: @entangle('showNotification') }" 
             x-show="show" 
             x-transition
             @hide-notification.window="setTimeout(() => show = false, 3000)"
             class="bg-green-50 border-l-4 border-green-500 p-4 mb-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="text-green-700 font-semibold">✓ Produit ajouté au panier !</p>
            </div>
        </div>
    @else
        <div class="bg-gray-100 text-gray-700 font-bold py-4 px-8 rounded-lg text-center">
            Rupture de stock
        </div>
    @endif
</div>