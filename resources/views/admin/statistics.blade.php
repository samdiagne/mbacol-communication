@extends('layouts.admin')

@section('title', 'Statistiques Détaillées')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">📈 Statistiques Détaillées</h1>
            <p class="text-gray-600 mt-1">Analyse approfondie des performances</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" 
           class="inline-flex items-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold px-6 py-3 rounded-xl transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Retour Dashboard
        </a>
    </div>
</div>

<!-- Stats Résumé -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-white">
        <p class="text-green-100 text-sm font-medium">Chiffre d'Affaires Total</p>
        <p class="text-4xl font-bold mt-2">{{ number_format($totalRevenue, 0, ',', ' ') }}</p>
        <p class="text-green-100 text-xs mt-2">FCFA</p>
    </div>
    
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white">
        <p class="text-blue-100 text-sm font-medium">Total Commandes</p>
        <p class="text-4xl font-bold mt-2">{{ $totalOrders }}</p>
        <p class="text-blue-100 text-xs mt-2">Depuis le début</p>
    </div>
    
    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg p-6 text-white">
        <p class="text-purple-100 text-sm font-medium">Panier Moyen</p>
        <p class="text-4xl font-bold mt-2">{{ number_format($avgOrderValue, 0, ',', ' ') }}</p>
        <p class="text-purple-100 text-xs mt-2">FCFA</p>
    </div>
</div>

<!-- Graphiques -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    
    <!-- Évolution Commandes (6 mois) -->
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-900 mb-4">📊 Évolution des Commandes (6 mois)</h3>
        <div style="height: 300px; position: relative;">
            <canvas id="monthlyOrdersChart"></canvas>
        </div>
    </div>

    <!-- Chiffre d'Affaires (6 mois) -->
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-900 mb-4">💰 Chiffre d'Affaires Mensuel</h3>
        <div style="height: 300px; position: relative;">
            <canvas id="monthlyRevenueChart"></canvas>
        </div>
    </div>

    <!-- Répartition par Statut -->
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-900 mb-4">📋 Répartition par Statut</h3>
        <div style="height: 300px; position: relative;">
            <canvas id="ordersByStatusChart"></canvas>
        </div>
    </div>

    <!-- Top 5 Produits -->
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-900 mb-4">⭐ Top 5 Produits Vendus</h3>
        <div style="height: 300px; position: relative;">
            <canvas id="topProductsChart"></canvas>
        </div>
    </div>
</div>

<!-- Scripts Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// @ts-nocheck
document.addEventListener('DOMContentLoaded', function() {
    const commonOptions = {
        responsive: true,
        maintainAspectRatio: true,
        aspectRatio: 2,
        plugins: {
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    padding: 15,
                    font: { size: 12 }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { precision: 0 }
            }
        }
    };

    // Helper pour créer les charts en toute sécurité
    function createChart(elementId, config) {
        const canvas = document.getElementById(elementId);
        if (!canvas) {
            console.warn(`Canvas ${elementId} not found`);
            return null;
        }
        return new Chart(canvas, config);
    }

    // 1. Commandes par Mois
    createChart('monthlyOrdersChart', {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlyLabels) !!},
            datasets: [{
                label: 'Commandes',
                data: {!! json_encode($monthlyOrdersData) !!},
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true,
                borderWidth: 3,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: commonOptions
    });

    // 2. CA Mensuel
    createChart('monthlyRevenueChart', {
        type: 'bar',
        data: {
            labels: {!! json_encode($monthlyLabels) !!},
            datasets: [{
                label: 'CA (FCFA)',
                data: {!! json_encode($monthlyRevenueData) !!},
                backgroundColor: 'rgba(16, 185, 129, 0.8)',
                borderColor: 'rgb(16, 185, 129)',
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false
            }]
        },
        options: {
            ...commonOptions,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString('fr-FR') + ' FCFA';
                        }
                    }
                }
            }
        }
    });

    // 3. Commandes par Statut
    createChart('ordersByStatusChart', {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($statusLabels) !!},
            datasets: [{
                data: {!! json_encode($statusData) !!},
                backgroundColor: {!! json_encode($statusBackgroundColors) !!},
                borderWidth: 3,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 2,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        font: { size: 12 }
                    }
                }
            }
        }
    });

    // 4. Top 5 Produits
    createChart('topProductsChart', {
        type: 'bar',
        data: {
            labels: {!! json_encode($topProductsLabels) !!},
            datasets: [{
                label: 'Quantité Vendue',
                data: {!! json_encode($topProductsData) !!},
                backgroundColor: 'rgba(251, 146, 60, 0.8)',
                borderColor: 'rgb(251, 146, 60)',
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false
            }]
        },
        options: {
            ...commonOptions,
            indexAxis: 'y',
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                },
                y: {
                    ticks: { autoSkip: false }
                }
            }
        }
    });
});
</script>
@endsection