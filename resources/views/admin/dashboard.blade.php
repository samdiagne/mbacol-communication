@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')
<!-- Header -->
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Tableau de bord</h1>
            <p class="text-gray-600 mt-1">Bienvenue, {{ Auth::user()->name }} 👋</p>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
    <!-- Total Produits -->
    <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            
        </div>
        <p class="text-4xl font-bold text-gray-900 mb-1">{{ $stats['total_products'] }}</p>
        <p class="text-sm text-gray-500">Total Produits</p>
        <p class="text-xs text-gray-400 mt-2">{{ $stats['active_products'] }} actifs</p>
    </div>

    <!-- Total Commandes -->
    <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            @if($stats['orders_variation'] != 0)
            <span class="text-xs font-semibold flex items-center gap-1
                {{ $stats['orders_variation'] > 0 ? 'text-green-600' : 'text-red-600' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    @if($stats['orders_variation'] > 0)
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                    @else
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                    @endif
                </svg>
                {{ abs($stats['orders_variation']) }}%
            </span>
            @endif
        </div>
        <p class="text-4xl font-bold text-gray-900 mb-1">{{ $stats['total_orders'] }}</p>
        <p class="text-sm text-gray-500">Total Commandes</p>
        <p class="text-xs text-gray-400 mt-2">{{ $stats['pending_orders'] }} en attente</p>
    </div>

    <!-- CA Total -->
    <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            @if($stats['total_revenue_variation'] != 0)
            <span class="text-xs font-semibold flex items-center gap-1
                {{ $stats['total_revenue_variation'] > 0 ? 'text-green-600' : 'text-red-600' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    @if($stats['total_revenue_variation'] > 0)
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                    @else
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                    @endif
                </svg>
                {{ abs($stats['total_revenue_variation']) }}%
            </span>
            @endif
        </div>
        <p class="text-4xl font-bold text-gray-900 mb-1">{{ number_format($stats['total_revenue'] / 1000, 0) }}K</p>
        <p class="text-sm text-gray-500">CA Total</p>
        <p class="text-xs text-gray-400 mt-2">{{ number_format($stats['total_revenue'], 0, ',', ' ') }} FCFA</p>
    </div>

    <!-- CA Mensuel -->
    <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
            @if($stats['monthly_revenue_variation'] != 0)
            <span class="text-xs font-semibold flex items-center gap-1
                {{ $stats['monthly_revenue_variation'] > 0 ? 'text-green-600' : 'text-red-600' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    @if($stats['monthly_revenue_variation'] > 0)
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                    @else
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                    @endif
                </svg>
                {{ abs($stats['monthly_revenue_variation']) }}%
            </span>
            @endif
        </div>
        <p class="text-4xl font-bold text-gray-900 mb-1">{{ number_format($stats['monthly_revenue'] / 1000, 0) }}K</p>
        <p class="text-sm text-gray-500">CA Mois en Cours</p>
        <p class="text-xs text-gray-400 mt-2">{{ number_format($stats['monthly_revenue'], 0, ',', ' ') }} FCFA</p>
    </div>
</div>

<!-- Graphiques côte à côte -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    
    <!-- Graphique Ventes -->
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-lg font-bold text-gray-900">Ventes 7 derniers jours</h3>
                <p class="text-xs text-gray-500 mt-1">Évolution du CA</p>
            </div>
            <a href="{{ route('admin.statistics') }}" 
               class="text-xs font-semibold text-primary-600 hover:text-primary-700">
                Détails →
            </a>
        </div>
        
        <div class="relative h-64">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <!-- Graphique Top Produits -->
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-lg font-bold text-gray-900">Top 5 Produits</h3>
                <p class="text-xs text-gray-500 mt-1">Les plus vendus</p>
            </div>
            <a href="{{ route('admin.products.index') }}" 
               class="text-xs font-semibold text-primary-600 hover:text-primary-700">
                Voir tout →
            </a>
        </div>
        
        <div class="relative h-64">
            <canvas id="productsChart"></canvas>
        </div>
    </div>
</div>

<!-- Alertes Stock -->
@if($low_stock->count() > 0)
<div class="bg-gradient-to-r from-red-50 to-orange-50 border-l-4 border-red-500 rounded-xl p-6 mb-8">
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <div class="ml-4 flex-1">
            <h3 class="text-lg font-bold text-red-900">⚠️ Stock Faible</h3>
            <p class="text-sm text-red-700 mt-1">{{ $low_stock->count() }} produit(s) à réapprovisionner</p>
            <div class="mt-4 flex flex-wrap gap-2">
                @foreach($low_stock as $product)
                <span class="inline-flex items-center gap-2 px-3 py-2 bg-white rounded-lg text-sm">
                    <a href="{{ route('admin.products.edit', $product) }}" class="font-semibold text-gray-900">{{ Str::limit($product->name, 20) }}</a>
                    <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-bold rounded">{{ $product->stock }}</span>
                </span>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif

<!-- Tableau Commandes Récentes (Pleine largeur) -->
<div class="bg-white rounded-2xl shadow-sm overflow-hidden mb-8">
    <div class="p-6 border-b border-gray-100">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-900">Dernières Commandes</h3>
            <span class="text-xs font-semibold text-gray-500">{{ $recent_orders->count() }} commandes</span>
        </div>
    </div>
    
    <!-- Version Desktop -->
    <div class="hidden md:block overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">N°</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Client</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Montant</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-50">
                @foreach($recent_orders as $order)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm font-semibold text-primary-600">#{{ $order->order_number }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ Str::limit($order->customer_name, 25) }}</div>
                        <div class="text-xs text-gray-500">{{ $order->customer_email }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $order->created_at->format('d/m/Y') }}</div>
                        <div class="text-xs text-gray-500">{{ $order->created_at->format('H:i') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-semibold text-gray-900">{{ $order->formatted_total }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold
                            {{ $order->status === 'pending' ? 'bg-yellow-50 text-yellow-700' : '' }}
                            {{ $order->status === 'confirmed' ? 'bg-blue-50 text-blue-700' : '' }}
                            {{ $order->status === 'delivered' ? 'bg-green-50 text-green-700' : '' }}
                            {{ $order->status === 'cancelled' ? 'bg-red-50 text-red-700' : '' }}">
                            <span class="w-1.5 h-1.5 rounded-full
                                {{ $order->status === 'pending' ? 'bg-yellow-500' : '' }}
                                {{ $order->status === 'confirmed' ? 'bg-blue-500' : '' }}
                                {{ $order->status === 'delivered' ? 'bg-green-500' : '' }}
                                {{ $order->status === 'cancelled' ? 'bg-red-500' : '' }}"></span>
                            {{ $order->status_label }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <a href="{{ route('admin.orders.show', $order) }}" 
                           class="text-primary-600 hover:text-primary-700 font-semibold">
                            Voir →
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <!-- Version Mobile -->
    <div class="md:hidden divide-y divide-gray-50">
        @foreach($recent_orders as $order)
        <a href="{{ route('admin.orders.show', $order) }}" 
           class="flex items-center justify-between px-6 py-4 hover:bg-gray-50 transition-colors">
            <div class="flex-1">
                <p class="text-sm font-semibold text-primary-600">#{{ $order->order_number }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ $order->customer_name }}</p>
            </div>
            <div class="text-right ml-4">
                <p class="text-sm font-bold text-gray-900">{{ $order->formatted_total }}</p>
                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold mt-1
                    {{ $order->status === 'pending' ? 'bg-yellow-50 text-yellow-700' : '' }}
                    {{ $order->status === 'confirmed' ? 'bg-blue-50 text-blue-700' : '' }}
                    {{ $order->status === 'delivered' ? 'bg-green-50 text-green-700' : '' }}
                    {{ $order->status === 'cancelled' ? 'bg-red-50 text-red-700' : '' }}">
                    <span class="w-1.5 h-1.5 rounded-full
                        {{ $order->status === 'pending' ? 'bg-yellow-500' : '' }}
                        {{ $order->status === 'confirmed' ? 'bg-blue-500' : '' }}
                        {{ $order->status === 'delivered' ? 'bg-green-500' : '' }}
                        {{ $order->status === 'cancelled' ? 'bg-red-500' : '' }}"></span>
                    {{ $order->status_label }}
                </span>
            </div>
        </a>
        @endforeach
    </div>
    
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
        <a href="{{ route('admin.orders.index') }}" 
           class="text-sm font-semibold text-primary-600 hover:text-primary-700 inline-flex items-center">
            Voir toutes les commandes
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>
</div>

<!-- Chart.js (même code) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Graphique Ventes
const salesCtx = document.getElementById('salesChart').getContext('2d');
new Chart(salesCtx, {
    type: 'bar',
    data: {
        labels: @json($last7Days),
        datasets: [{
            label: 'Ventes (FCFA)',
            data: @json($salesData),
            backgroundColor: 'rgba(59, 130, 246, 0.8)',
            borderRadius: 8,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#1f2937',
                padding: 12,
                borderRadius: 8,
                callbacks: {
                    label: function(context) {
                        return new Intl.NumberFormat('fr-FR').format(context.parsed.y) + ' FCFA';
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: '#f3f4f6', drawBorder: false },
                ticks: {
                    callback: function(value) {
                        return value / 1000 + 'K';
                    },
                    font: { size: 11 },
                    color: '#6b7280'
                }
            },
            x: {
                grid: { display: false, drawBorder: false },
                ticks: { font: { size: 11 }, color: '#6b7280' }
            }
        }
    }
});

// Graphique Top Produits
const productsCtx = document.getElementById('productsChart').getContext('2d');
new Chart(productsCtx, {
    type: 'doughnut',
    data: {
        labels: @json($topProducts->pluck('name')->map(fn($n) => \Str::limit($n, 20))),
        datasets: [{
            data: @json($topProducts->pluck('total_sold')),
            backgroundColor: [
                'rgba(59, 130, 246, 0.8)',
                'rgba(34, 197, 94, 0.8)',
                'rgba(251, 146, 60, 0.8)',
                'rgba(168, 85, 247, 0.8)',
                'rgba(244, 63, 94, 0.8)'
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '70%',
        plugins: {
            legend: {
                position: 'bottom',
                labels: { padding: 15, font: { size: 11 }, usePointStyle: true }
            },
            tooltip: {
                backgroundColor: '#1f2937',
                padding: 12,
                borderRadius: 8
            }
        }
    }
});
</script>
@endsection