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
<body class="font-sans antialiased" x-data="{ mobileMenuOpen: false, searchOpen: false }"> 
    <div class="min-h-screen bg-gray-50">

       <!-- Navigation fixe -->
        <nav class="bg-white shadow-md border-b border-gray-200 fixed top-0 left-0 right-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16 md:h-20">
                    
                    <!-- Menu Burger avec Rotation du Container -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" 
                            class="md:hidden relative w-10 h-10 flex items-center justify-center rounded-xl hover:bg-gradient-to-br hover:from-primary-50 hover:to-secondary-50 transition-all duration-300 p-2 -ml-2 group"
                            :class="mobileMenuOpen ? 'rotate-180 bg-gradient-to-br from-primary-50 to-secondary-50 scale-110' : ''">
                        <div class="w-6 h-5 relative flex flex-col justify-between transition-transform duration-300"
                            :class="mobileMenuOpen ? '-rotate-180' : ''">
                            <!-- Ligne du haut -->
                            <span class="block h-0.5 w-full bg-gray-700 rounded-full transition-all duration-300 ease-out origin-center"
                                :class="mobileMenuOpen ? 'rotate-45 translate-y-2 bg-primary-600' : 'group-hover:bg-primary-600'"></span>
                            
                            <!-- Ligne du milieu -->
                            <span class="block h-0.5 w-full bg-gray-700 rounded-full transition-all duration-200 ease-out"
                                :class="mobileMenuOpen ? 'opacity-0' : 'opacity-100 group-hover:bg-primary-600'"></span>
                            
                            <!-- Ligne du bas -->
                            <span class="block h-0.5 w-full bg-gray-700 rounded-full transition-all duration-300 ease-out origin-center"
                                :class="mobileMenuOpen ? '-rotate-45 -translate-y-2 bg-primary-600' : 'group-hover:bg-primary-600'"></span>
                        </div>
                    </button>

                    <!-- Logo (CENTRE sur mobile, GAUCHE sur desktop) -->
                    <div class="flex items-center flex-1 md:flex-initial justify-center md:justify-start">
                        <a href="{{ route('home') }}" class="flex items-center">
                            <!-- Logo texte (adaptatif) -->
                            <span class="text-lg sm:text-xl md:text-3xl font-bold text-primary-600">Mbacol</span>
                            <span class="text-lg sm:text-xl md:text-3xl font-bold text-secondary-600 ml-1">Communication</span>
                        </a>
                    </div>
                    
                    <!-- Menu Desktop -->
                    <div class="hidden md:flex md:items-center md:space-x-8">
                        <a href="{{ route('home') }}" 
                        class="text-gray-700 hover:text-primary-600 px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('home') ? 'text-primary-600 border-b-2 border-primary-600' : '' }}">
                            Accueil
                        </a>
                        <a href="{{ route('shop') }}" 
                        class="text-gray-700 hover:text-primary-600 px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('shop') ? 'text-primary-600 border-b-2 border-primary-600' : '' }}">
                            Boutique
                        </a>
                        <a href="{{ route('about') }}" 
                        class="text-gray-700 hover:text-primary-600 px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('about') ? 'text-primary-600 border-b-2 border-primary-600' : '' }}">
                            À propos
                        </a>
                        <a href="{{ route('contact') }}" 
                        class="text-gray-700 hover:text-primary-600 px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('contact') ? 'text-primary-600 border-b-2 border-primary-600' : '' }}">
                            Contact
                        </a>
                    </div>
                    
                    <!-- Actions droite (Mobile + Desktop) -->
                    <div class="flex items-center space-x-1 sm:space-x-2 md:space-x-4">
                        
                        <!-- Recherche (Desktop uniquement) -->
                        <div class="hidden lg:block">
                            <form action="{{ route('shop') }}" method="GET" class="relative">
                                <input type="search" 
                                    name="search"
                                    placeholder="Rechercher..." 
                                    value="{{ request('search') }}"
                                    class="w-64 pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-sm transition">
                                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </form>
                        </div>

                        <!-- Recherche Mobile (icône) -->
                        <button @click="searchOpen = !searchOpen" 
                                class="lg:hidden text-gray-700 hover:text-primary-600 p-1.5">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                        
                        <!-- Panier -->
                        @livewire('cart-icon')
                        
                        <!-- Menu utilisateur Desktop -->
                        @auth
                            <div x-data="{ open: false }" class="relative hidden md:block">
                                <button @click="open = !open" 
                                        @click.away="open = false"
                                        class="flex items-center space-x-2 text-gray-700 hover:text-primary-600 transition-colors group">
                                    <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-secondary-500 rounded-full flex items-center justify-center text-white font-bold shadow-md group-hover:shadow-lg transition">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>

                                <!-- Dropdown Desktop -->
                                <div x-show="open"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 transform scale-95"
                                    x-transition:enter-end="opacity-100 transform scale-100"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 transform scale-100"
                                    x-transition:leave-end="opacity-0 transform scale-95"
                                    class="absolute right-0 mt-3 w-72 bg-white rounded-xl shadow-2xl border border-gray-100 py-2 z-50"
                                    style="display: none;">
                                    
                                    <div class="px-5 py-4 border-b border-gray-100">
                                        <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                                    </div>

                                    <div class="py-2">
                                        @if(Auth::user()->role === 'admin')
                                            <div class="px-3 py-1">
                                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Administration</p>
                                            </div>
                                            <a href="{{ route('admin.dashboard') }}" 
                                            class="flex items-center px-5 py-3 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors group">
                                                <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                                </svg>
                                                Dashboard Admin
                                            </a>
                                            <div class="border-t border-gray-100 my-2"></div>
                                        @endif

                                        @if(Auth::user()->role !== 'admin')
                                            <a href="{{ route('customer.orders.index') }}" 
                                            class="flex items-center px-5 py-3 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors group">
                                                <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                                </svg>
                                                Mes commandes
                                            </a>
                                        @endif

                                        <a href="{{ route('profile.edit') }}" 
                                        class="flex items-center px-5 py-3 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors group">
                                            <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            Mon profil
                                        </a>

                                        <div class="border-t border-gray-100 my-2"></div>

                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" 
                                                    class="flex items-center w-full px-5 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors group">
                                                <svg class="w-5 h-5 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                                </svg>
                                                Déconnexion
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Icône utilisateur Mobile -->
                            <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('customer.orders.index') }}" 
                            class="md:hidden p-1.5">
                                <div class="w-8 h-8 bg-gradient-to-br from-primary-500 to-secondary-500 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-md">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            </a>
                        @else
                            <!-- Icône Login Desktop -->
                            <a href="{{ route('login') }}" 
                            class="hidden md:block text-gray-700 hover:text-primary-600 p-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </a>

                            <!-- Icône Login Mobile -->
                            <a href="{{ route('login') }}" 
                            class="md:hidden p-1.5">
                                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Barre de recherche mobile -->
            <div x-show="searchOpen" 
                x-transition
                class="lg:hidden border-t border-gray-200 bg-white p-4"
                style="display: none;">
                <form action="{{ route('shop') }}" method="GET">
                    <div class="relative">
                        <input type="search" 
                            name="search"
                            placeholder="Rechercher un produit..." 
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </form>
            </div>

            <!-- Menu mobile (Burger) avec Animations Avancées -->
            <div x-show="mobileMenuOpen" 
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-x-full scale-95"
                x-transition:enter-end="opacity-100 translate-x-0 scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-x-0 scale-100"
                x-transition:leave-end="opacity-0 -translate-x-full scale-95"
                @click.away="mobileMenuOpen = false"
                class="md:hidden fixed inset-y-0 left-0 w-80 bg-white shadow-2xl z-50 overflow-y-auto"
                style="display: none;">
                
                <!-- Header Menu avec Animation -->
                <div class="flex items-center justify-between p-4 border-b border-gray-200 bg-gradient-to-r from-primary-50 to-secondary-50"
                    x-show="mobileMenuOpen"
                    x-transition:enter="transition ease-out duration-400 delay-100"
                    x-transition:enter-start="opacity-0 -translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="flex items-center space-x-3">
                        @auth
                            <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-secondary-500 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-lg transform hover:scale-110 transition-transform">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 text-sm">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                            </div>
                        @else
                            <div class="flex items-center">
                                <span class="text-lg font-bold text-primary-600">Mbacol</span>
                                <span class="text-lg font-bold text-secondary-600 ml-1">Com</span>
                            </div>
                        @endauth
                    </div>
                    <button @click="mobileMenuOpen = false" 
                            class="text-gray-500 hover:text-gray-700 p-2 rounded-lg hover:bg-white/50 transition-all duration-200 hover:rotate-90">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Navigation Links avec Animations Échelonnées -->
                <div class="px-4 py-6 space-y-1">
                    <a href="{{ route('home') }}" 
                    class="flex items-center px-4 py-3.5 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-xl transition-all duration-200 hover:translate-x-1 {{ request()->routeIs('home') ? 'bg-primary-50 text-primary-600 font-semibold' : '' }}"
                    x-show="mobileMenuOpen"
                    x-transition:enter="transition ease-out duration-300 delay-150"
                    x-transition:enter-start="opacity-0 -translate-x-4"
                    x-transition:enter-end="opacity-100 translate-x-0">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span class="font-medium">Accueil</span>
                    </a>

                    <a href="{{ route('shop') }}" 
                    class="flex items-center px-4 py-3.5 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-xl transition-all duration-200 hover:translate-x-1 {{ request()->routeIs('shop') ? 'bg-primary-50 text-primary-600 font-semibold' : '' }}"
                    x-show="mobileMenuOpen"
                    x-transition:enter="transition ease-out duration-300 delay-200"
                    x-transition:enter-start="opacity-0 -translate-x-4"
                    x-transition:enter-end="opacity-100 translate-x-0">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <span class="font-medium">Boutique</span>
                    </a>

                    <a href="{{ route('about') }}" 
                    class="flex items-center px-4 py-3.5 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-xl transition-all duration-200 hover:translate-x-1 {{ request()->routeIs('about') ? 'bg-primary-50 text-primary-600 font-semibold' : '' }}"
                    x-show="mobileMenuOpen"
                    x-transition:enter="transition ease-out duration-300 delay-250"
                    x-transition:enter-start="opacity-0 -translate-x-4"
                    x-transition:enter-end="opacity-100 translate-x-0">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="font-medium">À propos</span>
                    </a>

                    <a href="{{ route('contact') }}" 
                    class="flex items-center px-4 py-3.5 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-xl transition-all duration-200 hover:translate-x-1 {{ request()->routeIs('contact') ? 'bg-primary-50 text-primary-600 font-semibold' : '' }}"
                    x-show="mobileMenuOpen"
                    x-transition:enter="transition ease-out duration-300 delay-300"
                    x-transition:enter-start="opacity-0 -translate-x-4"
                    x-transition:enter-end="opacity-100 translate-x-0">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span class="font-medium">Contact</span>
                    </a>

                    @auth
                        <div class="border-t border-gray-200 mt-4 pt-4"
                            x-show="mobileMenuOpen"
                            x-transition:enter="transition ease-out duration-300 delay-350"
                            x-transition:enter-start="opacity-0 -translate-x-4"
                            x-transition:enter-end="opacity-100 translate-x-0">
                            <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Mon Espace</p>
                            
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" 
                                class="flex items-center px-4 py-3.5 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-xl transition-all duration-200 hover:translate-x-1">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                    <span class="font-medium">Dashboard Admin</span>
                                </a>
                            @else
                                <a href="{{ route('customer.orders.index') }}" 
                                class="flex items-center px-4 py-3.5 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-xl transition-all duration-200 hover:translate-x-1">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    <span class="font-medium">Mes commandes</span>
                                </a>
                            @endif

                            <a href="{{ route('profile.edit') }}" 
                            class="flex items-center px-4 py-3.5 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-xl transition-all duration-200 hover:translate-x-1">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span class="font-medium">Mon profil</span>
                            </a>

                            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                                @csrf
                                <button type="submit" 
                                        class="flex items-center w-full px-4 py-3.5 text-red-600 hover:bg-red-50 rounded-xl transition-all duration-200 hover:translate-x-1">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    <span class="font-medium">Déconnexion</span>
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="border-t border-gray-200 mt-4 pt-4"
                            x-show="mobileMenuOpen"
                            x-transition:enter="transition ease-out duration-300 delay-350"
                            x-transition:enter-start="opacity-0 -translate-x-4"
                            x-transition:enter-end="opacity-100 translate-x-0">
                            <a href="{{ route('login') }}" 
                            class="flex items-center px-4 py-3.5 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-xl transition-all duration-200 hover:translate-x-1">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                </svg>
                                <span class="font-medium">Connexion</span>
                            </a>
                            <a href="{{ route('register') }}" 
                            class="flex items-center px-4 py-3.5 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-xl transition-all duration-200 hover:translate-x-1">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                                <span class="font-medium">Inscription</span>
                            </a>
                        </div>
                    @endauth
                </div>
            </div>

            <!-- Overlay Amélioré -->
            <div x-show="mobileMenuOpen" 
                @click="mobileMenuOpen = false"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="md:hidden fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm z-40"
                style="display: none;">
            </div>
        </nav>

        <!-- Spacer -->
        <div class="h-16 md:h-20"></div>

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
                            <li>📞 +221  78 446 51 92</li>
                            <li>📧 contact@mbacol.sn</li>
                            <li>📍 Rue Amadou Lausane Ndoye x Mousse Diop Dakar - Sénégal</li>
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

        <!-- Bouton WhatsApp flottant -->
    <a href="https://wa.me/221778610188?text=Bonjour%20Mbacol%20Communication" 
    target="_blank"
    class="fixed bottom-6 left-6 bg-green-500 hover:bg-green-600 text-white rounded-full w-16 h-16 flex items-center justify-center shadow-2xl hover:shadow-green-500/50 hover:scale-110 transition-all duration-300 z-50 group animate-pulse">
        <svg class="w-9 h-9" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
        </svg>        
    </a>

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

    @livewireScripts
</body>
</html>