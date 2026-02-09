<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Mbacol Communication') }} - @yield('title', 'Électronique et Matériel')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-50">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <!-- Logo -->
                        <a href="{{ route('home') }}" class="flex items-center">
                            <span class="text-2xl font-bold text-primary-600">Mbacol</span>
                            <span class="text-2xl font-bold text-secondary-600 ml-1">Communication</span>
                        </a>
                        
                        <!-- Menu principal -->
                        <div class="hidden md:flex md:ml-10 md:space-x-8">
                            <a href="{{ route('home') }}" class="text-gray-700 hover:text-primary-600 px-3 py-2 text-sm font-medium">
                                Accueil
                            </a>
                            <a href="{{ route('shop') }}" class="text-gray-700 hover:text-primary-600 px-3 py-2 text-sm font-medium">
                                Boutique
                            </a>
                            <a href="{{ route('about') }}" class="text-gray-700 hover:text-primary-600 px-3 py-2 text-sm font-medium">
                                À propos
                            </a>
                            <a href="{{ route('contact') }}" class="text-gray-700 hover:text-primary-600 px-3 py-2 text-sm font-medium">
                                Contact
                            </a>
                        </div>
                    </div>
                    
                    <!-- Panier et Compte -->
                    <div class="flex items-center space-x-4">
                        <!-- Recherche -->
                        <div class="hidden md:block">
                            <input type="search" placeholder="Rechercher..." class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        </div>
                        
                        <!-- Panier -->
                        @livewire('cart-icon')
                        
                        <!-- Compte -->
                        @auth
                            <a href="{{ route('customer.orders.index') }}" class="text-gray-700 hover:text-primary-600 text-sm font-medium">
                                Mes commandes
                            </a>
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-primary-600 text-sm font-medium">
                                    Admin
                                </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-gray-700 hover:text-primary-600 text-sm font-medium">
                                    Déconnexion
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-primary-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
        
        <!-- Contenu principal -->
        <main>
            @yield('content')
        </main>
        
        <!-- Footer -->
        <footer class="bg-gray-900 text-white mt-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-xl font-bold mb-4">
                            <span class="text-primary-400">Mbacol</span>
                            <span class="text-secondary-400">Communication</span>
                        </h3>
                        <p class="text-gray-400">Votre partenaire en électronique et matériel au Sénégal.</p>
                    </div>
                    
                    <div>
                        <h4 class="font-semibold mb-4">Liens rapides</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="{{ route('shop') }}" class="hover:text-white">Boutique</a></li>
                            <li><a href="{{ route('about') }}" class="hover:text-white">À propos</a></li>
                            <li><a href="{{ route('contact') }}" class="hover:text-white">Contact</a></li>
                            <li><a href="{{ route('terms') }}" class="hover:text-white">CGV</a></li>
                        </ul>
                    </div>
                    
                    <div>
                        <h4 class="font-semibold mb-4">Contact</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li>📞 +221 XX XXX XX XX</li>
                            <li>📧 contact@mbacol.sn</li>
                            <li>📍 Dakar, Sénégal</li>
                        </ul>
                    </div>
                    
                    <div>
                        <h4 class="font-semibold mb-4">Paiements acceptés</h4>
                        <div class="flex space-x-2">
                            <span class="px-3 py-1 bg-gray-800 rounded text-sm">Wave</span>
                            <span class="px-3 py-1 bg-gray-800 rounded text-sm">Orange</span>
                            <span class="px-3 py-1 bg-gray-800 rounded text-sm">Free</span>
                        </div>
                    </div>
                </div>
                
                <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                    <p>&copy; {{ date('Y') }} Mbacol Communication. Tous droits réservés.</p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Notification Toast -->
    <div x-data="{ 
        show: false, 
        message: '' 
    }" 
        @product-added.window="
            message = 'Produit ajouté au panier !';
            show = true;
            setTimeout(() => show = false, 3000);
        "
        x-show="show"
        x-transition
        class="fixed bottom-4 right-4 bg-green-600 text-white px-6 py-4 rounded-lg shadow-lg z-50"
        style="display: none;">
        <div class="flex items-center">
            <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span x-text="message"></span>
        </div>
    </div>

        <!-- Scroll to top button -->
    <button
        id="scrollToTopBtn"
        aria-label="Revenir en haut"
        class="fixed bottom-6 right-6 z-50 hidden items-center justify-center
            w-12 h-12 rounded-full bg-primary-600 text-white
            shadow-lg hover:bg-primary-700
            transition-all duration-300 ease-in-out
            focus:outline-none focus:ring-2 focus:ring-primary-400"
    >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5 15l7-7 7 7" />
        </svg>
    </button>

    @livewireScripts
</body>
</html>