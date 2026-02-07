@extends('layouts.app')

@section('title', 'Boutique')

@section('content')
<!-- Header Boutique -->
<div class="bg-gradient-to-r from-primary-600 to-secondary-600 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-4">Notre Boutique</h1>
        <p class="text-blue-100">Découvrez tous nos produits électroniques</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- Sidebar Filtres -->
        <aside class="w-full lg:w-64 flex-shrink-0">
            <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                
                <!-- Recherche -->
                <form method="GET" action="{{ route('shop') }}" class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Rechercher</label>
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Rechercher un produit..."
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <button type="submit" class="absolute right-2 top-2 text-gray-400 hover:text-primary-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                    </div>
                    @foreach(request()->except(['search', 'page']) as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                </form>

                <!-- Catégories -->
                <div class="mb-6">
                    <h3 class="text-sm font-semibold text-gray-700 mb-3">Catégories</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('shop') }}" 
                               class="flex items-center justify-between py-2 px-3 rounded-lg {{ !request('category') ? 'bg-primary-50 text-primary-600 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">
                                <span>Tous les produits</span>
                                <span class="text-xs bg-gray-100 px-2 py-1 rounded-full">{{ $categories->sum('products_count') }}</span>
                            </a>
                        </li>
                        @foreach($categories as $category)
                        <li>
                            <a href="{{ route('shop', ['category' => $category->slug]) }}" 
                               class="flex items-center justify-between py-2 px-3 rounded-lg {{ request('category') == $category->slug ? 'bg-primary-50 text-primary-600 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">
                                <span>{{ $category->name }}</span>
                                <span class="text-xs bg-gray-100 px-2 py-1 rounded-full">{{ $category->products_count }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Tri -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-700 mb-3">Trier par</h3>
                    <form method="GET" action="{{ route('shop') }}">
                        <select name="sort" 
                                onchange="this.form.submit()"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Plus récents</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Prix croissant</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nom (A-Z)</option>
                        </select>
                        @foreach(request()->except(['sort', 'page']) as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                    </form>
                </div>
            </div>
        </aside>

        <!-- Grille Produits -->
        <main class="flex-1">
            <!-- Info / Filtres actifs -->
            <div class="flex flex-wrap items-center justify-between mb-6 gap-4">
                <p class="text-gray-600">
                    <span class="font-semibold">{{ $products->total() }}</span> produit(s) trouvé(s)
                </p>
                
                @if(request('category') || request('search'))
                <div class="flex flex-wrap gap-2">
                    @if(request('category'))
                    <span class="inline-flex items-center px-3 py-1 bg-primary-100 text-primary-700 rounded-full text-sm">
                        {{ $categories->firstWhere('slug', request('category'))->name ?? '' }}
                        <a href="{{ route('shop', request()->except('category')) }}" class="ml-2 hover:text-primary-900">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    </span>
                    @endif
                    
                    @if(request('search'))
                    <span class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">
                        "{{ request('search') }}"
                        <a href="{{ route('shop', request()->except('search')) }}" class="ml-2 hover:text-gray-900">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    </span>
                    @endif
                </div>
                @endif
            </div>

            <!-- Produits -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @forelse($products as $product)
                <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition duration-200 overflow-hidden group">
                    <!-- Image -->
                    <a href="{{ route('product.show', $product) }}" class="block relative h-64 bg-gray-200 overflow-hidden">
                        @if($product->main_image)
                            <img src="{{ asset('storage/' . $product->main_image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        
                        @if($product->discount_percentage > 0)
                        <div class="absolute top-2 right-2 bg-secondary-600 text-white px-3 py-1 rounded-full text-sm font-bold">
                            -{{ $product->discount_percentage }}%
                        </div>
                        @endif
                    </a>
                    
                    <!-- Contenu -->
                    <div class="p-6">
                        <p class="text-xs text-primary-600 font-semibold mb-2 uppercase">
                            {{ $product->category->name }}
                        </p>
                        
                        <a href="{{ route('product.show', $product) }}" class="block">
                            <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2 hover:text-primary-600">
                                {{ $product->name }}
                            </h3>
                        </a>
                        
                        <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                            {{ $product->short_description }}
                        </p>
                        
                        <div class="flex items-center justify-between mb-4">
                            <div>
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
                        
                        <div class="flex gap-2">
                            @livewire('quick-add-to-cart', ['product' => $product], key('shop-'.$product->id))
                            
                            <a href="{{ route('product.show', $product) }}" 
                            class="bg-gray-100 hover:bg-gray-200 text-gray-700 p-3 rounded-lg transition duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-12">
                    <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-gray-500 text-lg mb-4">Aucun produit trouvé</p>
                    <a href="{{ route('shop') }}" class="text-primary-600 hover:text-primary-700 font-semibold">
                        Réinitialiser les filtres
                    </a>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
            <div class="flex justify-center">
                {{ $products->links() }}
            </div>
            @endif
        </main>
    </div>
</div>
@endsection