@extends('layouts.app')

@section('title', 'Boutique')

@section('content')

<!-- HERO BOUTIQUE -->
<section class="relative overflow-hidden bg-gradient-to-br from-primary-600 via-primary-500 to-secondary-600">
    <div class="absolute inset-0 bg-black/20"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center text-white">
        <h1 class="text-4xl md:text-6xl font-extrabold mb-4 tracking-tight">
            🛍️ Notre Boutique
        </h1>
        <p class="text-lg md:text-xl text-white/90 max-w-2xl mx-auto">
            Découvrez notre sélection de produits high-tech fiables, testés et garantis
        </p>
    </div>
</section>

<!-- CONTENU -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <!-- FILTRES -->
    <div class="bg-white/90 backdrop-blur rounded-2xl shadow-xl border border-gray-100 p-6 mb-10">
        <form method="GET" action="{{ route('shop') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <!-- Recherche -->
            <div class="md:col-span-2">
                <label class="text-sm font-semibold text-gray-700 mb-1 block">🔍 Recherche</label>
                <input type="search"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Produit, marque, modèle…"
                       class="w-full px-4 py-3 rounded-xl border-gray-300 focus:ring-primary-500 focus:border-primary-500 transition">
            </div>

            <!-- Catégorie -->
            <div>
                <label class="text-sm font-semibold text-gray-700 mb-1 block">📂 Catégorie</label>
                <select name="category"
                        class="w-full px-4 py-3 rounded-xl border-gray-300 focus:ring-primary-500 focus:border-primary-500 transition">
                    <option value="">Toutes</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->slug }}" @selected(request('category') == $cat->slug)>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Tri -->
            <div>
                <label class="text-sm font-semibold text-gray-700 mb-1 block">⚡ Trier</label>
                <select name="sort"
                        class="w-full px-4 py-3 rounded-xl border-gray-300 focus:ring-primary-500 focus:border-primary-500 transition">
                    <option value="newest">Plus récents</option>
                    <option value="price_asc">Prix ↑</option>
                    <option value="price_desc">Prix ↓</option>
                    <option value="name">Nom A-Z</option>
                </select>
            </div>

            <!-- Actions -->
            <div class="md:col-span-4 flex flex-col sm:flex-row gap-3 mt-2">
                <button type="submit"
                        class="flex-1 bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 rounded-xl shadow-lg hover:scale-[1.02] transition">
                    Appliquer les filtres
                </button>
                <a href="{{ route('shop') }}"
                   class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 rounded-xl transition">
                    Réinitialiser
                </a>
            </div>
        </form>
    </div>

    <!-- COMPTEUR -->
    <div class="flex justify-between items-center mb-6">
        <p class="text-gray-600">
            <span class="font-bold text-gray-900">{{ $products->total() }}</span>
            produit(s) trouvé(s)
        </p>
    </div>

        <!-- PRODUITS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

        @forelse($products as $product)
        <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl border border-gray-100 overflow-hidden transition-all duration-300 hover:-translate-y-2">

            <!-- IMAGE -->
            <a href="{{ route('product.show', $product) }}" class="relative block aspect-[4/3] bg-gray-100 overflow-hidden">
                @if($product->main_image)
                    <x-product-image 
                        :src="asset('storage/' . $product->main_image)"
                        :product="$product"
                        class="w-full h-full object-cover group-hover:scale-110 transition duration-500" />
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                        <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif

                <!-- Badge réduction -->
                @if($product->discount_percentage > 0)
                <div class="absolute top-3 right-3 bg-gradient-to-r from-red-500 to-pink-500 text-white px-3 py-1.5 rounded-full text-sm font-bold shadow-lg animate-pulse">
                    -{{ $product->discount_percentage }}%
                </div>
                @endif
            </a>

            <!-- TEXTE -->
            <div class="p-5">
                <p class="text-xs text-primary-600 font-bold uppercase mb-1">
                    {{ $product->category->name }}
                </p>

                <h3 class="font-bold text-gray-900 mb-2 line-clamp-2">
                    {{ $product->name }}
                </h3>

                <div class="flex items-center gap-2 mb-4">
                    <span class="text-lg font-extrabold text-gray-900">
                        {{ $product->formatted_price }}
                    </span>
                    @if($product->old_price)
                        <span class="text-sm line-through text-gray-400">
                            {{ $product->formatted_old_price }}
                        </span>
                    @endif
                </div>

                <!-- Actions -->
                <div class="flex gap-2">
                    @livewire('quick-add-to-cart', ['product' => $product], key('shop-'.$product->id))
                    
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
        @empty

        <!-- ÉTAT VIDE -->
        <div class="col-span-full">
            <div class="bg-white rounded-2xl shadow-xl p-16 text-center">
                <div class="text-7xl mb-6">😕</div>
                <h3 class="text-2xl font-bold mb-4">Aucun produit trouvé</h3>
                <a href="{{ route('shop') }}"
                   class="inline-block bg-primary-600 hover:bg-primary-700 text-white px-8 py-3 rounded-xl transition">
                    Réinitialiser
                </a>
            </div>
        </div>
        @endforelse
    </div>

    <!-- PAGINATION -->
    @if($products->hasPages())
        <div class="mt-12 flex justify-center">
            {{ $products->links() }}
        </div>
    @endif

</section>

<!-- Section confiance (bas de page) -->
<div class="bg-gradient-to-br from-gray-50 to-gray-100 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center group">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-green-400 to-green-600 text-white rounded-2xl mb-4 shadow-xl group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-16 h-16 rounded-xl" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">✅ Produits Garantis</h3>
                <p class="text-gray-600">Tous nos produits sont authentiques avec garantie constructeur</p>
            </div>
            
            <div class="text-center group">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-400 to-blue-600 text-white rounded-2xl mb-4 shadow-xl group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-16 h-16 rounded-xl" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">💳 Paiement Sécurisé</h3>
                <p class="text-gray-600">Wave, Orange Money, Free Money...</p>
            </div>
            
            <div class="text-center group">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-purple-400 to-purple-600 text-white rounded-2xl mb-4 shadow-xl group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-16 h-16 rounded-xl" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">🚚 Livraison Rapide</h3>
                <p class="text-gray-600">Livraison express dans toute la région de Dakar</p>
            </div>
        </div>
    </div>
</div>

@endsection
