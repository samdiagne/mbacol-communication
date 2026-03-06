@extends('layouts.admin')

@section('title', 'Détails Client')

@section('content')
<!-- Header -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.clients.index') }}" 
               class="text-sm text-gray-600 hover:text-primary-600 mb-2 inline-flex items-center">
                ← Retour aux clients
            </a>
            <h1 class="text-3xl font-bold text-gray-900 mt-2">{{ $user->name }}</h1>
            <p class="text-gray-600 mt-1">{{ $user->email }}</p>
        </div>
        <div class="flex gap-2">
            <form method="POST" action="{{ route('admin.clients.toggle-status', $user) }}">
                @csrf
                @method('PATCH')
                <button type="submit" 
                        class="px-4 py-2 rounded-xl font-semibold transition {{ $user->trashed() ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-orange-100 text-orange-700 hover:bg-orange-200' }}">
                    {{ $user->trashed() ? 'Réactiver' : 'Désactiver' }}
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow p-6">
        <div class="text-sm text-gray-500 mb-1">Total Commandes</div>
        <div class="text-3xl font-bold text-gray-900">{{ $stats['total_orders'] }}</div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow p-6">
        <div class="text-sm text-gray-500 mb-1">CA Total</div>
        <div class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_spent'], 0, ',', ' ') }} F</div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow p-6">
        <div class="text-sm text-gray-500 mb-1">En Attente</div>
        <div class="text-3xl font-bold text-gray-900">{{ $stats['pending_orders'] }}</div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow p-6">
        <div class="text-sm text-gray-500 mb-1">Note Moyenne</div>
        <div class="text-3xl font-bold text-gray-900">
            {{ $stats['avg_rating'] ? number_format($stats['avg_rating'], 1) : '-' }} ⭐
        </div>
    </div>
</div>

<!-- Dernières Commandes -->
<div class="bg-white rounded-2xl shadow-sm overflow-hidden mb-8">
    <div class="p-6 border-b border-gray-100">
        <h3 class="text-lg font-bold text-gray-900">Dernières Commandes</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">N°</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Montant</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-50">
                @forelse($user->orders as $order)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-semibold text-primary-600">
                        #{{ $order->order_number }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        {{ $order->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                        {{ $order->formatted_total }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold
                            {{ $order->status === 'pending' ? 'bg-yellow-50 text-yellow-700' : '' }}
                            {{ $order->status === 'confirmed' ? 'bg-blue-50 text-blue-700' : '' }}
                            {{ $order->status === 'delivered' ? 'bg-green-50 text-green-700' : '' }}
                            {{ $order->status === 'cancelled' ? 'bg-red-50 text-red-700' : '' }}">
                            {{ $order->status_label }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.orders.show', $order) }}" 
                           class="text-primary-600 hover:text-primary-700 font-semibold text-sm">
                            Voir →
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                        Aucune commande
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Derniers Avis -->
@if($user->reviews->count() > 0)
<div class="bg-white rounded-2xl shadow-sm p-6">
    <h3 class="text-lg font-bold text-gray-900 mb-4">Derniers Avis</h3>
    <div class="space-y-4">
        @foreach($user->reviews as $review)
        <div class="border border-gray-100 rounded-xl p-4">
            <div class="flex items-center justify-between mb-2">
                <div class="text-sm font-semibold text-gray-900">
                    {{ $review->product->name }}
                </div>
                <div class="text-yellow-500">
                    @for($i = 0; $i < 5; $i++)
                        @if($i < $review->rating)
                        ⭐
                        @else
                        ☆
                        @endif
                    @endfor
                </div>
            </div>
            <p class="text-sm text-gray-600">{{ $review->comment }}</p>
            <div class="text-xs text-gray-400 mt-2">
                {{ $review->created_at->format('d/m/Y') }}
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif
@endsection