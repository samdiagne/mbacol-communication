@extends('layouts.app-refactored')

@section('title', 'Accueil')

@section('content')
<!-- Hero Section avec Gradient Animé -->
<div class="scroll-reveal relative bg-gradient-to-br from-primary-600 via-primary-700 to-secondary-600 text-white overflow-hidden">
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
<div class="scroll-reveal bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div class="scroll-reveal-scale delay-100 bg-white/70 backdrop-blur-lg rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <p class="text-3xl md:text-4xl font-extrabold text-primary-600 mb-1">500+</p>
                <p class="text-sm text-gray-600">Produits</p>
            </div>
            <div class="scroll-reveal-scale delay-200 bg-white/70 backdrop-blur-lg rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <p class="text-3xl md:text-4xl font-extrabold text-primary-600 mb-1">2K+</p>
                <p class="text-sm text-gray-600">Clients satisfaits</p>
            </div>
            <div class="scroll-reveal-scale delay-300 bg-white/70 backdrop-blur-lg rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <p class="text-3xl md:text-4xl font-extrabold text-primary-600 mb-1">24/7</p>
                <p class="text-sm text-gray-600">Support client</p>
            </div>
            <div class="scroll-reveal-scale delay-400 bg-white/70 backdrop-blur-lg rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <p class="text-3xl md:text-4xl font-extrabold text-primary-600 mb-1">🇸🇳</p>
                <p class="text-sm text-gray-600">Made in Senegal</p>
            </div>
        </div>
    </div>
</div>

<!-- Catégories populaires -->
<div class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="scroll-reveal text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Catégories populaires</h2>
            <p class="text-gray-600 text-lg">Explorez nos différentes gammes de produits</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
            @foreach($categories as $index => $category)
            <a href="{{ route('shop') }}?category={{ $category->slug }}" 
               class="scroll-reveal delay-{{ ($index % 4) * 100 }} group relative bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 p-6 text-center overflow-hidden transform hover:-translate-y-2">
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

<!-- Produits en vedette - REFACTORISÉ avec Component -->
<div class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="scroll-reveal flex flex-col md:flex-row justify-between items-center mb-12">
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
        
        <!-- ✅ REFACTORISÉ : Utilisation du component product-card -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            @forelse($featuredProducts as $index => $product)
                <x-product-card :product="$product" :index="$index" />
            @empty
            <div class="col-span-3 text-center py-12">
                <div class="text-6xl mb-4">🛍️</div>
                <p class="text-gray-500 text-lg">Aucun produit en vedette pour le moment.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Avis Clients Carousel -->
<div class="bg-gradient-to-br from-gray-50 to-gray-100 py-16 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="scroll-reveal text-center mb-12">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl mb-4 shadow-xl">
                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
            </div>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">⭐ Ce que disent nos clients</h2>
            <p class="text-gray-600 text-lg">Découvrez les avis authentiques de notre communauté</p>
        </div>

        @if($reviews->count() > 0)
        <!-- Carousel Container -->
        <div class="scroll-reveal" x-data="{
            currentIndex: 0,
            reviews: {{ $reviews->count() }},
            autoplay: null,
            init() {
                this.startAutoplay();
            },
            startAutoplay() {
                this.autoplay = setInterval(() => {
                    this.next();
                }, 5000);
            },
            stopAutoplay() {
                clearInterval(this.autoplay);
            },
            next() {
                this.currentIndex = (this.currentIndex + 1) % this.reviews;
            },
            prev() {
                this.currentIndex = (this.currentIndex - 1 + this.reviews) % this.reviews;
            },
            goTo(index) {
                this.currentIndex = index;
                this.stopAutoplay();
                this.startAutoplay();
            }
        }" 
             @mouseenter="stopAutoplay()" 
             @mouseleave="startAutoplay()"
             class="relative">
            
            <!-- Cards Container -->
            <div class="relative h-[400px] md:h-[320px]">
                @foreach($reviews as $index => $review)
                <div x-show="currentIndex === {{ $index }}"
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 translate-x-full"
                     x-transition:enter-end="opacity-100 translate-x-0"
                     x-transition:leave="transition ease-in duration-500"
                     x-transition:leave-start="opacity-100 translate-x-0"
                     x-transition:leave-end="opacity-0 -translate-x-full"
                     class="absolute inset-0"
                     style="display: none;">
                    
                    <div class="bg-white rounded-2xl shadow-2xl p-8 md:p-10 mx-auto max-w-4xl border border-gray-200 hover:shadow-3xl transition-shadow duration-300">
                        <div class="flex flex-col md:flex-row gap-6">
                            <!-- Avatar + Info Client -->
                            <div class="flex-shrink-0 text-center md:text-left">
                                <div class="w-20 h-20 md:w-24 md:h-24 bg-gradient-to-br from-primary-500 to-secondary-500 rounded-full flex items-center justify-center text-white font-bold text-3xl mx-auto md:mx-0 shadow-lg mb-3">
                                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                </div>
                                <h4 class="font-bold text-gray-900 text-lg">{{ $review->user->name }}</h4>
                                <p class="text-sm text-gray-500">Client vérifié</p>
                                
                                <!-- Note étoiles -->
                                <div class="flex justify-center md:justify-start gap-1 mt-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                            </div>

                            <!-- Contenu Avis -->
                            <div class="flex-1">
                                <!-- Quote Icon -->
                                <svg class="w-10 h-10 text-primary-200 mb-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                                </svg>

                                <!-- Commentaire -->
                                <p class="text-gray-700 text-lg leading-relaxed mb-4 italic">
                                    "{{ $review->comment }}"
                                </p>

                                <!-- Produit concerné -->
                                <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                                    <div class="w-12 h-12 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                        @if($review->product->main_image)
                                            <x-product-image 
                                                :src="asset('storage/' . $review->product->main_image)"
                                                :product="$review->product"
                                                class="w-full h-full object-cover" />
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $review->product->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</p>
                                    </div>
                                    <a href="{{ route('product.show', $review->product) }}" 
                                       class="flex-shrink-0 text-primary-600 hover:text-primary-700 font-semibold text-sm flex items-center gap-1 group">
                                        Voir
                                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Navigation Arrows -->
            <button @click="prev()" 
                    class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 md:-translate-x-12 bg-white hover:bg-primary-600 text-gray-800 hover:text-white w-12 h-12 rounded-full shadow-xl flex items-center justify-center transition-all duration-200 hover:scale-110 z-10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>

            <button @click="next()" 
                    class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 md:translate-x-12 bg-white hover:bg-primary-600 text-gray-800 hover:text-white w-12 h-12 rounded-full shadow-xl flex items-center justify-center transition-all duration-200 hover:scale-110 z-10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>

            <!-- Dots Navigation -->
            <div class="flex justify-center gap-2 mt-8">
                @foreach($reviews as $index => $review)
                <button @click="goTo({{ $index }})"
                        :class="currentIndex === {{ $index }} ? 'bg-primary-600 w-8' : 'bg-gray-300 w-2 hover:bg-gray-400'"
                        class="h-2 rounded-full transition-all duration-300">
                </button>
                @endforeach
            </div>

            <!-- Progress Bar -->
            <div class="mt-6 h-1 bg-gray-200 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-primary-600 to-secondary-600 rounded-full transition-all duration-5000 ease-linear"
                     :style="`width: ${((currentIndex + 1) / reviews) * 100}%`">
                </div>
            </div>
        </div>

        @else
        <!-- État vide -->
        <div class="scroll-reveal text-center py-12 bg-white rounded-2xl shadow-lg">
            <div class="text-6xl mb-4">💬</div>
            <p class="text-gray-500 text-lg">Aucun avis pour le moment.</p>
            <p class="text-gray-400 text-sm mt-2">Soyez le premier à partager votre expérience !</p>
        </div>
        @endif

        <!-- CTA Laisser un avis -->
        <div class="scroll-reveal text-center mt-12">
            <p class="text-gray-600 mb-4">Vous avez acheté chez nous ?</p>
            <a href="{{ route('shop') }}" 
               class="inline-flex items-center bg-gradient-to-r from-primary-600 to-secondary-600 text-white font-bold px-8 py-4 rounded-xl hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
                Laisser un avis sur de nos produits
            </a>
        </div>
    </div>
</div>

<!-- Section confiance -->
<div class="bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="scroll-reveal delay-100 text-center group">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-green-400 to-green-600 text-white rounded-2xl mb-4 shadow-xl group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">✅ Produits Garantis</h3>
                <p class="text-gray-600">Tous nos produits sont authentiques avec garantie constructeur</p>
            </div>
            
            <div class="scroll-reveal delay-200 text-center group">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-400 to-blue-600 text-white rounded-2xl mb-4 shadow-xl group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">💳 Paiement Sécurisé</h3>
                <p class="text-gray-600">Wave, Orange Money, Cash...</p>
            </div>
            
            <div class="scroll-reveal delay-300 text-center group">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-purple-400 to-purple-600 text-white rounded-2xl mb-4 shadow-xl group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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