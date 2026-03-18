@props(['product', 'index' => 0])

<div class="scroll-reveal-scale delay-{{ ($index % 3) * 100 }} group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 transform hover:-translate-y-2">
    <!-- Image produit -->
    <div class="relative h-64 bg-gradient-to-br from-gray-50 to-gray-100 overflow-hidden">
        @if($product->main_image)
            <x-product-image 
                :src="asset('storage/' . $product->main_image)"
                :product="$product"
                class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105" />
        @else
            <div class="w-full h-full flex items-center justify-center text-gray-300">
                <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        @endif
        
        <!-- Badge réduction -->
        @if($product->discount_percentage > 0)
        <div class="absolute top-3 right-3 bg-gradient-to-r from-red-500 to-pink-500 text-white px-3 py-1.5 rounded-full text-sm font-bold shadow-lg backdrop-blur bg-white/20 border border-white/30">
            -{{ $product->discount_percentage }}%
        </div>
        @endif
        
        <!-- Badge stock -->
        @if($product->stock < 5 && $product->stock > 0)
        <div class="absolute top-3 left-3 bg-yellow-500 text-white px-3 py-1.5 rounded-full text-xs font-bold shadow-lg">
            ⚡ Plus que {{ $product->stock }} !
        </div>
        @elseif($product->stock == 0)
        <div class="absolute top-3 left-3 bg-gray-800 text-white px-3 py-1.5 rounded-full text-xs font-bold shadow-lg">
            Rupture
        </div>
        @endif

        <!-- Quick view overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center">
            <a href="{{ route('product.show', $product) }}" 
               class="opacity-0 group-hover:opacity-100 transform scale-0 group-hover:scale-100 transition-all duration-300 bg-white text-primary-600 px-6 py-3 rounded-full font-semibold shadow-xl hover:bg-primary-600 hover:text-white">
                Voir le produit
            </a>
        </div>
    </div>
    
    <!-- Contenu -->
    <div class="p-6">
        <!-- Catégorie -->
        <p class="text-xs text-primary-600 font-bold mb-2 uppercase tracking-wider">
            {{ $product->category->name }}
        </p>
        
        <!-- Nom -->
        <a href="{{ route('product.show', $product) }}">
            <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2 hover:text-primary-600 transition-colors min-h-[3.5rem]">
                {{ $product->name }}
            </h3>
        </a>
        
        <!-- Description courte -->
        <p class="text-sm text-gray-600 mb-4 line-clamp-2 min-h-[2.5rem]">
            {{ $product->short_description }}
        </p>
        
        <!-- Prix -->
        <div class="mb-4">
            <div class="flex items-baseline gap-2">
                <p class="text-2xl font-bold text-gray-900">
                    {{ $product->formatted_price }}
                </p>
                @if($product->old_price)
                <p class="text-sm text-gray-500 line-through">
                    {{ $product->formatted_old_price }}
                </p>
                @endif
            </div>
        </div>
        
        <!-- Actions -->
        <div class="flex gap-2">
            @livewire('quick-add-to-cart', ['product' => $product], key('product-card-'.$product->id))
            
            <a href="{{ route('product.show', $product) }}" 
               class="flex-shrink-0 bg-gray-100 hover:bg-primary-600 hover:text-white text-gray-700 p-3 rounded-xl transition-all duration-200 group/btn">
                <svg class="w-5 h-5 group-hover/btn:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            </a>
        </div>
    </div>
</div>
