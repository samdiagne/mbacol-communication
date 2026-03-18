@extends('layouts.customer')

@section('title', 'Mon profil')

@section('content')
<div class="space-y-6">
    
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Mon profil</h1>
        <p class="text-gray-600">Gérez vos informations personnelles</p>
    </div>

    <!-- Informations personnelles -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold mb-4">Informations personnelles</h2>
        
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')

            <div class="space-y-4">
                <!-- Nom -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nom complet
                    </label>
                    <input type="text" 
                           name="name" 
                           value="{{ old('name', $user->name) }}"
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('name') @enderror">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Email
                    </label>
                    <input type="email" 
                           name="email" 
                           value="{{ old('email', $user->email) }}"
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('email') @enderror">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    
                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div class="mt-2 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <p class="text-sm text-yellow-800">
                                Votre email n'est pas vérifié.
                                <button form="send-verification" class="underline text-yellow-900 hover:text-yellow-700">
                                    Renvoyer l'email de vérification
                                </button>
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Bouton Sauvegarder -->
                <div class="pt-4">
                    <button type="submit" 
                            class="bg-primary-600 hover:bg-primary-700 text-white font-bold py-3 px-8 rounded-lg transition duration-200">
                        Enregistrer les modifications
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Mot de passe -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold mb-4">Changer le mot de passe</h2>
        
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <!-- Mot de passe actuel -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Mot de passe actuel
                    </label>
                    <input type="password" 
                           name="current_password"
                           autocomplete="current-password"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('current_password', 'updatePassword') @enderror">
                    @error('current_password', 'updatePassword')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nouveau mot de passe -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nouveau mot de passe
                    </label>
                    <input type="password" 
                           name="password"
                           autocomplete="new-password"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('password', 'updatePassword') @enderror">
                    @error('password', 'updatePassword')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirmation -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Confirmer le mot de passe
                    </label>
                    <input type="password" 
                           name="password_confirmation"
                           autocomplete="new-password"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>

                <!-- Bouton -->
                <div class="pt-4">
                    <button type="submit" 
                            class="bg-primary-600 hover:bg-primary-700 text-white font-bold py-3 px-8 rounded-lg transition duration-200">
                        Changer le mot de passe
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Supprimer le compte -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold mb-4 text-red-600">Zone critique</h2>
        
        <p class="text-gray-600 mb-4">
            Une fois votre compte supprimé, toutes vos données seront définitivement effacées. 
            Téléchargez vos commandes avant de supprimer votre compte.
        </p>

        <button type="button"
                onclick="document.getElementById('delete-modal').classList.remove('hidden')"
                class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-lg transition duration-200">
            Supprimer mon compte
        </button>
    </div>
</div>

<!-- Modal de confirmation suppression -->
<div id="delete-modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 items-center justify-center z-50">
    <div class="bg-white rounded-lg p-8 max-w-md">
        <h3 class="text-xl font-bold mb-4">Êtes-vous sûr ?</h3>
        <p class="text-gray-600 mb-6">
            Cette action est irréversible. Toutes vos données seront définitivement supprimées.
        </p>

        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('DELETE')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Confirmez votre mot de passe
                </label>
                <input type="password" 
                       name="password"
                       required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div>

            <div class="flex gap-3">
                <button type="button"
                        onclick="document.getElementById('delete-modal').classList.add('hidden')"
                        class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 rounded-lg">
                    Annuler
                </button>
                <button type="submit"
                        class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-lg">
                    Supprimer
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Formulaire vérification email (caché) -->
@if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
<form id="send-verification" method="POST" action="{{ route('verification.send') }}" class="hidden">
    @csrf
</form>
@endif
@endsection