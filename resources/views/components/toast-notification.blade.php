<!-- Notification Toast -->
<div x-data="{ show: false, message: '' }" 
     @product-added.window="message = 'Produit ajouté au panier !'; show = true; setTimeout(() => show = false, 3000);"
     x-show="show"
     x-transition
     class="fixed bottom-24 right-6 bg-green-600 text-white px-6 py-4 rounded-xl shadow-2xl z-50 max-w-sm"
     style="display: none;">
    <div class="flex items-center">
        <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        <span x-text="message" class="font-semibold"></span>
    </div>
</div>
