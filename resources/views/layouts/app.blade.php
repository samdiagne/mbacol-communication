<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- ✅ FORCER HTTPS pour assets -->
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    {{-- Google Search Console Verification --}}
    <meta name="google-site-verification" content="yI3tio1cg57EOnGk3strR0JMxXVobLQdoR7dmOR6HeU" />
    
    {!! SEO::generate() !!}
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="dns-prefetch" href="https://fonts.bunny.net">
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    
    @stack('scripts')

    <style>
        html {
            scroll-behavior: smooth;
            scroll-padding-top: 80px;
        }
    </style>
</head>
<body class="font-sans antialiased" x-data="{ mobileMenuOpen: false, searchOpen: false }"> 
    <!-- Page Loader -->
    <x-page-loader />
    
    <div class="min-h-screen bg-gray-50">
        <!-- Navbar Component -->
        <x-navbar />

        <!-- ✅ AJOUTER : Flash Messages pour Livewire -->
        @if (session()->has('success'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 4000)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed top-20 right-4 z-50 bg-green-500 text-white px-6 py-4 rounded-lg shadow-2xl max-w-md">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
        </div>
        @endif

        @if (session()->has('error'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 4000)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed top-20 right-4 z-50 bg-red-500 text-white px-6 py-4 rounded-lg shadow-2xl max-w-md">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="font-semibold">{{ session('error') }}</span>
            </div>
        </div>
        @endif

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

     <!-- Instant.page - Navigation ultra-rapide -->
    <script src="https://cdn.jsdelivr.net/npm/instant.page@5.2.0/instantpage.min.js" 
            type="module" 
            defer></script>

    <!-- ✅ Livewire Scripts (déjà présent - parfait !) -->
    @livewireScripts

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll("img").forEach(img => {
            if (!img.hasAttribute("loading")) {
                img.loading = "lazy";
            }

            if (!img.hasAttribute("decoding")) {
                img.decoding = "async";
            }
        });
    });
    </script>
</body>
</html>