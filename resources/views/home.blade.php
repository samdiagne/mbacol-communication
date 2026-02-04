@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-primary-600 to-secondary-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                Bienvenue chez Mbacol Communication
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-blue-100">
                Votre partenaire en électronique et matériel au Sénégal
            </p>
            <a href="{{ route('shop') }}" class="inline-block bg-white text-primary-600 font-bold px-8 py-4 rounded-lg hover:bg-gray-100 transition duration-200">
                Découvrir nos produits
            </a>
        </div>
    </div>
</div>

<!-- Catégories populaires -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h2 class="text-3xl font-bold text-center mb-12">Catégories populaires</h2>
    
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        @foreach($categories as $category)
        <a href="{{ route('shop') }}?category={{ $category->slug }}" class="group">
            <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition duration-200 p-6 text-center">
                <div class="h-32 flex items-center justify-center mb-4">
                    @switch($category->name)
                        @case('Smartphones')
                            <span class="text-6xl group-hover:scale-110 transition duration-200">📱</span>
                            @break
                        @case('Ordinateurs')
                            <span class="text-6xl group-hover:scale-110 transition duration-200">💻</span>
                            @break
                        @case('Accessoires')
                            <span class="text-6xl group-hover:scale-110 transition duration-200">🎧</span>
                            @break
                        @case('Tablettes')
                            <span class="text-6xl group-hover:scale-110 transition duration-200">📱</span>
                            @break
                        @default
                            <span class="text-6xl group-hover:scale-110 transition duration-200">🛍️</span>
                    @endswitch
                </div>
                <h3 class="text-lg font-bold mb-2 text-gray-900">{{ $category->name }}</h3>
                <p class="text-sm text-gray-600">{{ $category->description }}</p>
            </div>
        </a>
        @endforeach
    </div>
</div>

<!-- Produits en vedette -->
<div class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-12">
            <h2 class="text-3xl font-bold">Produits en vedette</h2>
            <a href="{{ route('shop') }}" class="text-primary-600 hover:text-primary-700 font-semibold flex items-center">
                Voir tout
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-8">
            @forelse($featuredProducts as $product)
            <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition duration-200 overflow-hidden group">
                <!-- Image produit -->
                <div class="relative h-64 bg-gray-200 overflow-hidden">
                    @if($product->main_image)
                        <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                    
                    <!-- Badge réduction -->
                    @if($product->discount_percentage > 0)
                    <div class="absolute top-2 right-2 bg-secondary-600 text-white px-3 py-1 rounded-full text-sm font-bold">
                        -{{ $product->discount_percentage }}%
                    </div>
                    @endif
                    
                    <!-- Badge stock -->
                    @if($product->stock < 5 && $product->stock > 0)
                    <div class="absolute top-2 left-2 bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                        Plus que {{ $product->stock }} !
                    </div>
                    @elseif($product->stock == 0)
                    <div class="absolute top-2 left-2 bg-gray-800 text-white px-3 py-1 rounded-full text-xs font-semibold">
                        Rupture de stock
                    </div>
                    @endif
                </div>
                
                <!-- Contenu -->
                <div class="p-6">
                    <!-- Catégorie -->
                    <p class="text-xs text-primary-600 font-semibold mb-2 uppercase">
                        {{ $product->category->name }}
                    </p>
                    
                    <!-- Nom -->
                    <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">
                        {{ $product->name }}
                    </h3>
                    
                    <!-- Description courte -->
                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                        {{ $product->short_description }}
                    </p>
                    
                    <!-- Prix -->
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
                    
                    <!-- Actions -->
                    <div class="flex gap-2">
                        <button class="flex-1 bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 rounded-lg transition duration-200 flex items-center justify-center"
                                @if($product->stock == 0) disabled @endif>
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            {{ $product->stock == 0 ? 'Rupture' : 'Ajouter' }}
                        </button>
                        <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 p-3 rounded-lg transition duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-12">
                <p class="text-gray-500 text-lg">Aucun produit en vedette pour le moment.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Section confiance -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-primary-100 text-primary-600 rounded-full mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold mb-2">Produits Garantis</h3>
            <p class="text-gray-600">Tous nos produits sont authentiques et garantis</p>
        </div>
        
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-primary-100 text-primary-600 rounded-full mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold mb-2">Paiement Sécurisé</h3>
            <p class="text-gray-600">Wave, Orange Money, Free Money</p>
        </div>
        
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-primary-100 text-primary-600 rounded-full mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold mb-2">Livraison Rapide</h3>
            <p class="text-gray-600">Livraison dans toute la région de Dakar</p>
        </div>
    </div>
</div>
@endsection