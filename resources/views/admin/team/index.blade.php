@extends('layouts.admin')

@section('title', 'Équipe')

@section('content')
<div class="mb-8 flex items-center justify-between">
    <h1 class="text-3xl font-bold text-gray-900">Gestion de l'Équipe</h1>
    <a href="{{ route('admin.team.create') }}" class="px-4 py-2 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition">Ajouter un admin</a>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow p-6">
        <p class="text-4xl font-bold text-gray-900 mb-1">{{ $stats['total'] }}</p>
        <p class="text-sm text-gray-500">Total Admins</p>
    </div>
</div>

<!-- Recherche -->
<div class="bg-white rounded-2xl shadow-sm p-6 mb-8">
    <form method="GET" class="flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher par nom ou email..."
               class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500">
        <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-xl hover:bg-primary-700">Filtrer</button>
    </form>
</div>

<!-- Tableau -->
<div class="bg-white rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-50">
                @forelse($admins as $admin)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $admin->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $admin->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($admin->trashed())
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700">Inactif</span>
                        @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-700">Actif</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <form method="POST" action="{{ route('admin.team.toggle-status', $admin) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="px-3 py-1 rounded-xl text-sm font-semibold {{ $admin->trashed() ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                                {{ $admin->trashed() ? 'Réactiver' : 'Désactiver' }}
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">Aucun admin trouvé</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($admins->hasPages())
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
        {{ $admins->links() }}
    </div>
    @endif
</div>
@endsection