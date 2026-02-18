<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Mbacol Communication</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50" x-data="{}">
    
    <!-- Navigation -->
    <nav class="bg-white shadow-md border-b border-gray-200 fixed top-0 left-0 right-0 z-50" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                
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
                        <span class="text-lg sm:text-2xl font-bold text-primary-600">Mbacol</span>
                        <span class="text-lg sm:text-2xl font-bold text-secondary-600 ml-1">Communication</span>
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

                <!-- Actions droite (Panier) -->
                <div class="flex items-center">
                    @livewire('cart-icon')
                </div>
            </div>
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

    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-5xl">
            
            <!-- Breadcrumb -->
            <div class="mb-6 text-center mt-6">
                <nav class="flex justify-center" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-2 text-sm">
                        <li>
                            <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary-600">Accueil</a>
                        </li>
                        <li>
                            <span class="text-gray-400">/</span>
                        </li>
                        <li class="text-primary-600 font-semibold">Connexion</li> <!-- ou Inscription -->
                    </ol>
                </nav>
            </div>

            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2">

                    <!-- FORMULAIRE -->
                    <div class="p-8 lg:p-12 flex flex-col justify-center">
                        <div class="mb-8">
                            <h2 class="text-4xl font-bold text-gray-900 mb-2">Bon retour !</h2>
                            <p class="text-gray-600">Connectez-vous pour accéder à votre compte</p>
                        </div>

                        <!-- Message flash -->
                        @if (session('status'))
                        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg">
                            <p class="text-green-700 text-sm">{{ session('status') }}</p>
                        </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email -->
                            <div class="mb-5">
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Adresse email
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                        </svg>
                                    </div>
                                    <input id="email" 
                                           type="email" 
                                           name="email" 
                                           value="{{ old('email') }}"
                                           required 
                                           autofocus
                                           placeholder="votre@email.com"
                                           class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition @error('email') @enderror">
                                </div>
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Mot de passe -->
                            <div class="mb-5">
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Mot de passe
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                    </div>
                                    <input id="password" 
                                           type="password" 
                                           name="password" 
                                           required
                                           placeholder="••••••••"
                                           class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition @error('password') @enderror">
                                </div>
                                @error('password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Remember me + Mot de passe oublié -->
                            <div class="flex items-center justify-between mb-6">
                                <label class="flex items-center">
                                    <input type="checkbox" 
                                           name="remember" 
                                           class="w-4 h-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                    <span class="ml-2 text-sm text-gray-600">Se souvenir de moi</span>
                                </label>

                                @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" 
                                   class="text-sm text-primary-600 hover:text-primary-700 font-semibold">
                                    Mot de passe oublié ?
                                </a>
                                @endif
                            </div>

                            <!-- Bouton -->
                            <button type="submit"
                                    class="w-full bg-gradient-to-r from-primary-600 to-secondary-600 text-white font-bold py-4 rounded-xl hover:shadow-lg transform hover:scale-[1.02] transition-all duration-200">
                                Se connecter
                            </button>
                        </form>

                        <!-- Lien inscription -->
                        <div class="mt-6 text-center">
                            <p class="text-sm text-gray-600">
                                Vous n'avez pas de compte ? 
                                <a href="{{ route('register') }}" class="text-primary-600 hover:text-primary-700 font-semibold">
                                    Créer un compte
                                </a>
                            </p>
                        </div>
                    </div>

                    <!-- PARTIE DROITE - VISUEL -->
                    <div class="hidden lg:flex items-center justify-center bg-gradient-to-br from-primary-600 via-primary-700 to-secondary-600 p-12 relative overflow-hidden">
                        <!-- Formes décoratives -->
                        <div class="absolute inset-0 opacity-10">
                            <div class="absolute top-0 left-0 w-64 h-64 bg-white rounded-full blur-3xl"></div>
                            <div class="absolute bottom-0 right-0 w-64 h-64 bg-white rounded-full blur-3xl"></div>
                        </div>

                        <div class="text-center relative z-10">
                            <div class="mb-8">
                                <div class="w-24 h-24 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-2xl">
                                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                </div>
                            </div>
                            
                            <h2 class="text-4xl font-bold text-white mb-4">
                                Nouveau chez nous ?
                            </h2>
                            <p class="text-white/90 text-lg mb-8 max-w-md mx-auto">
                                Créez votre compte et profitez de nos offres exclusives !
                            </p>

                            <!-- Avantages -->
                            <div class="space-y-4 mb-8">
                                <div class="flex items-center justify-center text-white/90">
                                    <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Suivi de vos commandes</span>
                                </div>
                                <div class="flex items-center justify-center text-white/90">
                                    <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Offres exclusives</span>
                                </div>
                                <div class="flex items-center justify-center text-white/90">
                                    <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Livraison rapide</span>
                                </div>
                            </div>

                            <a href="{{ route('register') }}"
                               class="inline-block bg-white text-primary-600 font-bold px-8 py-4 rounded-xl hover:bg-gray-100 transition-all duration-200 shadow-xl">
                                Créer un compte
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center text-sm text-gray-500">
                <p>© {{ date('Y') }} Mbacol Communication - Tous droits réservés</p>
            </div>
        </div>
    </div>
</body>
</html>