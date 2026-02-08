<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-4xl bg-white rounded-2xl shadow-lg overflow-hidden">

            <div class="grid grid-cols-1 md:grid-cols-2">

                <!-- FORMULAIRE -->
                <div class="p-10 flex flex-col justify-center">
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold text-gray-900">
                            Nouveau mot de passe
                        </h2>
                        <p class="text-gray-600 mt-1">
                            Choisissez un mot de passe sécurisé
                        </p>
                    </div>

                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf

                        <!-- Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <!-- Email -->
                        <div class="mb-4">
                            <x-input-label for="email" value="Adresse email" />
                            <x-text-input
                                id="email"
                                class="block mt-1 w-full"
                                type="email"
                                name="email"
                                :value="old('email', $request->email)"
                                required
                                autofocus />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <x-input-label for="password" value="Nouveau mot de passe" />
                            <x-text-input
                                id="password"
                                class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Confirm -->
                        <div class="mb-6">
                            <x-input-label for="password_confirmation" value="Confirmer le mot de passe" />
                            <x-text-input
                                id="password_confirmation"
                                class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation"
                                required />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <button type="submit"
                            class="w-full bg-gradient-to-r from-primary-500 to-secondary-500 text-white font-bold py-3 rounded-full hover:opacity-90 transition">
                            Réinitialiser le mot de passe
                        </button>
                    </form>
                </div>

                <!-- VISUEL -->
                <div class="hidden md:flex items-center justify-center bg-gradient-to-br from-primary-500 to-secondary-500 text-white p-10">
                    <div class="text-center">
                        <h2 class="text-4xl font-bold mb-4">
                            Presque fini 🔐
                        </h2>
                        <p class="text-lg">
                            Un nouveau mot de passe et vous êtes prêt à repartir
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-guest-layout>
