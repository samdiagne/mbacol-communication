@extends('layouts.admin')

@section('title', 'Commandes')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Commandes</h1>
    <p class="text-gray-600">Gérez toutes vos commandes</p>
</div>

<!-- Filtres -->
<div class="bg-white rounded-lg shadow mb-6 p-4">
    <form method="GET" class="flex flex-wrap gap-4">
        <input type="text" 
               name="search" 
               value="{{ request('search') }}"
               placeholder="Rechercher (N°, nom, email, tél...)" 
               class="flex-1 min-w-[200px] px-4 py-2 border border-gray-300 rounded-lg">
        
        <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg">
            <option value="">Tous les statuts</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>En attente</option>
            <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmée</option>
            <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>En préparation</option>
            <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>Expédiée</option>
            <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Livrée</option>
            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Annulée</option>
        </select>

        <select name="payment_status" class="px-4 py-2 border border-gray-300 rounded-lg">
            <option value="">Tous paiements</option>
            <option value="pending" {{ request('payment_status') === 'pending' ? 'selected' : '' }}>En attente</option>
            <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Payée</option>
            <option value="failed" {{ request('payment_status') === 'failed' ? 'selected' : '' }}>Échouée</option>
        </select>

        <button type="submit" class="bg-primary-600 text-white px-6 py-2 rounded-lg hover:bg-primary-700">
            Filtrer
        </button>
        <a href="{{ route('admin.orders.index') }}" class="bg-gray-100 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-200">
            Réinitialiser
        </a>
    </form>
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