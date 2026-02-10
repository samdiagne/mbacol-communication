<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Mbacol Communication') }} - @yield('title', 'Mon compte')</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50" x-data="{ mobileMenuOpen: false, userMenuOpen: false }">
    <!-- Navigation fixe -->
    <nav class="bg-white shadow-md border-b border-gray-200 fixed top-0 left-0 right-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <!-- Logo -->
                    <a href="{{ route('home') }}" class="flex items-center">
                        <span class="text-3xl font-bold text-primary-600">Mbacol</span>
                        <span class="text-3xl font-bold text-secondary-600 ml-1">Communication</span>
                    </a>
                    
                    <!-- Menu principal (Desktop) -->
                    <div class="hidden md:flex md:ml-10 md:space-x-6">
                        <a href="{{ route('home') }}" 
                           class="text-gray-700 hover:text-primary-600 px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('home') ? 'text-primary-600 border-b-2 border-primary-600' : '' }}">
                            Accueil
                        </a>
                        <a href="{{ route('shop') }}" 
                           class="text-gray-700 hover:text-primary-600 px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('shop') ? 'text-primary-600 border-b-2 border-primary-600' : '' }}">
                            Boutique
                        </a>
                        <a href="{{ route('customer.orders.index') }}" 
                           class="text-gray-700 hover:text-primary-600 px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('customer.orders.*') ? 'text-primary-600 border-b-2 border-primary-600' : '' }}">
                            Mes commandes
                        </a>
                    </div>
                </div>
                
                <!-- Actions droite -->
                <div class="flex items-center space-x-4">
                    <!-- Panier -->
                    @livewire('cart-icon')
                    
                    <!-- Menu utilisateur -->
                    <div class="relative">
                        <button @click="userMenuOpen = !userMenuOpen"
                                @click.away="userMenuOpen = false" 
                                class="flex items-center space-x-2 text-gray-700 hover:text-primary-600 transition-colors group">
                            <!-- Avatar -->
                            <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-secondary-500 rounded-full flex items-center justify-center text-white font-bold shadow-md group-hover:shadow-lg transition">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <!-- Flèche -->
                            <svg class="w-4 h-4 transition-transform duration-200" 
                                 :class="{ 'rotate-180': userMenuOpen }" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <!-- Menu déroulant -->
                        <div x-show="userMenuOpen"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 transform scale-100"
                             x-transition:leave-end="opacity-0 transform scale-95"
                             class="absolute right-0 mt-3 w-72 bg-white rounded-xl shadow-2xl border border-gray-100 py-2 z-50"
                             style="display: none;">
                            
                            <!-- En-tête -->
                            <div class="px-5 py-4 border-b border-gray-100">
                                <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                            </div>

                            <!-- Items du menu -->
                            <div class="py-2">
                                <a href="{{ route('customer.orders.index') }}" 
                                   class="flex items-center px-5 py-3 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors group">
                                    <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                    Mes commandes
                                </a>

                                <a href="{{ route('profile.edit') }}" 
                                   class="flex items-center px-5 py-3 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors group">
                                    <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Mon profil
                                </a>

                                <div class="border-t border-gray-100 my-2"></div>

                                <a href="{{ route('shop') }}" 
                                   class="flex items-center px-5 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors group">
                                    <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    Continuer mes achats
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

                    <!-- Menu mobile toggle -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" 
                            class="md:hidden text-gray-700 hover:text-primary-600 p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Menu mobile -->
        <div x-show="mobileMenuOpen" 
             x-transition
             @click.away="mobileMenuOpen = false"
             class="md:hidden border-t border-gray-200 bg-white shadow-lg"
             style="display: none;">
            <div class="px-4 py-4 space-y-2">
                <a href="{{ route('home') }}" class="block px-4 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-lg transition">Accueil</a>
                <a href="{{ route('shop') }}" class="block px-4 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-lg transition">Boutique</a>
                <a href="{{ route('customer.orders.index') }}" class="block px-4 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-lg transition">Mes commandes</a>
            </div>
        </div>
    </nav>

    <!-- Espace pour nav fixe -->
    <div class="h-20"></div>

    <!-- Contenu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            
            <!-- Sidebar (Desktop uniquement) -->
            <div class="hidden md:block md:col-span-1">
                <div class="bg-white rounded-xl shadow-lg p-6 sticky top-24">
                    <div class="mb-6 text-center">
                        <div class="w-20 h-20 bg-gradient-to-br from-primary-500 to-secondary-500 rounded-full flex items-center justify-center mb-4 mx-auto shadow-lg">
                            <span class="text-3xl font-bold text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                        <h2 class="font-bold text-lg text-gray-900">{{ Auth::user()->name }}</h2>
                        <p class="text-sm text-gray-600 truncate">{{ Auth::user()->email }}</p>
                    </div>
                    
                    <nav class="space-y-2">
                        <a href="{{ route('customer.orders.index') }}" 
                           class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('customer.orders.*') ? 'bg-primary-50 text-primary-700 font-semibold shadow-sm' : 'text-gray-700 hover:bg-gray-50' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            Mes commandes
                        </a>
                        <a href="{{ route('profile.edit') }}" 
                           class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('profile.*') ? 'bg-primary-50 text-primary-700 font-semibold shadow-sm' : 'text-gray-700 hover:bg-gray-50' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Mon profil
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Contenu principal -->
            <div class="md:col-span-3">
                @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-green-700 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
                @endif

                @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-red-700 font-medium">{{ session('error') }}</p>
                    </div>
                </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bouton WhatsApp flottant -->
    <a href="https://wa.me/221778610188?text=Bonjour%20Mbacol%20Communication" 
       target="_blank"
       class="fixed bottom-6 right-6 bg-green-500 hover:bg-green-600 text-white rounded-full w-16 h-16 flex items-center justify-center shadow-2xl hover:shadow-green-500/50 hover:scale-110 transition-all duration-300 z-50 group animate-pulse">
        <svg class="w-9 h-9" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
        </svg>
        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center animate-bounce">!</span>
    </a>

    @livewireScripts
</body>
</html>