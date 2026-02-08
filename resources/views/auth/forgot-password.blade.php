<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-4xl bg-white rounded-2xl shadow-lg overflow-hidden">

            <div class="grid grid-cols-1 md:grid-cols-2">

                <!-- FORMULAIRE -->
                <div class="p-10 flex flex-col justify-center">
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold text-gray-900">
                            Mot de passe oublié
                        </h2>
                        <p class="text-gray-600 mt-1">
                            Entrez votre email pour recevoir un lien de réinitialisation
                        </p>
                    </div>

                    <!-- Message succès -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <!-- Email -->
                        <div class="mb-6">
                            <x-input-label for="email" value="Adresse email" />
                            <x-text-input id="email"
                                class="block mt-1 w-full"
                                type="email"
                                name="email"
                                :value="old('email')"
                                required
                                autofocus />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Bouton -->
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-primary-600 to-secondary-600 text-white font-bold py-3 rounded-full hover:opacity-90 transition">
                            Envoyer le lien
                        </button>

                        <!-- Retour login -->
                        <p class="text-sm text-gray-600 text-center mt-6">
                            Vous vous souvenez de votre mot de passe ?
                            <a href="{{ route('login') }}" class="text-primary-600 hover:underline font-semibold">
                                Se connecter
                            </a>
                        </p>
                    </form>
                </div>

                <!-- PARTIE DROITE -->
                <div class="hidden md:flex items-center justify-center bg-gradient-to-br from-primary-500 to-secondary-500 text-white p-10">
                    <div class="text-center">
                        <h2 class="text-4xl font-bold mb-4">
                            Pas de panique 😉
                        </h2>
                        <p class="mb-6 text-lg">
                            Nous allons vous aider à récupérer l’accès à votre compte
                        </p>
                        <a href="{{ route('login') }}"
                           class="inline-block border border-white rounded-full px-6 py-3 hover:bg-white hover:text-orange-600 transition">
                            Retour connexion
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-guest-layout>
