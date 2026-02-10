@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
<!-- Hero Section avec Gradient Animé -->
<div class="relative bg-gradient-to-br from-primary-600 via-primary-700 to-secondary-600 text-white overflow-hidden">
    <!-- Formes décoratives -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-blob"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-0 left-1/2 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-blob animation-delay-4000"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold mb-6 animate-fade-in">
                Bienvenue chez <br>
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-yellow-200 to-white">
                    Mbacol Communication
                </span>
            </h1>
            <p class="text-lg md:text-xl mb-10 text-white/90 max-w-3xl mx-auto leading-relaxed">
                Électronique, informatique et accessoires sélectionnés avec exigence.  
                <span class="text-yellow-200 font-medium">Qualité. Fiabilité. Livraison rapide.</span>
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('shop') }}" 
                   class="inline-flex items-center justify-center bg-white text-primary-600 font-bold px-8 py-4 rounded-xl hover:bg-gray-100 transform hover:scale-105 transition duration-300 shadow-2xl">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    Découvrir nos produits
                </a>
                <a href="{{ route('contact') }}" 
                   class="inline-flex items-center justify-center bg-transparent border-2 border-white text-white font-bold px-8 py-4 rounded-xl hover:bg-white hover:text-primary-600 transition duration-300">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Nous contacter
                </a>
            </div>
        </div>
    </div>

    <p class="mt-8 text-sm text-white/70 tracking-wide text-center">
    ★ Sélection rigoureuse • Paiement sécurisé • Support local
    </p>

</div>

<!-- Stats rapides -->
<div class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div class="bg-white/70 backdrop-blur-lg rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <p class="text-3xl md:text-4xl font-extrabold text-primary-600 mb-1">500+</p>
                <p class="text-sm text-gray-600">Produits</p>
            </div>
            <div class="bg-white/70 backdrop-blur-lg rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <p class="text-3xl md:text-4xl font-extrabold text-primary-600 mb-1">2K+</p>
                <p class="text-sm text-gray-600">Clients satisfaits</p>
            </div>
            <div class="bg-white/70 backdrop-blur-lg rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <p class="text-3xl md:text-4xl font-extrabold text-primary-600 mb-1">24/7</p>
                <p class="text-sm text-gray-600">Support client</p>
            </div>
            <div class="bg-white/70 backdrop-blur-lg rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <p class="text-3xl md:text-4xl font-extrabold text-primary-600 mb-1">🇸🇳</p>
                <p class="text-sm text-gray-600">Made in Senegal</p>
            </div>
        </div>
    </div>
</div>

<!-- Catégories populaires -->
<div class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Catégories populaires</h2>
            <p class="text-gray-600 text-lg">Explorez nos différentes gammes de produits</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
            @foreach($categories as $category)
            <a href="{{ route('shop') }}?category={{ $category->slug }}" 
               class="group relative bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 p-6 text-center overflow-hidden transform hover:-translate-y-2">
                <!-- Background gradient on hover -->
                <div class="absolute inset-0 bg-gradient-to-br from-primary-50 to-secondary-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                
                <!-- Content -->
                <div class="relative z-10">
                    <div class="h-24 md:h-32 flex items-center justify-center mb-4">
                        @switch($category->name)
                            @case('Smartphones')
                                <span class="text-5xl md:text-6xl group-hover:scale-110 transition-transform duration-300">📱</span>
                                @break
                            @case('Ordinateurs')
                                <span class="text-5xl md:text-6xl group-hover:scale-110 transition-transform duration-300">💻</span>
                                @break
                            @case('Accessoires')
                                <span class="text-5xl md:text-6xl group-hover:scale-110 transition-transform duration-300">🎧</span>
                                @break
                            @case('Tablettes')
                                <span class="text-5xl md:text-6xl group-hover:scale-110 transition-transform duration-300">📲</span>
                                @break
                            @default
                                <span class="text-5xl md:text-6xl group-hover:scale-110 transition-transform duration-300">🛍️</span>
                        @endswitch
                    </div>
                    <h3 class="text-base md:text-lg font-bold mb-2 text-gray-900 group-hover:text-primary-600 transition-colors">
                        {{ $category->name }}
                    </h3>
                    <p class="text-xs md:text-sm text-gray-600 line-clamp-2">{{ $category->description }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>

<!-- Produits en vedette -->
<div class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center mb-12">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">⭐ Produits en vedette</h2>
                <p class="text-gray-600">Les meilleures offres du moment</p>
            </div>
            <a href="{{ route('shop') }}" 
               class="mt-4 md:mt-0 inline-flex items-center text-primary-600 hover:text-primary-700 font-semibold group">
                Voir tout
                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            @forelse($featuredProducts as $product)
            <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 transform hover:-translate-y-2">
                <!-- Image produit -->
                <div class="relative h-64 bg-gradient-to-br from-gray-50 to-gray-100 overflow-hidden">
                    @if($product->main_image)
                        <img src="{{ asset('storage/' . $product->main_image) }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105">
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
                        @livewire('quick-add-to-cart', ['product' => $product], key('home-'.$product->id))
                        
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
            <div class="col-span-3 text-center py-12">
                <div class="text-6xl mb-4">🛍️</div>
                <p class="text-gray-500 text-lg">Aucun produit en vedette pour le moment.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Section confiance -->
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

<!-- CSS Animations -->
<style>
@keyframes blob {
    0%, 100% { transform: translate(0, 0) scale(1); }
    25% { transform: translate(20px, -50px) scale(1.1); }
    50% { transform: translate(-20px, 20px) scale(0.9); }
    75% { transform: translate(50px, 50px) scale(1.05); }
}

.animate-blob {
    animation: blob 7s infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}
</style>
@endsection