<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-4xl bg-white rounded-2xl shadow-lg overflow-hidden">

            <div class="grid grid-cols-1 md:grid-cols-2">

                <!-- FORMULAIRE INSCRIPTION -->
                <div class="p-10 flex flex-col justify-center">
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold text-gray-900">
                            Créer un compte
                        </h2>
                        <p class="text-gray-600 mt-1">
                            Rejoignez 
                            <span class="text-600 mt-1 font-bold text-primary-600">Mbacol</span>
                            <span class="text-600 mt-1 font-bold text-secondary-600 ml-1">Communication</span>
                        </p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Nom -->
                        <div class="mb-4">
                            <x-input-label for="name" value="Nom complet" />
                            <x-text-input id="name"
                                class="block mt-1 w-full"
                                type="text"
                                name="name"
                                :value="old('name')"
                                required
                                autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <x-input-label for="email" value="Email" />
                            <x-text-input id="email"
                                class="block mt-1 w-full"
                                type="email"
                                name="email"
                                :value="old('email')"
                                required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Mot de passe -->
                        <div class="mb-4">
                            <x-input-label for="password" value="Mot de passe" />
                            <x-text-input id="password"
                                class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Confirmation -->
                        <div class="mb-6">
                            <x-input-label for="password_confirmation" value="Confirmer le mot de passe" />
                            <x-text-input id="password_confirmation"
                                class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation"
                                required />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <!-- Bouton -->
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-primary-600 to-secondary-600 text-white font-bold py-3 rounded-full hover:opacity-90 transition">
                            S’inscrire
                        </button>
                    </form>
                </div>

                <!-- PARTIE DROITE -->
                <div class="hidden md:flex items-center justify-center bg-gradient-to-br from-primary-600 to-secondary-600 text-white p-10">
                    <div class="text-center">
                        <svg class="mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" width="96" height="96" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-in"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                        <h2 class="text-4xl font-bold mb-4">Content de vous revoir !</h2>
                        <p class="mb-6 text-lg">
                            Pour rester en contact avec nous, veuillez vous connecter à votre compte.
                        </p>
                        <a href="{{ route('login') }}"
                           class="inline-block border border-white rounded-full px-6 py-3 hover:bg-white hover:text-primary-600 transition">
                            Se connecter
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-guest-layout>
