<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    {!! SEO::generate() !!}
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    
    @stack('scripts')
</head>
<body class="font-sans antialiased" x-data="{ mobileMenuOpen: false, searchOpen: false }"> 
    <!-- Page Loader -->
    <div class="page-loader">
        <div class="flex flex-col items-center">
            <div class="w-16 h-16 border-4 border-primary-200 border-t-primary-600 rounded-full animate-spin"></div>
            <p class="mt-4 text-gray-600 font-semibold">Chargement...</p>
        </div>
    </div>
    
    <div class="min-h-screen bg-gray-50">
        <!-- Navbar Component -->
        <x-navbar />

        <!-- Contenu principal -->
        <main>
            @yield('content')
        </main>
        
        <!-- Footer Component -->
        <x-footer />
    </div>

    <!-- Floating Buttons Component -->
    <x-floating-buttons />

    <!-- Toast Notification Component -->
    <x-toast-notification />

    @livewireScripts
</body>
</html>
