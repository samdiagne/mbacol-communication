<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Dashboard') - Admin Mbacol</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100" x-data="{ sidebarOpen: true, mobileSidebarOpen: false }">
    <div class="min-h-screen flex">
        
        <!-- Sidebar Desktop FIXE -->
        <aside class="hidden md:flex md:flex-shrink-0 md:fixed md:inset-y-0 md:left-0 transition-all duration-300 z-30" 
            :class="sidebarOpen ? 'md:w-64' : 'md:w-22'">
            <div class="flex flex-col w-full bg-gradient-to-b from-primary-700 to-primary-900 text-white">
                
                <!-- Header Sidebar -->
                <div class="flex items-center justify-between h-20 px-4 border-b border-primary-600 flex-shrink-0">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center" x-show="sidebarOpen">
                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center mr-3 shadow-lg">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="font-bold text-lg">Mbacol</span>
                            <p class="text-xs text-primary-200">Admin Panel</p>
                        </div>
                    </a>
                    
                    <!-- Logo compact -->
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center justify-center w-full" x-show="!sidebarOpen">
                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                    </a>
                    
                    <!-- Toggle button -->
                    <button @click="sidebarOpen = !sidebarOpen" 
                            class="p-2 rounded-lg hover:bg-primary-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-3 py-6 space-y-2 overflow-y-auto">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" 
                    class="flex items-center px-3 py-3 rounded-lg transition-colors group {{ request()->routeIs('admin.dashboard') ? 'bg-primary-600 text-white shadow-lg' : 'text-primary-100 hover:bg-primary-600/50' }}">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span class="ml-3 font-medium whitespace-nowrap" x-show="sidebarOpen">Dashboard</span>
                    </a>

                    <!-- Produits -->
                    <a href="{{ route('admin.products.index') }}" 
                    class="flex items-center px-3 py-3 rounded-lg transition-colors group {{ request()->routeIs('admin.products.*') ? 'bg-primary-600 text-white shadow-lg' : 'text-primary-100 hover:bg-primary-600/50' }}">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <span class="ml-3 font-medium whitespace-nowrap" x-show="sidebarOpen">Produits</span>
                    </a>

                    <!-- Commandes -->
                    <a href="{{ route('admin.orders.index') }}" 
                    class="flex items-center px-3 py-3 rounded-lg transition-colors group {{ request()->routeIs('admin.orders.*') ? 'bg-primary-600 text-white shadow-lg' : 'text-primary-100 hover:bg-primary-600/50' }}">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <span class="ml-3 font-medium whitespace-nowrap" x-show="sidebarOpen">Commandes</span>
                        @php
                            $pendingCount = \App\Models\Order::where('status', 'pending')->count();
                        @endphp
                        @if($pendingCount > 0)
                            <span class="ml-auto bg-red-500 text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center flex-shrink-0" x-show="sidebarOpen">
                                {{ $pendingCount }}
                            </span>
                        @endif
                    </a>

                    <!-- Avis (NOUVEAU) -->
                <a href="{{ route('admin.reviews.index') }}" 
                class="flex items-center px-3 py-3 rounded-lg transition-colors group {{ request()->routeIs('admin.reviews.*') ? 'bg-primary-600 text-white shadow-lg' : 'text-primary-100 hover:bg-primary-600/50' }}">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                    </svg>
                    <span class="ml-3 font-medium whitespace-nowrap" x-show="sidebarOpen">Avis clients</span>
                    @php
                        $pendingReviews = \App\Models\Review::pending()->count();
                    @endphp
                    @if($pendingReviews > 0)
                        <span class="ml-auto bg-yellow-500 text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center flex-shrink-0" x-show="sidebarOpen">
                            {{ $pendingReviews }}
                        </span>
                    @endif
                </a>
                </nav>

                <!-- User Section (bottom) - TOUJOURS VISIBLE -->
                <div class="border-t border-primary-600 p-4 flex-shrink-0">
                    <div x-data="{ userMenuOpen: false }" class="relative">
                        <button @click="userMenuOpen = !userMenuOpen"
                                class="flex items-center w-full px-3 py-2 rounded-lg hover:bg-primary-600/50 transition-colors">
                            <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center font-bold text-white flex-shrink-0 shadow-lg">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="ml-3 text-left flex-1 min-w-0" x-show="sidebarOpen">
                                <p class="text-sm font-semibold truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-primary-200">Administrateur</p>
                            </div>
                            <svg class="ml-2 w-4 h-4 flex-shrink-0 transition-transform" 
                                :class="{ 'rotate-180': userMenuOpen }"
                                x-show="sidebarOpen" 
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <!-- Dropdown Menu - TOUJOURS AU-DESSUS -->
                        <div x-show="userMenuOpen"
                            @click.away="userMenuOpen = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95"
                            class="absolute bottom-full left-0 right-0 mb-2 bg-white rounded-lg shadow-2xl py-2 border border-gray-200 z-50"
                            style="display: none;">
                            <a href="{{ route('home') }}" 
                            target="_blank"
                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                                <span class="whitespace-nowrap">Voir le site</span>
                            </a>
                            <a href="{{ route('profile.edit') }}" 
                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span class="whitespace-nowrap">Mon profil</span>
                            </a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    <svg class="w-4 h-4 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    <span class="whitespace-nowrap">Déconnexion</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Sidebar Mobile (Overlay) -->
        <div x-show="mobileSidebarOpen"
             @click="mobileSidebarOpen = false"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-40 bg-gray-900 bg-opacity-75 md:hidden"
             style="display: none;">
        </div>

        <aside x-show="mobileSidebarOpen"
               x-transition:enter="transition ease-in-out duration-300 transform"
               x-transition:enter-start="-translate-x-full"
               x-transition:enter-end="translate-x-0"
               x-transition:leave="transition ease-in-out duration-300 transform"
               x-transition:leave-start="translate-x-0"
               x-transition:leave-end="-translate-x-full"
               class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-primary-700 to-primary-900 text-white md:hidden overflow-y-auto"
               style="display: none;">
            
            <!-- Header Mobile -->
            <div class="flex items-center justify-between h-16 px-4 border-b border-primary-600">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center mr-3 shadow-lg">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="font-bold text-lg">Mbacol</span>
                        <p class="text-xs text-primary-200">Admin Panel</p>
                    </div>
                </a>
                <button @click="mobileSidebarOpen = false" class="p-2 rounded-lg hover:bg-primary-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Navigation Mobile -->
            <nav class="px-3 py-6 space-y-2">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center px-3 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-primary-600' : 'hover:bg-primary-600/50' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="ml-3 font-medium">Dashboard</span>
                </a>

                <a href="{{ route('admin.products.index') }}" 
                   class="flex items-center px-3 py-3 rounded-lg {{ request()->routeIs('admin.products.*') ? 'bg-primary-600' : 'hover:bg-primary-600/50' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <span class="ml-3 font-medium">Produits</span>
                </a>

                <a href="{{ route('admin.orders.index') }}" 
                   class="flex items-center px-3 py-3 rounded-lg {{ request()->routeIs('admin.orders.*') ? 'bg-primary-600' : 'hover:bg-primary-600/50' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <span class="ml-3 font-medium">Commandes</span>
                </a>
                <!-- AVIS (AJOUT) -->
                <a href="{{ route('admin.reviews.index') }}" 
                class="flex items-center px-3 py-3 rounded-lg {{ request()->routeIs('admin.reviews.*') ? 'bg-primary-600' : 'hover:bg-primary-600/50' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                    </svg>
                    <span class="ml-3 font-medium">Avis clients</span>
                </a>
            </nav>

            <!-- User Section -->
            <div class="border-t border-primary-600 p-4 mt-auto">
                <div class="flex items-center mb-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center font-bold text-white shadow-lg">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-semibold">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-primary-200">Administrateur</p>
                    </div>
                </div>

                <!-- Lien Voir le Site (NOUVEAU) -->
                <a href="{{ route('home') }}" 
                target="_blank"
                class="flex items-center px-3 py-2 rounded-lg hover:bg-primary-600/50 text-sm mb-2 transition-colors group">
                    <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    Voir le site
                </a>

                <a href="{{ route('profile.edit') }}" 
                class="flex items-center px-3 py-2 rounded-lg hover:bg-primary-600/50 text-sm mb-2 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Mon profil
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            class="flex items-center w-full text-left px-3 py-2 rounded-lg hover:bg-red-600/50 text-sm text-red-200 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Déconnexion
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content avec margin pour sidebar -->
        <div class="flex-1 flex flex-col overflow-hidden transition-all duration-300"
            :class="sidebarOpen ? 'md:ml-64' : 'md:ml-20'">
            <!-- Top Bar Mobile -->
            <header class="md:hidden bg-white shadow-sm border-b border-gray-200 h-16 flex items-center justify-between px-4 sticky top-0 z-20">
                <button @click="mobileSidebarOpen = true" class="p-2 rounded-lg hover:bg-gray-100">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <span class="font-bold text-gray-900">@yield('title', 'Dashboard')</span>
                <div class="w-10"></div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    <!-- Messages flash -->
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
            </main>
        </div>
    </div>
    @livewireScripts
</body>
</html>