@extends('layouts.admin')

@section('title', 'Commandes')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Commandes</h1>
    <p class="text-gray-600">Gérez toutes vos commandes</p>
</div>

<!-- Filtres Modernes avec Animations -->
<div class="bg-white rounded-2xl shadow-lg mb-6 p-6 border border-gray-100" x-data="{ expanded: true }">
    <!-- Header avec Toggle -->
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-secondary-500 rounded-xl flex items-center justify-center shadow-md">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-900">Filtres de recherche</h3>
                <p class="text-xs text-gray-500">Affinez vos résultats</p>
            </div>
        </div>
        
        <!-- Toggle Button -->
        <button @click="expanded = !expanded" 
                class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
            <svg class="w-5 h-5 text-gray-600 transition-transform duration-200" 
                 :class="{ 'rotate-180': !expanded }"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
    </div>

    <!-- Formulaire de filtres (collapsible) -->
    <div x-show="expanded" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2">
        
        <form method="GET" class="space-y-4">
            <!-- Ligne 1 : Recherche -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    🔍 Recherche globale
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="N° commande, nom, email, téléphone..." 
                           class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all hover:border-primary-300">
                </div>
            </div>

            <!-- Ligne 2 : Selects -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Statut commande -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        📦 Statut de la commande
                    </label>
                    <div class="relative">
                        <select name="status" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl appearance-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all hover:border-primary-300 bg-white cursor-pointer">
                            <option value="">Tous les statuts</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>⏳ En attente</option>
                            <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>✅ Confirmée</option>
                            <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>🔄 En préparation</option>
                            <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>🚚 Expédiée</option>
                            <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>✓ Livrée</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>❌ Annulée</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Statut paiement -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        💳 Statut du paiement
                    </label>
                    <div class="relative">
                        <select name="payment_status" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl appearance-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all hover:border-primary-300 bg-white cursor-pointer">
                            <option value="">Tous les paiements</option>
                            <option value="pending" {{ request('payment_status') === 'pending' ? 'selected' : '' }}>⏳ En attente</option>
                            <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>✅ Payée</option>
                            <option value="failed" {{ request('payment_status') === 'failed' ? 'selected' : '' }}>❌ Échouée</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ligne 3 : Boutons -->
            <div class="flex flex-wrap gap-3 pt-2">
                <button type="submit" 
                        class="flex-1 md:flex-initial bg-gradient-to-r from-primary-600 to-secondary-600 text-white font-bold px-8 py-3 rounded-xl hover:shadow-lg transform hover:scale-[1.02] transition-all duration-200 flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    <span>Appliquer les filtres</span>
                </button>
                
                <a href="{{ route('admin.orders.index') }}" 
                   class="flex-1 md:flex-initial bg-gray-100 text-gray-700 font-semibold px-8 py-3 rounded-xl hover:bg-gray-200 transition-all duration-200 flex items-center justify-center space-x-2 border-2 border-gray-200 hover:border-gray-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    <span>Réinitialiser</span>
                </a>
            </div>

            <!-- Indicateur filtres actifs -->
            @if(request('search') || request('status') || request('payment_status'))
            <div class="flex items-center space-x-2 pt-3 border-t border-gray-200">
                <span class="text-sm font-semibold text-gray-700">Filtres actifs :</span>
                <div class="flex flex-wrap gap-2">
                    @if(request('search'))
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-primary-100 text-primary-800 animate-pulse">
                        🔍 {{ request('search') }}
                    </span>
                    @endif
                    @if(request('status'))
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 animate-pulse">
                        📦 {{ ucfirst(request('status')) }}
                    </span>
                    @endif
                    @if(request('payment_status'))
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 animate-pulse">
                        💳 {{ ucfirst(request('payment_status')) }}
                    </span>
                    @endif
                </div>
            </div>
            @endif
        </form>
    </div>
</div>

<!-- Stats rapides -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-sm text-gray-600 mb-1">Total commandes</p>
        <p class="text-3xl font-bold">{{ \App\Models\Order::count() }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-sm text-gray-600 mb-1">En attente</p>
        <p class="text-3xl font-bold text-yellow-600">{{ \App\Models\Order::where('status', 'pending')->count() }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-sm text-gray-600 mb-1">Livrées</p>
        <p class="text-3xl font-bold text-green-600">{{ \App\Models\Order::where('status', 'delivered')->count() }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-sm text-gray-600 mb-1">Revenus</p>
        <p class="text-3xl font-bold text-primary-600">{{ number_format(\App\Models\Order::where('payment_status', 'paid')->sum('total'), 0, ',', ' ') }} F</p>
    </div>
</div>

<!-- Tableau -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">N° Commande</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Articles</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paiement</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($orders as $order)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                    <span class="font-mono font-semibold text-primary-600">{{ $order->order_number }}</span>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm">
                        <p class="font-semibold">{{ $order->customer_name }}</p>
                        <p class="text-gray-500">{{ $order->customer_phone }}</p>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <span class="text-sm">{{ $order->items->count() }} article(s)</span>
                </td>
                <td class="px-6 py-4">
                    <span class="font-semibold">{{ $order->formatted_total }}</span>
                </td>
                <td class="px-6 py-4">
                    @if($order->payment_status === 'paid')
                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">Payée</span>
                    @elseif($order->payment_status === 'pending')
                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full">En attente</span>
                    @else
                        <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">{{ $order->payment_status_label }}</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    @if($order->status === 'delivered')
                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">{{ $order->status_label }}</span>
                    @elseif($order->status === 'cancelled')
                        <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">{{ $order->status_label }}</span>
                    @else
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">{{ $order->status_label }}</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">
                    {{ $order->created_at->format('d/m/Y H:i') }}
                </td>
                <td class="px-6 py-4 text-right">
                    <a href="{{ route('admin.orders.show', $order) }}" class="text-primary-600 hover:text-primary-900">
                        Détails →
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                    Aucune commande trouvée
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($orders->hasPages())
<div class="mt-6">
    {{ $orders->links() }}
</div>
@endif
@endsection