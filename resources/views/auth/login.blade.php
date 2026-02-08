<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-4xl bg-white rounded-2xl shadow-lg overflow-hidden">

            <div class="grid grid-cols-1 md:grid-cols-2">

                <!-- FORMULAIRE -->
                <div class="p-10 flex flex-col justify-center">
                    <div class="mb-8">
                        <div class="text-center">
                        <h2 class="text-3xl font-bold text-gray-900">Connexion</h2>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email -->
                        <div class="mb-4">
                            <x-input-label for="email" value="Email" />
                            <x-text-input id="email" 
                                          class="block mt-1 w-full"
                                          type="email" 
                                          name="email" 
                                          :value="old('email')" 
                                          required autofocus />
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

                        <!-- Remember me -->
                        <div class="flex items-center justify-between mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="remember" class="rounded border-gray-300 text-primary-600 shadow-sm focus:ring-primary-500">
                                <span class="ml-2 text-sm text-gray-600">Se souvenir de moi</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a class="text-sm text-primary-600 hover:underline" href="{{ route('password.request') }}">
                                    Mot de passe oublié ?
                                </a>
                            @endif
                        </div>

                        <button type="submit"
                            class="w-full bg-gradient-to-r from-primary-600 to-secondary-600 text-white font-bold py-3 rounded-full hover:opacity-90 transition">
                            Se connecter
                        </button>
                    </form>
                </div>

                <!-- PARTIE DROITE -->
                <div class="hidden md:flex items-center justify-center bg-gradient-to-br from-primary-600 to-secondary-600 text-white p-10">
                    <div class="text-center">
                        <h2 class="text-4xl font-bold mb-4">Bienvenue !</h2>
                        <p class="mb-6 text-lg">
                            Connectez-vous pour accéder à votre espace
                        </p>
                        <a href="{{ route('register') }}"
                           class="inline-block border border-white rounded-full px-6 py-3 hover:bg-white hover:text-orange-600 transition">
                            Pas encore de compte ? Inscrivez-vous
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-guest-layout>
