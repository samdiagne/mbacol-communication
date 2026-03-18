@extends('layouts.admin')

@section('title', 'Ajouter un membre de l\'équipe')

@section('content')
<div class="mb-8 flex items-center justify-between">
    <h1 class="text-3xl font-bold text-gray-900">Ajouter un membre de l'équipe</h1>
    <a href="{{ route('admin.team.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200">← Retour à l'équipe</a>
</div>

<div class="bg-white rounded-2xl shadow-sm p-6 max-w-2xl">
    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-50 text-red-700 rounded-xl">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li class="text-sm">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.team.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Nom -->
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nom</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent">
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent">
        </div>

        <!-- Mot de passe -->
        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Mot de passe</label>
            <input type="password" name="password" id="password" required
                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent">
        </div>

        <!-- Confirmation mot de passe -->
        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required
                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent">
        </div>

        <!-- Bouton Soumettre -->
        <div class="flex justify-end">
            <button type="submit" 
                class="px-6 py-3 bg-primary-600 text-white font-semibold rounded-xl hover:bg-primary-700 transition">
                Ajouter
            </button>
        </div>
    </form>
</div>
@endsection