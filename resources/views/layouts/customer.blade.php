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
<body class="font-sans antialiased bg-gray-50">
    <!-- Navigation principale -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <span class="text-2xl font-bold text-primary-600">Mbacol</span>
                        <span class="text-2xl font-bold text-secondary-600 ml-1">Communication</span>
                    </a>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('shop') }}" class="text-gray-700 hover:text-primary-600">Boutique</a>
                    <a href="{{ route('customer.orders.index') }}" class="text-gray-700 hover:text-primary-600">Mes commandes</a>
                    
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-primary-600">Déconnexion</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            
            <!-- Sidebar -->
            <div class="md:col-span-1">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="mb-6">
                        <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mb-3">
                            <span class="text-2xl font-bold text-primary-600">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                        <h2 class="font-bold text-lg">{{ Auth::user()->name }}</h2>
                        <p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>
                    </div>
                    
                    <nav class="space-y-2">
                        <a href="{{ route('customer.orders.index') }}" 
                           class="block px-4 py-2 rounded-lg {{ request()->routeIs('customer.orders.*') ? 'bg-primary-100 text-primary-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
                            📦 Mes commandes
                        </a>
                        <a href="{{ route('profile.edit') }}" 
                           class="block px-4 py-2 rounded-lg {{ request()->routeIs('profile.*') ? 'bg-primary-100 text-primary-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
                            👤 Mon profil
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Contenu principal -->
            <div class="md:col-span-3">
                @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
                    <p class="text-green-700">{{ session('success') }}</p>
                </div>
                @endif

                @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                    <p class="text-red-700">{{ session('error') }}</p>
                </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>