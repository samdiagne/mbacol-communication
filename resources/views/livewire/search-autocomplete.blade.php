<div class="relative" 
     x-data="{ 
         focused: false,
         highlightText(text, query) {
             if (!query) return text;
             const regex = new RegExp(`(${query})`, 'gi');
             return text.replace(regex, '<mark class=\'bg-yellow-200 font-semibold\'>$1</mark>');
         }
     }"
     @click.away="$wire.closeResults(); focused = false"
     @keydown.escape="$wire.closeResults(); focused = false"
     @keydown.arrow-down.prevent="$wire.moveDown()"
     @keydown.arrow-up.prevent="$wire.moveUp()"
     @keydown.enter.prevent="$wire.selectCurrent()">
    
    <!-- Champ de recherche -->
    <form wire:submit.prevent="search" class="relative">
        <input type="search" 
               wire:model.live.debounce.300ms="query"
               @focus="focused = true; $wire.set('showResults', true); $wire.loadRecentSearches()"
               placeholder="Rechercher un produit, catégorie..." 
               class="w-full pl-12 pr-4 py-3 border-2 border-gray-300 rounded-2xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200 hover:border-primary-300"
               :class="focused ? 'border-primary-500 shadow-lg' : ''"
               autocomplete="off">
        
        <!-- Icône loupe -->
        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>

        <!-- Bouton clear -->
        @if($query)
        <button type="button" 
                wire:click="$set('query', ''); $set('showResults', false)"
                class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        @endif
    </form>

    <!-- Dropdown Résultats -->
    @if($showResults)
    <div class="absolute top-full left-0 right-0 mt-2 bg-white rounded-2xl shadow-2xl border border-gray-200 max-h-[32rem] overflow-y-auto z-50"
         x-show="focused || $wire.showResults"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-1">
        
        @if(strlen($query) < 2)
            <!-- Historique & Populaires (quand pas de recherche active) -->
            <div class="p-4">
                @if(count($recentSearches) > 0)
                <div class="mb-4">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-bold text-gray-700 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Recherches récentes
                        </h3>
                        <button wire:click="clearHistory" 
                                class="text-xs text-gray-500 hover:text-red-600 transition">
                            Effacer
                        </button>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @foreach($recentSearches as $recent)
                        <button wire:click="selectRecentSearch('{{ $recent }}')"
                                class="px-3 py-1.5 bg-gray-100 hover:bg-primary-50 text-gray-700 hover:text-primary-600 rounded-full text-sm transition-all duration-200 flex items-center gap-2 group">
                            <svg class="w-3 h-3 text-gray-400 group-hover:text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            {{ $recent }}
                        </button>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(count($popularSearches) > 0)
                <div>
                    <h3 class="text-sm font-bold text-gray-700 mb-3 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        Recherches populaires
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($popularSearches as $popular)
                        <button wire:click="selectRecentSearch('{{ $popular }}')"
                                class="px-3 py-1.5 bg-gradient-to-r from-primary-50 to-secondary-50 hover:from-primary-100 hover:to-secondary-100 text-primary-700 rounded-full text-sm transition-all duration-200 flex items-center gap-2 group">
                            <svg class="w-3 h-3 text-primary-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            {{ $popular }}
                        </button>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(count($recentSearches) === 0 && count($popularSearches) === 0)
                <div class="text-center py-8 text-gray-500">
                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <p class="text-sm">Commencez à taper pour rechercher</p>
                </div>
                @endif
            </div>

        @elseif($results->count() > 0 || $categories->count() > 0)
            <!-- Header avec Stats Détaillées -->
            <div class="px-4 py-3 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-primary-50/30 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-semibold text-gray-700">
                        <span class="text-primary-600 font-bold">{{ $results->count() + $categories->count() }}</span> résultat(s) trouvé(s)
                    </p>
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        @if($categories->count() > 0)
                        <span class="bg-primary-100 text-primary-700 px-2 py-1 rounded-full font-semibold">
                            {{ $categories->count() }} {{ $categories->count() > 1 ? 'catégories' : 'catégorie' }}
                        </span>
                        @endif
                        @if($results->count() > 0)
                        <span class="bg-secondary-100 text-secondary-700 px-2 py-1 rounded-full font-semibold">
                            {{ $results->count() }} {{ $results->count() > 1 ? 'produits' : 'produit' }}
                        </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="py-2">
            <!-- Catégories Intelligentes -->
            @if($categories->count() > 0)
            <div class="mb-2">
                <div class="px-4 py-2 flex items-center justify-between">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider flex items-center">
                        <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        Catégories pertinentes
                    </p>
                    <span class="text-xs text-gray-400">{{ $categories->count() }}</span>
                </div>
                @foreach($categories as $index => $category)
                <button wire:click="selectCategory('{{ $category->slug }}')"
                        class="w-full flex items-center gap-3 px-4 py-3 hover:bg-primary-50 transition-all duration-200 group"
                        :class="$wire.selectedIndex === {{ $index }} ? 'bg-primary-100 border-l-4 border-primary-600' : ''">
                    
                    <!-- Icône Catégorie avec Badge Compteur -->
                    <div class="relative flex-shrink-0">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary-100 to-secondary-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200 shadow-sm">
                            <span class="text-2xl">
                                @switch($category->name)
                                    @case('Smartphones') 📱 @break
                                    @case('Ordinateurs') 💻 @break
                                    @case('Accessoires') 🎧 @break
                                    @case('Tablettes') 📲 @break
                                    @case('Audio') 🔊 @break
                                    @case('Gaming') 🎮 @break
                                    @case('Photo') 📷 @break
                                    @case('Montres') ⌚ @break
                                    @default 🛍️
                                @endswitch
                            </span>
                        </div>
                        <!-- Badge compteur -->
                        <div class="absolute -top-1 -right-1 bg-primary-600 text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center shadow-lg border-2 border-white">
                            {{ $category->matching_products_count }}
                        </div>
                    </div>

                    <!-- Info Catégorie -->
                    <div class="flex-1 text-left min-w-0">
                        <p class="font-bold text-gray-900 group-hover:text-primary-600 transition-colors truncate" 
                        x-html="highlightText('{{ $category->name }}', '{{ $query }}')">
                        </p>
                        <div class="flex items-center gap-2 mt-0.5">
                            <span class="text-xs text-gray-500">
                                {{ $category->matching_products_count }} 
                                {{ $category->matching_products_count > 1 ? 'produits trouvés' : 'produit trouvé' }}
                            </span>
                            <span class="text-xs text-primary-600 opacity-0 group-hover:opacity-100 transition-opacity">
                                → Voir tous
                            </span>
                        </div>
                    </div>

                    <!-- Flèche -->
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-primary-600 group-hover:translate-x-1 transition-all duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </button>
                @endforeach
                
                <!-- Séparateur -->
                <div class="px-4 py-2">
                    <div class="border-t border-gray-200"></div>
                </div>
            </div>
            @endif

                <!-- Produits -->
                @if($results->count() > 0)
                <div>
                    <div class="px-4 py-2">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Produits</p>
                    </div>
                    @foreach($results as $index => $product)
                    @php
                        $itemIndex = $categories->count() + $index;
                    @endphp
                    <button wire:click="selectProduct({{ $product->id }})"
                            class="w-full flex items-center gap-4 px-4 py-3 hover:bg-primary-50 transition-colors group"
                            :class="$wire.selectedIndex === {{ $itemIndex }} ? 'bg-primary-50' : ''">
                        
                        <!-- Image -->
                        <div class="w-12 h-12 flex-shrink-0 bg-gray-100 rounded-lg overflow-hidden">
                            @if($product->main_image)
                                <img src="{{ asset('storage/' . $product->main_image) }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-200">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Info -->
                        <div class="flex-1 min-w-0 text-left">
                            <p class="font-semibold text-gray-900 truncate group-hover:text-primary-600 transition-colors"
                               x-html="highlightText('{{ $product->name }}', '{{ $query }}')">
                            </p>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full">
                                    {{ $product->category->name }}
                                </span>
                                <span class="text-sm font-bold text-primary-600">
                                    {{ number_format($product->price, 0, ',', ' ') }} FCFA
                                </span>
                            </div>
                        </div>

                        <!-- Flèche -->
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-primary-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </button>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Footer -->
            <div class="px-4 py-3 border-t border-gray-200 bg-gray-50 rounded-b-2xl">
                <button wire:click="search"
                        class="w-full text-center text-sm font-semibold text-primary-600 hover:text-primary-700 transition">
                    Voir tous les résultats pour "{{ $query }}" →
                </button>
            </div>

        @else
            <!-- Aucun résultat -->
            <div class="px-6 py-8 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-gray-900 font-semibold mb-1">Aucun produit trouvé</p>
                <p class="text-sm text-gray-500 mb-4">
                    "<span class="font-semibold">{{ $query }}</span>" n'est pas disponible sur notre site
                </p>
                <a href="{{ route('shop') }}" 
                   class="inline-flex items-center text-sm text-primary-600 hover:text-primary-700 font-semibold">
                    Parcourir tous les produits
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        @endif
    </div>
    @endif

    <!-- Loading -->
    <div wire:loading wire:target="query" 
         class="absolute top-full left-0 right-0 mt-2 bg-white rounded-2xl shadow-lg border border-gray-200 px-4 py-3 z-50">
        <div class="flex items-center justify-center gap-2 text-gray-600">
            <svg class="animate-spin h-5 w-5 text-primary-600" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-sm">Recherche en cours...</span>
        </div>
    </div>
</div>