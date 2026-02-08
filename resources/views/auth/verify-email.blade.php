<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-4xl bg-white rounded-2xl shadow-lg overflow-hidden">

            <div class="grid grid-cols-1 md:grid-cols-2">

                <!-- TEXTE -->
                <div class="p-10 flex flex-col justify-center">
                    <div class="mb-6">
                        <h2 class="text-3xl font-bold text-gray-900">
                            Vérifiez votre email
                        </h2>
                        <p class="text-gray-600 mt-2">
                            Nous vous avons envoyé un lien de confirmation.
                            Cliquez dessus pour activer votre compte.
                        </p>
                    </div>

                    @if (session('status') == 'verification-link-sent')
                        <div class="mb-4 text-green-600 font-semibold">
                            Un nouveau lien de vérification a été envoyé.
                        </div>
                    @endif

                    <div class="flex flex-col gap-4 mt-6">
                        <!-- Renvoyer -->
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button
                                class="w-full bg-gradient-to-r from-primary-500 to-secondary-500 text-white font-bold py-3 rounded-full hover:opacity-90 transition">
                                Renvoyer l’email de vérification
                            </button>
                        </form>

                        <!-- Déconnexion -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full border border-gray-300 py-3 rounded-full text-gray-700 hover:bg-gray-100 transition">
                                Se déconnecter
                            </button>
                        </form>
                    </div>
                </div>

                <!-- VISUEL -->
                <div class="hidden md:flex items-center justify-center bg-gradient-to-br from-primary-500 to-secondary-500 text-white p-10">
                    <div class="text-center">
                        <h2 class="text-4xl font-bold mb-4">
                            Encore une étape ✉️
                        </h2>
                        <p class="text-lg">
                            Vérifiez votre boîte mail pour finaliser l’inscription
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-guest-layout>
