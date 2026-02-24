@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    <!-- Fil d'Ariane -->
    <nav class="scroll-reveal flex mb-8 text-sm" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-2">
            <li>
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary-600">Accueil</a>
            </li>
            <li>
                <span class="text-gray-400">/</span>
            </li>
            <li>
                <a href="{{ route('shop') }}" class="text-gray-500 hover:text-primary-600">Boutique</a>
            </li>
            <li>
                <span class="text-gray-400">/</span>
            </li>
            <li>
                <a href="{{ route('shop', ['category' => $product->category->slug]) }}" class="text-gray-500 hover:text-primary-600">
                    {{ $product->category->name }}
                </a>
            </li>
            <li>
                <span class="text-gray-400">/</span>
            </li>
            <li class="text-gray-900 font-semibold">{{ $product->name }}</li>
        </ol>
    </nav>

    <!-- Contenu principal -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
        
        <!-- Galerie d'images avec ZOOM -->
        <div class="scroll-reveal-left" x-data="{ 
            activeImage: '{{ $product->main_image ? asset('storage/' . $product->main_image) : '' }}',
            zoom: false,
            position: { x: 0, y: 0 }
        }">
            <!-- Image principale avec ZOOM -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-4 relative">
                <div class="relative h-96 bg-gray-100 flex items-center justify-center overflow-hidden"
                     @mouseenter="zoom = true"
                     @mouseleave="zoom = false"
                     @mousemove="position = { x: ($event.offsetX / $event.target.offsetWidth) * 100, y: ($event.offsetY / $event.target.offsetHeight) * 100 }">
                    
                    <template x-if="activeImage">
                        <img :src="activeImage" 
                            alt="{{ $product->name }} - {{ $product->category->name }} - Mbacol Communication Sénégal" 
                            title="{{ $product->name }}"
                            loading="eager"
                            class="w-full h-full object-contain transition-transform duration-200"
                            :class="{ 'scale-150 cursor-zoom-in': zoom }"
                            :style="zoom ? `transform-origin: ${position.x}% ${position.y}%` : ''">
                    </template>
                    <template x-if="!activeImage">
                        <div class="text-gray-300">
                            <svg class="w-32 h-32" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </template>

                    @if($product->discount_percentage > 0)
                    <div class="absolute top-4 right-4 bg-secondary-600 text-white px-4 py-2 rounded-full text-lg font-bold">
                        -{{ $product->discount_percentage }}%
                    </div>
                    @endif

                    <!-- Indicateur ZOOM -->
                    <div x-show="!zoom" class="absolute bottom-4 right-4 bg-black/70 text-white px-3 py-1.5 rounded-lg text-sm font-medium">
                        🔍 Survolez pour zoomer
                    </div>
                </div>
            </div>

            <!-- Miniatures -->
            @if($product->images->count() > 0)
            <div class="grid grid-cols-4 gap-2">
                @if($product->main_image)
                <button @click="activeImage = '{{ asset('storage/' . $product->main_image) }}'"
                        :class="activeImage === '{{ asset('storage/' . $product->main_image) }}' ? 'border-primary-600 ring-2 ring-primary-600' : 'border-gray-200'"
                        class="relative h-20 bg-gray-100 rounded-lg overflow-hidden border-2 hover:border-primary-600 transition">
                    <x-product-image 
                        :src="asset('storage/' . $product->main_image)"
                        :product="$product"
                        :alt="$product->name . ' - Image principale'"
                        class="w-full h-full object-cover"
                        loading="eager" />
                </button>
                @endif
                
                @foreach($product->images as $image)
                <button @click="activeImage = '{{ asset('storage/' . $image->image_path) }}'"
                        :class="activeImage === '{{ asset('storage/' . $image->image_path) }}' ? 'border-primary-600 ring-2 ring-primary-600' : 'border-gray-200'"
                        class="relative h-20 bg-gray-100 rounded-lg overflow-hidden border-2 hover:border-primary-600 transition">
                    <x-product-image 
                        :src="asset('storage/' . $image->image_path)"
                        :product="$product"
                        :alt="$product->name . ' - Vue ' . $loop->iteration"
                        class="w-full h-full object-cover"
                        loading="eager" />
                </button>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Informations produit -->
        <div class="scroll-reveal-right">
            <!-- Catégorie -->
            <p class="text-sm text-primary-600 font-semibold mb-2 uppercase">
                {{ $product->category->name }}
            </p>

            <!-- Nom -->
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                {{ $product->name }}
            </h1>

            <!-- Avis et notes -->
            <div class="flex items-center gap-4 mb-6">
                <div class="flex items-center">
                    @php
                        $rating = 4.5;
                        $fullStars = floor($rating);
                        $hasHalfStar = ($rating - $fullStars) >= 0.5;
                    @endphp
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $fullStars)
                            <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                        @elseif($i == $fullStars + 1 && $hasHalfStar)
                            <svg class="w-5 h-5 text-yellow-400" viewBox="0 0 20 20">
                                <defs>
                                    <linearGradient id="half">
                                        <stop offset="50%" stop-color="#FBBF24"/>
                                        <stop offset="50%" stop-color="#E5E7EB"/>
                                    </linearGradient>
                                </defs>
                                <path fill="url(#half)" d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                        @else
                            <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                        @endif
                    @endfor
                    <span class="ml-2 text-sm font-semibold text-gray-700">{{ $rating }} / 5</span>
                </div>
                <span class="text-sm text-gray-500">(23 avis)</span>
            </div>

            <!-- Description courte -->
            <p class="text-lg text-gray-600 mb-6">
                {{ $product->short_description }}
            </p>

            <!-- Prix -->
            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                <div class="flex items-baseline gap-4">
                    <p class="text-4xl font-bold text-gray-900">
                        {{ $product->formatted_price }}
                    </p>
                    @if($product->old_price)
                    <p class="text-xl text-gray-500 line-through">
                        {{ $product->formatted_old_price }}
                    </p>
                    <span class="bg-secondary-600 text-white px-3 py-1 rounded-full text-sm font-bold">
                        Économisez {{ number_format($product->old_price - $product->price, 0, ',', ' ') }} FCFA
                    </span>
                    @endif
                </div>
            </div>

            <!-- Stock -->
            <div class="flex items-center gap-6 mb-6 text-sm">
                <div class="flex items-center">
                    <span class="text-gray-600 mr-2 font-medium">Disponibilité :</span>
                    @if($product->stock > 0)
                        <span class="inline-flex items-center text-green-600 font-semibold bg-green-50 px-3 py-1.5 rounded-full">
                            <svg class="w-5 h-5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            En stock
                        </span>
                    @else
                        <span class="inline-flex items-center text-red-600 font-semibold bg-red-50 px-3 py-1.5 rounded-full">
                            <svg class="w-5 h-5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            Épuisé
                        </span>
                    @endif
                </div>

                @if($product->sku)
                <div class="flex items-center text-gray-600">
                    <span class="mr-2">SKU :</span>
                    <span class="font-mono font-semibold">{{ $product->sku }}</span>
                </div>
                @endif
            </div>

            <!-- Quantité et Ajouter au panier -->
            @livewire('add-to-cart', ['product' => $product])

            <!-- Informations supplémentaires -->
            <div class="border-t border-gray-200 pt-6">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Garantie constructeur
                    </div>
                    <div class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Livraison rapide
                    </div>
                    <div class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Paiement sécurisé
                    </div>
                    <div class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Support client
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Description détaillée -->
    <div class="scroll-reveal bg-white rounded-lg shadow-md p-8 mb-16">
        <h2 class="text-2xl font-bold mb-6">Description du produit</h2>
        <div class="prose max-w-none text-gray-700">
            {!! nl2br(e($product->description)) !!}
        </div>
    </div>

    <!-- SECTION AVIS -->
    <div class="scroll-reveal bg-white rounded-lg shadow-md p-8 mb-16">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-8 gap-4">
            <div>
                <h2 class="text-2xl font-bold mb-2">Avis clients</h2>
                @if($product->reviews_count > 0)
                    <div class="flex items-center gap-3">
                        <div class="flex items-center">
                            @php
                                $avgRating = round($product->average_rating, 1);
                                $fullStars = floor($avgRating);
                                $hasHalfStar = ($avgRating - $fullStars) >= 0.5;
                            @endphp
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $fullStars)
                                    <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @elseif($i == $fullStars + 1 && $hasHalfStar)
                                    <svg class="w-5 h-5 text-yellow-400" viewBox="0 0 20 20">
                                        <defs>
                                            <linearGradient id="half">
                                                <stop offset="50%" stop-color="#FBBF24"/>
                                                <stop offset="50%" stop-color="#E5E7EB"/>
                                            </linearGradient>
                                        </defs>
                                        <path fill="url(#half)" d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @endif
                            @endfor
                            <span class="ml-2 text-sm font-semibold text-gray-700">{{ $avgRating }} / 5</span>
                        </div>
                        <span class="text-sm text-gray-500">({{ $product->reviews_count }} avis)</span>
                    </div>
                @else
                    <p class="text-gray-500">Aucun avis pour le moment</p>
                @endif
            </div>
            
            @auth
                <button @click="$dispatch('open-review-modal')" 
                        class="bg-primary-600 hover:bg-primary-700 text-white font-bold px-6 py-3 rounded-lg transition whitespace-nowrap">
                    ✍️ Rédiger un avis
                </button>
            @else
                <a href="{{ route('login') }}" 
                class="bg-gray-600 hover:bg-gray-700 text-white font-bold px-6 py-3 rounded-lg transition whitespace-nowrap">
                    Connectez-vous puis laisser un avis
                </a>
            @endauth
        </div>

        <!-- Liste des avis approuvés -->
        @if($product->approvedReviews->count() > 0)
            <div class="space-y-6">
                @foreach($product->approvedReviews as $review)
                <div class="border-b border-gray-200 pb-6 last:border-b-0">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-secondary-500 rounded-full flex items-center justify-center text-white font-bold flex-shrink-0">
                            {{ substr($review->user->name, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-2 gap-2">
                                <div>
                                    <h4 class="font-bold text-gray-900">{{ $review->user->name }}</h4>
                                    <div class="flex items-center mt-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }} fill-current" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                                <span class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-gray-700 break-words">{{ $review->comment }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-gray-400 mb-4">
                    <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                    </svg>
                </div>
                <p class="text-gray-600 font-semibold">Aucun avis pour ce produit</p>
                <p class="text-gray-500 text-sm mt-2">Soyez le premier à partager votre expérience !</p>
            </div>
        @endif
    </div>

    <!-- Modal Avis -->
    <div x-data="{ 
        reviewModalOpen: false, 
        rating: 0,
        comment: '',
        setRating(value) {
            this.rating = value;
        }
    }"
        @open-review-modal.window="reviewModalOpen = true"
        x-show="reviewModalOpen"
        @keydown.escape.window="reviewModalOpen = false"
        class="fixed inset-0 z-50 overflow-y-auto"
        style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" @click="reviewModalOpen = false"></div>
            
            <div class="bg-white rounded-2xl shadow-2xl p-6 sm:p-8 max-w-md w-full relative z-10">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl sm:text-2xl font-bold">Rédiger un avis</h3>
                    <button @click="reviewModalOpen = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('reviews.store', $product) }}" method="POST">
                    @csrf
                    
                    <!-- Note -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Votre note <span class="text-red-500">*</span>
                        </label>
                        <div class="flex gap-2">
                            <input type="hidden" name="rating" x-model="rating">
                            @for($i = 1; $i <= 5; $i++)
                            <button type="button" 
                                    @click="setRating({{ $i }})"
                                    class="transition-colors"
                                    :class="rating >= {{ $i }} ? 'text-yellow-400' : 'text-gray-300 hover:text-yellow-300'">
                                <svg class="w-8 h-8 fill-current" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                            </button>
                            @endfor
                        </div>
                        <p class="text-xs text-gray-500 mt-1" x-show="rating > 0" style="display: none;">
                            Vous avez donné <span x-text="rating"></span> étoile(s)
                        </p>
                        @error('rating')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Commentaire -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Votre avis <span class="text-red-500">*</span>
                        </label>
                        <textarea name="comment" 
                                rows="4" 
                                x-model="comment"
                                placeholder="Partagez votre expérience avec ce produit... (minimum 10 caractères)"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-sm @error('comment') @enderror"></textarea>
                        <p class="text-xs text-gray-500 mt-1">
                            <span x-text="comment.length"></span> / 1000 caractères
                        </p>
                        @error('comment')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" 
                            :disabled="rating === 0 || comment.length < 10"
                            :class="rating === 0 || comment.length < 10 ? 'bg-gray-400 cursor-not-allowed' : 'bg-primary-600 hover:bg-primary-700'"
                            class="w-full text-white font-bold py-3 rounded-lg transition text-sm sm:text-base">
                        Publier mon avis
                    </button>
                    
                    <p class="text-xs text-gray-500 mt-3 text-center">
                        Votre avis sera publié après validation par notre équipe
                    </p>
                </form>
            </div>
        </div>
    </div>

    <!-- Produits similaires -->
    @if($relatedProducts->count() > 0)
    <div class="mb-16">
        <h2 class="scroll-reveal text-2xl font-bold mb-8">Produits similaires</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($relatedProducts as $index => $relatedProduct)
            <div class="scroll-reveal-scale delay-{{ $index * 100 }} bg-white rounded-lg shadow-md hover:shadow-xl transition duration-200 overflow-hidden group">
                <a href="{{ route('product.show', $relatedProduct) }}" class="block relative h-48 bg-gray-200 overflow-hidden">
                    @if($relatedProduct->main_image)
                        <x-product-image 
                            :src="asset('storage/' . $relatedProduct->main_image)"
                            :product="$relatedProduct"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-300" />
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                </a>
                <div class="p-4">
                    <a href="{{ route('product.show', $relatedProduct) }}">
                        <h3 class="font-bold text-gray-900 mb-2 line-clamp-2 hover:text-primary-600">
                            {{ $relatedProduct->name }}
                        </h3>
                    </a>
                    <p class="text-lg font-bold text-gray-900">
                        {{ $relatedProduct->formatted_price }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection