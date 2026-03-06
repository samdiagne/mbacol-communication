<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>Réinitialisation du mot de passe - Mbacol Communication</title>
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
                       class="text-gray-700 hover:text-primary-600 px-3 py-2 text-sm font-medium transition-colors">
                        Accueil
                    </a>
                    <a href="{{ route('shop') }}" 
                       class="text-gray-700 hover:text-primary-600 px-3 py-2 text-sm font-medium transition-colors">
                        Boutique
                    </a>
                    <a href="{{ route('about') }}" 
                       class="text-gray-700 hover:text-primary-600 px-3 py-2 text-sm font-medium transition-colors">
                        À propos
                    </a>
                    <a href="{{ route('contact') }}" 
                       class="text-gray-700 hover:text-primary-600 px-3 py-2 text-sm font-medium transition-colors">
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

                <!-- Lien Connexion -->
                <div class="border-t border-gray-200 mt-4 pt-4">
                    <a href="{{ route('login') }}" 
                       class="flex items-center px-4 py-3.5 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-xl transition">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        <span class="font-medium">Connexion</span>
                    </a>
                </div>
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
                        <li class="text-primary-600 font-semibold">Nouveau mot de passe</li>
                    </ol>
                </nav>
            </div>

            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2">

                    <!-- FORMULAIRE -->
                    <div class="p-8 lg:p-12 flex flex-col justify-center">
                        <div class="mb-8">
                            <h2 class="text-4xl font-bold text-gray-900 mb-3">
                                Nouveau mot de passe
                            </h2>
                            <p class="text-gray-600">
                                Choisissez un mot de passe sécurisé pour votre compte
                            </p>
                        </div>

                        <form method="POST" action="{{ route('password.store') }}">
                            @csrf

                            <!-- Token caché -->
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">

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
                                           autocomplete="email"
                                           maxlength="255"
                                           inputmode="email"
                                           value="{{ old('email', $request->email) }}"
                                           required
                                           autofocus
                                           readonly
                                           class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl bg-gray-50 cursor-not-allowed focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                                </div>
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nouveau mot de passe -->
                            <div class="mb-5">
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nouveau mot de passe
                                </label>

                                <div class="relative">
                                    <!-- Icone gauche -->
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                    </div>

                                    <input id="password"
                                        type="password"
                                        name="password"
                                        minlength="8"
                                        required
                                        placeholder="Minimum 8 caractères"
                                        class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition @error('password') @enderror">

                                    <!-- Bouton afficher -->
                                    <button type="button"
                                            onclick="toggleNewPassword()"
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">

                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 
                                                8.268 2.943 9.542 7-1.274 4.057-5.064 
                                                7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>
                                </div>

                                @error('password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- indicateur de force du mot de passe -->
                            <div class="mt-2">
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div id="password-strength-bar" class="h-2 rounded-full transition-all"></div>
                                </div>
                                <p id="password-strength-text" class="text-sm mt-1 text-gray-500"></p>
                            </div>

                            <!-- Confirmation mot de passe -->
                            <div class="mb-6">
                                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Confirmer le mot de passe
                                </label>

                                <div class="relative">
                                    <!-- Icone gauche -->
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944
                                                a11.955 11.955 0 01-8.618 3.04A12.02
                                                12.02 0 003 9c0 5.591 3.824 10.29
                                                9 11.622 5.176-1.332
                                                9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                    </div>

                                    <input id="password_confirmation"
                                        type="password"
                                        name="password_confirmation"
                                        required
                                        placeholder="Retapez le mot de passe"
                                        class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition @error('password_confirmation') @enderror">

                                    <!-- Bouton afficher -->
                                    <button type="button"
                                            onclick="toggleConfirmPassword()"
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">

                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 
                                                8.268 2.943 9.542 7-1.274 4.057-5.064 
                                                7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>
                                </div>

                                @error('password_confirmation')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <script>
                            function toggleNewPassword() {
                                const input = document.getElementById("password");
                                input.type = input.type === "password" ? "text" : "password";
                            }

                            function toggleConfirmPassword() {
                                const input = document.getElementById("password_confirmation");
                                input.type = input.type === "password" ? "text" : "password";
                            }
                            </script>

                            <!-- Bouton -->
                            <button type="submit"
                                    class="w-full bg-gradient-to-r from-primary-600 to-secondary-600 text-white font-bold py-4 rounded-xl hover:shadow-lg transform hover:scale-[1.02] transition-all duration-200">
                                🔒 Réinitialiser le mot de passe
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </div>
                            </div>
                            
                            <h2 class="text-4xl font-bold text-white mb-4">
                                Presque fini ! 🔐
                            </h2>
                            <p class="text-white/90 text-lg mb-8 max-w-md mx-auto">
                                Un nouveau mot de passe sécurisé et vous êtes prêt à repartir
                            </p>

                            <!-- Conseils sécurité -->
                            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 text-left max-w-sm mx-auto">
                                <h3 class="font-bold text-white mb-3">💡 Conseils de sécurité :</h3>
                                <ul class="space-y-2 text-white/90 text-sm">
                                    <li class="flex items-start">
                                        <span class="mr-2">✓</span>
                                        <span>Minimum 8 caractères</span>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="mr-2">✓</span>
                                        <span>Majuscules et minuscules</span>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="mr-2">✓</span>
                                        <span>Chiffres et caractères spéciaux</span>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="mr-2">✓</span>
                                        <span>Éviter les mots communs</span>
                                    </li>
                                </ul>
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

<script>
    const passwordInput = document.getElementById("password");
    const strengthBar = document.getElementById("password-strength-bar");
    const strengthText = document.getElementById("password-strength-text");

    passwordInput.addEventListener("input", function () {

        const password = passwordInput.value;
        let score = 0;

        if (password.length >= 8) score++;
        if (/[A-Z]/.test(password)) score++;
        if (/[0-9]/.test(password)) score++;
        if (/[^A-Za-z0-9]/.test(password)) score++;

        switch(score) {

            case 0:
            case 1:
                strengthBar.style.width = "25%";
                strengthBar.className = "h-2 rounded-full bg-red-500";
                strengthText.textContent = "Mot de passe faible";
                strengthText.className = "text-sm mt-1 text-red-500";
                break;

            case 2:
                strengthBar.style.width = "50%";
                strengthBar.className = "h-2 rounded-full bg-yellow-500";
                strengthText.textContent = "Mot de passe moyen";
                strengthText.className = "text-sm mt-1 text-yellow-600";
                break;

            case 3:
                strengthBar.style.width = "75%";
                strengthBar.className = "h-2 rounded-full bg-blue-500";
                strengthText.textContent = "Bon mot de passe";
                strengthText.className = "text-sm mt-1 text-blue-600";
                break;

            case 4:
                strengthBar.style.width = "100%";
                strengthBar.className = "h-2 rounded-full bg-green-500";
                strengthText.textContent = "Mot de passe fort";
                strengthText.className = "text-sm mt-1 text-green-600";
                break;
        }

    });
</script>
</body>
</html>