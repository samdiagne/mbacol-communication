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
                    <span class="block h-0.5 w-full bg-gray-700 rounded-full transition-all duration-300 ease-out origin-center"
                        :class="mobileMenuOpen ? 'rotate-45 translate-y-2 bg-primary-600' : 'group-hover:bg-primary-600'"></span>
                    <span class="block h-0.5 w-full bg-gray-700 rounded-full transition-all duration-200 ease-out"
                        :class="mobileMenuOpen ? 'opacity-0' : 'opacity-100 group-hover:bg-primary-600'"></span>
                    <span class="block h-0.5 w-full bg-gray-700 rounded-full transition-all duration-300 ease-out origin-center"
                        :class="mobileMenuOpen ? '-rotate-45 -translate-y-2 bg-primary-600' : 'group-hover:bg-primary-600'"></span>
                </div>
            </button>

            <!-- Logo -->
            <div class="flex items-center flex-1 md:flex-initial justify-center md:justify-start">
                <a href="{{ route('home') }}" class="flex items-center">
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
                    @auth
                    <!-- Recherche avec dropdown (Desktop) -->
                    <div x-data="{ searchOpen: false }" 
                    @click.outside="searchOpen = false" 
                    class="hidden lg:block relative">
                        <button @click="searchOpen = !searchOpen" 
                                class="text-gray-700 hover:text-primary-600 hover:bg-gray-100 p-2 rounded-lg transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>

                        <!-- Dropdown recherche -->
                        <div x-show="searchOpen"
                            x-transition
                            class="absolute right-0 mt-2 w-96 bg-white rounded-xl shadow-2xl border border-gray-100 p-4 z-50"
                            style="display: none;">
                            @livewire('search-autocomplete')
                        </div>
                    </div>
                @else
                    <!-- Recherche complète inline -->
                    <div class="hidden lg:block w-64">
                        @livewire('search-autocomplete')
                    </div>
                @endauth

                <!-- Recherche Mobile (icône pour tous) -->
                <button @click="searchOpen = !searchOpen" 
                        class="lg:hidden text-gray-700 hover:text-primary-600 p-1.5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>
                
                <!-- Panier -->
                @livewire('cart-icon')
                
                <!-- User Menu -->
                @auth
                    <div class="relative" x-data="{ open: false }">
                        
                        <button @click="open = !open"
                            class="hidden md:flex items-center space-x-3 
                                px-3 py-2 rounded-xl 
                                hover:bg-gray-50 transition-all duration-200">

                            <!-- Avatar -->
                            <div class="w-9 h-9 bg-gradient-to-br 
                                        from-primary-500 to-secondary-500 
                                        rounded-full flex items-center justify-center 
                                        text-white font-bold text-sm shadow-md">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>

                            <!-- Texte -->
                            <div class="text-left leading-tight">
                                <p class="text-xs text-gray-500">Bonjour 👋</p>
                                <p class="text-sm font-semibold text-gray-800">
                                    {{ Auth::user()->name }}
                                </p>
                            </div>

                            <!-- Arrow -->
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div x-show="open" 
                            @click.away="open = false"
                            x-transition
                            class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50"
                            style="display: none;">

                            <!-- Bloc identité -->
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-900">
                                    {{ Auth::user()->name }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ Auth::user()->email }}
                                </p>
                            </div>

                            <!-- Mon profil (pour tous) -->
                            <a href="{{ route('profile.edit') }}" 
                            class="flex items-center px-4 py-2 text-gray-700 hover:bg-primary-50 hover:text-primary-600">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M5.121 17.804A9 9 0 1118.364 4.56M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span>Mon profil</span>
                            </a>

                            @if(Auth::user()->role === 'admin')
                                <!-- Administration -->
                                <a href="{{ route('admin.dashboard') }}" 
                                class="flex items-center px-4 py-2 text-gray-700 hover:bg-primary-50 hover:text-primary-600">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2"/>
                                    </svg>
                                    <span>Tableau de bord</span>
                                </a>
                            @else
                                <!-- Mes commandes (clients uniquement) -->
                                <a href="{{ route('customer.orders.index') }}" 
                                class="flex items-center px-4 py-2 text-gray-700 hover:bg-primary-50 hover:text-primary-600">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                    <span>Mes commandes</span>
                                </a>
                            @endif

                            <div class="border-t border-gray-100 my-2"></div>

                            <!-- Déconnexion -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="w-full flex items-center px-4 py-2 text-red-600 hover:bg-red-50">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M17 16l4-4m0 0l-4-4m4 4H7"/>
                                    </svg>
                                    <span>Déconnexion</span>
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <a href="{{ route('home') }}" 
                    class="md:hidden flex items-center">
                        <div class="relative">
                            <div class="w-8 h-8 bg-gradient-to-br 
                                    from-primary-500 to-secondary-500 
                                      rounded-full flex items-center justify-center 
                                    text-white font-bold text-sm shadow-md">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>

                            <!-- Badge online -->
                            <span class="absolute -bottom-0.5 -right-0.5 
                                w-3 h-3 bg-green-500 border-2 border-white 
                                rounded-full">
                            </span>
                        </div>
                    </a>
                @else
                    <a href="{{ route('login') }}" 
                       class="hidden md:inline-flex items-center bg-primary-600 hover:bg-primary-700 text-white font-medium px-4 py-2 rounded-lg transition">
                        Connexion
                    </a>
                    <a href="{{ route('login') }}" class="md:hidden p-1.5">
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
        @livewire('search-autocomplete')
    </div>

    <!-- Menu mobile -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-x-full"
         x-transition:enter-end="opacity-100 translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-x-0"
         x-transition:leave-end="opacity-0 -translate-x-full"
         @click.away="mobileMenuOpen = false"
         class="md:hidden fixed inset-y-0 left-0 w-80 bg-white shadow-2xl z-50 overflow-y-auto"
         style="display: none;">
        
        <!-- Header Menu -->
        <div class="flex items-center justify-between p-4 border-b border-gray-200 bg-gradient-to-r from-primary-50 to-secondary-50">
            <div class="flex items-center space-x-3">
                @auth
                    <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-secondary-500 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-lg">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-bold text-gray-900 text-sm">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                    </div>
                @else
                    <div class="flex items-center">
                        <span class="text-lg font-bold text-primary-600">MBC</span>
                        <span class="text-lg font-bold text-secondary-600 ml-1">313</span>
                    </div>
                @endauth
            </div>
            <button @click="mobileMenuOpen = false" 
                    class="text-gray-500 hover:text-gray-700 p-2 rounded-lg hover:bg-white/50 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Navigation Links -->
        <div class="px-4 py-6 space-y-1">
            <a href="{{ route('home') }}" 
               class="flex items-center px-4 py-3.5 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-xl transition {{ request()->routeIs('home') ? 'bg-primary-50 text-primary-600 font-semibold' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span class="font-medium">Accueil</span>
            </a>

            <a href="{{ route('shop') }}" 
               class="flex items-center px-4 py-3.5 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-xl transition {{ request()->routeIs('shop') ? 'bg-primary-50 text-primary-600 font-semibold' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <span class="font-medium">Boutique</span>
            </a>

            <a href="{{ route('about') }}" 
               class="flex items-center px-4 py-3.5 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-xl transition {{ request()->routeIs('about') ? 'bg-primary-50 text-primary-600 font-semibold' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="font-medium">À propos</span>
            </a>

            <a href="{{ route('contact') }}" 
               class="flex items-center px-4 py-3.5 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-xl transition {{ request()->routeIs('contact') ? 'bg-primary-50 text-primary-600 font-semibold' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <span class="font-medium">Contact</span>
            </a>

            @auth
                <div class="border-t border-gray-200 mt-4 pt-4">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Mon Espace</p>
                    
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" 
                           class="flex items-center px-4 py-3.5 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-xl transition">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            <span class="font-medium">Administration</span>
                        </a>
                    @else
                        <a href="{{ route('customer.orders.index') }}" 
                           class="flex items-center px-4 py-3.5 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-xl transition">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            <span class="font-medium">Mes commandes</span>
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-4 py-3.5 text-red-600 hover:bg-red-50 rounded-xl transition mt-1">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span class="font-medium">Déconnexion</span>
                        </button>
                    </form>
                </div>
            @else
                <div class="border-t border-gray-200 mt-4 pt-4">
                    <a href="{{ route('login') }}" 
                       class="flex items-center px-4 py-3.5 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-xl transition">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        <span class="font-medium">Connexion</span>
                    </a>

                    <a href="{{ route('register') }}" 
                       class="flex items-center px-4 py-3.5 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-xl transition">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                        <span class="font-medium">Inscription</span>
                    </a>
                </div>
            @endauth
        </div>
    </div>

    <!-- Overlay -->
    <div x-show="mobileMenuOpen" 
         @click="mobileMenuOpen = false"
         x-transition
         class="md:hidden fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm z-40"
         style="display: none;">
    </div>
</nav>

<!-- Spacer -->
<div class="h-16 md:h-20"></div>
