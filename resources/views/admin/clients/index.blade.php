@extends('layouts.admin')

@section('title', 'Clients')

@section('content')
<!-- Header -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gestion des Clients</h1>
            <p class="text-gray-600 mt-1">{{ $stats['total'] }} client(s) inscrit(s)</p>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Clients -->
    <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
        </div>
        <p class="text-4xl font-bold text-gray-900 mb-1">{{ $stats['total'] }}</p>
        <p class="text-sm text-gray-500">Total Clients</p>
    </div>

    <!-- Clients Actifs -->
    <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <p class="text-4xl font-bold text-gray-900 mb-1">{{ $stats['active'] }}</p>
        <p class="text-sm text-gray-500">Clients Actifs</p>
    </div>

    <!-- Clients avec Commandes -->
    <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
            </div>
        </div>
        <p class="text-4xl font-bold text-gray-900 mb-1">{{ $stats['with_orders'] }}</p>
        <p class="text-sm text-gray-500">Ont Commandé</p>
    </div>

    <!-- CA Clients -->
    <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <p class="text-4xl font-bold text-gray-900 mb-1">{{ number_format($stats['total_revenue'] / 1000, 0) }}K</p>
        <p class="text-sm text-gray-500">CA Total Clients</p>
    </div>
</div>

<!-- Filtres et Recherche -->
<div class="bg-white rounded-2xl shadow-sm p-6 mb-8">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Recherche -->
        <div class="md:col-span-2">
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}"
                   placeholder="Rechercher par nom ou email..."
                   class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent">
        </div>

        <!-- Filtre Statut -->
        <div>
            <select name="status" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                <option value="">Tous les statuts</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Actifs</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactifs</option>
            </select>
        </div>

        <!-- Boutons -->
        <div class="flex gap-2">
            <button type="submit" 
                    class="flex-1 bg-gradient-to-r from-primary-600 to-secondary-600 text-white font-semibold px-4 py-2 rounded-xl hover:shadow-lg transition">
                Filtrer
            </button>
            <a href="{{ route('admin.clients.index') }}" 
               class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition">
                Réinitialiser
            </a>
        </div>
    </form>
</div>

<!-- Tableau Clients -->
<div class="bg-white rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Client</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Inscription</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Commandes</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">CA Total</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Avis</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-50">
                @forelse($clients as $client)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-secondary-500 rounded-full flex items-center justify-center text-white font-bold">
                                {{ substr($client->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-gray-900">{{ $client->name }}</div>
                                <div class="text-xs text-gray-500">{{ $client->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $client->created_at->format('d/m/Y') }}</div>
                        <div class="text-xs text-gray-500">{{ $client->created_at->diffForHumans() }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm font-semibold text-gray-900">{{ $client->orders_count }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm font-semibold text-gray-900">
                            {{ number_format($client->total_spent ?? 0, 0, ',', ' ') }} FCFA
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm font-semibold text-gray-900">{{ $client->reviews_count }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($client->trashed())
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                            Inactif
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-700">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                            Actif
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.clients.show', $client) }}" 
                               class="text-primary-600 hover:text-primary-700 font-semibold text-sm">
                                Voir
                            </a>
                            <form method="POST" action="{{ route('admin.clients.toggle-status', $client) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="text-sm font-semibold {{ $client->trashed() ? 'text-green-600 hover:text-green-700' : 'text-orange-600 hover:text-orange-700' }}">
                                    {{ $client->trashed() ? 'Activer' : 'Désactiver' }}
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                        Aucun client trouvé
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($clients->hasPages())
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
        {{ $clients->links() }}
    </div>
    @endif
</div>
@endsection