<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation - Mbacol Communication</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50" x-data="{}">
    
    <!-- Navigation -->
    <nav class="bg-white shadow-md border-b border-gray-200 fixed top-0 left-0 right-0 z-50" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                
                <!-- Menu Burger (Mobile uniquement - GAUCHE) -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        class="md:hidden text-gray-700 hover:text-primary-600 p-2 -ml-2">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
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

        <!-- Menu mobile (Burger) -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-x-full"
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-x-0"
             x-transition:leave-end="opacity-0 -translate-x-full"
             @click.away="mobileMenuOpen = false"
             class="md:hidden fixed inset-y-0 left-0 w-80 bg-white shadow-2xl z-50 overflow-y-auto"
             style="display: none;">
            
            <!-- Header Menu -->
            <div class="flex items-center justify-between p-4 border-b border-gray-200 bg-gradient-to-r from-primary-50 to-secondary-50">
                <div class="flex items-center">
                    <span class="text-lg font-bold text-primary-600">Mbacol</span>
                    <span class="text-lg font-bold text-secondary-600 ml-1">Com</span>
                </div>
                <button @click="mobileMenuOpen = false" 
                        class="text-gray-500 hover:text-gray-700 p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Navigation Links -->
            <div class="px-4 py-6 space-y-1">
                <a href="{{ route('home') }}" 
                   class="flex items-center px-4 py-3.5 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-xl transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="font-medium">Accueil</span>
                </a>

                <a href="{{ route('shop') }}" 
                   class="flex items-center px-4 py-3.5 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-xl transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    <span class="font-medium">Boutique</span>
                </a>

                <a href="{{ route('about') }}" 
                   class="flex items-center px-4 py-3.5 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-xl transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="font-medium">À propos</span>
                </a>

                <a href="{{ route('contact') }}" 
                   class="flex items-center px-4 py-3.5 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-xl transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span class="font-medium">Contact</span>
                </a>
            </div>
        </div>

        <!-- Overlay -->
        <div x-show="mobileMenuOpen" 
             @click="mobileMenuOpen = false"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="md:hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-40"
             style="display: none;">
        </div>
    </nav>

    <!-- Spacer -->
    <div class="h-16"></div>

    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-5xl">
            
            <!-- Breadcrumb -->
            <div class="mb-6 text-center">
                <nav class="flex justify-center" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-2 text-sm">
                        <li>
                            <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary-600">Accueil</a>
                        </li>
                        <li>
                            <span class="text-gray-400">/</span>
                        </li>
                        <li class="text-primary-600 font-semibold">Confirmation</li>
                    </ol>
                </nav>
            </div>

            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2">

                    <!-- FORMULAIRE -->
                    <div class="p-8 lg:p-12 flex flex-col justify-center">
                        <div class="mb-8">
                            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">
                                Confirmation requise
                            </h2>
                            <p class="text-gray-600">
                                Cette action est sécurisée. Veuillez confirmer votre mot de passe pour continuer.
                            </p>
                        </div>

                        <form method="POST" action="{{ route('password.confirm') }}">
                            @csrf

                            <!-- Mot de passe -->
                            <div class="mb-6">
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
                                           autocomplete="current-password"
                                           placeholder="••••••••"
                                           class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition @error('password') @enderror">
                                </div>
                                @error('password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit"
                                    class="w-full bg-gradient-to-r from-primary-600 to-secondary-600 text-white font-bold py-4 rounded-xl hover:shadow-lg transform hover:scale-[1.02] transition-all duration-200">
                                Confirmer
                            </button>
                        </form>
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                            </div>
                            
                            <h2 class="text-4xl font-bold text-white mb-4">
                                Sécurité 🔐
                            </h2>
                            <p class="text-white/90 text-lg max-w-md mx-auto">
                                Nous protégeons votre compte contre les accès non autorisés
                            </p>

                            <!-- Points de sécurité -->
                            <div class="space-y-4 mt-8">
                                <div class="flex items-center justify-center text-white/90">
                                    <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Connexion sécurisée</span>
                                </div>
                                <div class="flex items-center justify-center text-white/90">
                                    <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Données chiffrées</span>
                                </div>
                                <div class="flex items-center justify-center text-white/90">
                                    <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Protection maximale</span>
                                </div>
                            </div>
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