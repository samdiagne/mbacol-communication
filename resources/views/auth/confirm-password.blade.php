<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-4xl bg-white rounded-2xl shadow-lg overflow-hidden">

            <div class="grid grid-cols-1 md:grid-cols-2">

                <!-- FORMULAIRE -->
                <div class="p-10 flex flex-col justify-center">
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold text-gray-900">
                            Confirmation requise
                        </h2>
                        <p class="text-gray-600 mt-2">
                            Cette action est sécurisée. Veuillez confirmer votre mot de passe pour continuer.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <!-- Password -->
                        <div class="mb-6">
                            <x-input-label for="password" value="Mot de passe" />
                            <x-text-input
                                id="password"
                                class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <button
                            type="submit"
                            class="w-full bg-gradient-to-r from-primary-500 to-secondary-500 text-white font-bold py-3 rounded-full hover:opacity-90 transition">
                            Confirmer
                        </button>
                    </form>
                </div>

                <!-- VISUEL -->
                <div class="hidden md:flex items-center justify-center bg-gradient-to-br from-primary-500 to-secondary-500 text-white p-10">
                    <div class="text-center">
                        <h2 class="text-4xl font-bold mb-4">
                            Sécurité 🔐
                        </h2>
                        <p class="text-lg">
                            Nous protégeons votre compte contre les accès non autorisés
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-guest-layout>
