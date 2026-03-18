<!-- Barre annonce livraison 
<div class="fixed top-0 left-0 w-full bg-gradient-to-r from-primary-600 to-secondary-600 text-white font-bold z-50">

    <div class="topbar-slider font-medium tracking-wide">

        <div class="topbar-messages">

            <div class="topbar-message">
                🚚 Livraison offerte dès 50 000 FCFA • 🔒 Paiement sécurisé
            </div>

            <div class="topbar-message">
                ✨ Des nouveautés arrivent ! Restez connectés 👀
            </div>

        </div>

    </div>

</div>-->


<!-- Barre réseaux sociaux 
<div class="fixed top-9 left-0 w-full bg-black text-white z-40">

    <div class="max-w-7xl mx-auto px-4 h-8 flex justify-center items-center gap-10 text-sm">

        <a href="#" class="flex items-center gap-2 hover:text-blue-400 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M22 12.07C22 6.49 17.52 2 12 2S2 6.49 2 12.07c0 5.02 3.66 9.18 8.44 9.93v-7.02H7.9v-2.91h2.54V9.79c0-2.5 1.48-3.89 3.75-3.89 1.09 0 2.23.2 2.23.2v2.45h-1.26c-1.24 0-1.63.77-1.63 1.56v1.87h2.78l-.44 2.91h-2.34V22c4.78-.75 8.44-4.91 8.44-9.93z"/>
            </svg>
            Facebook
        </a>

        <a href="#" class="flex items-center gap-2 hover:text-pink-400 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M7.75 2h8.5A5.75 5.75 0 0122 7.75v8.5A5.75 5.75 0 0116.25 22h-8.5A5.75 5.75 0 012 16.25v-8.5A5.75 5.75 0 017.75 2zm4.25 5.5A4.75 4.75 0 1016.75 12 4.75 4.75 0 0012 7.5zm6-1.25a1.25 1.25 0 11-1.25-1.25A1.25 1.25 0 0118 6.25z"/>
            </svg>
            Instagram
        </a>

        <a href="#" class="flex items-center gap-2 hover:text-gray-300 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M16 2a6 6 0 006 6v3a9 9 0 01-6-2v7a6 6 0 11-6-6 6.1 6.1 0 011 .08v3.1a3 3 0 102 2.82V2z"/>
            </svg>
            TikTok
        </a>

    </div>

</div>-->

<!-- Navigation fixe -->
<nav class="bg-white shadow-md border-b border-gray-200 fixed top-0 left-0 right-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 md:h-20">
            
            <!-- Menu Burger avec Rotation du Container -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" 
                    class="desktop-nav:hidden relative w-10 h-10 flex items-center justify-center rounded-xl hover:bg-gradient-to-br hover:from-primary-50 hover:to-secondary-50 transition-all duration-300 p-2 -ml-2 group"
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
            <div class="flex items-center flex-1 desktop-nav:flex-initial justify-center desktop-nav:justify-start">
                <a href="{{ route('home') }}" class="flex items-center">
                    <span class="text-lg sm:text-xl md:text-3xl font-bold text-primary-600">Mbacol</span>
                    <span class="text-lg sm:text-xl md:text-3xl font-bold text-secondary-600 ml-1">Communication</span>
                </a>
            </div>
            
            <!-- Menu Desktop -->
            <div class="hidden desktop-nav:flex desktop-nav:items-center desktop-nav:space-x-6">
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
                    class="hidden desktop-nav:block relative">
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
                    <div class="hidden desktop-nav:block w-64">
                        @livewire('search-autocomplete')
                    </div>
                @endauth

                <!-- Recherche Mobile (icône pour tous) -->
                <button @click="searchOpen = !searchOpen" 
                        class="desktop-nav:hidden text-gray-700 hover:text-primary-600 p-1.5">
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
                            class="hidden desktop-nav:flex items-center space-x-3 
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
                    
                    <a href="{{ route('customer.orders.index') }}" 
                    class="desktop-nav:hidden flex items-center">
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
                    <a href="{{ route('login') }}" class="p-1.5">
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
         class="desktop-nav:hidden border-t border-gray-200 bg-white p-4"
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
         class="desktop-nav:hidden fixed inset-y-0 left-0 w-80 bg-white shadow-2xl z-50 overflow-y-auto"
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
                        <img src="{{ asset('images/logo.webp') }}" 
                            alt="Mbacol Logo"
                            class="h-12 w-auto transform scale-150" loading="eager">
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
                        <a href="{{ route('profile.edit') }}" 
                        class="flex items-center px-4 py-3.5 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-xl transition-all duration-200 hover:translate-x-1">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="font-medium">Mon profil</span>
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
         class="desktop-nav:hidden fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm z-40"
         style="display: none;">
    </div>
</nav>

<!-- Spacer -->
<div class="h-16 md:h-20"></div>