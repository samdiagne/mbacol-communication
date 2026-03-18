<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Période actuelle
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();
        
        // Il y a 1 mois (même date)
        $oneMonthAgo = $now->copy()->subMonth();
        
        // Mois précédent complet
        $startOfLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $now->copy()->subMonth()->endOfMonth();

        // === STATS ACTUELLES ===
        $totalProducts = Product::count();
        $activeProducts = Product::where('is_active', true)->count();
        
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total');
        $monthlyRevenue = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('total');

        // === STATS IL Y A 1 MOIS (pour totaux) ===
        $totalProductsOneMonthAgo = Product::where('created_at', '<=', $oneMonthAgo)->count();
        $totalOrdersOneMonthAgo = Order::where('created_at', '<=', $oneMonthAgo)->count();
        $totalRevenueOneMonthAgo = Order::where('payment_status', 'paid')
            ->where('created_at', '<=', $oneMonthAgo)
            ->sum('total');

        // === CA MOIS PRÉCÉDENT ===
        $lastMonthRevenue = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->sum('total');

        // === CALCUL VARIATIONS ===
        $productsVariation = $this->calculateVariation($totalProducts, $totalProductsOneMonthAgo);
        $ordersVariation = $this->calculateVariation($totalOrders, $totalOrdersOneMonthAgo);
        $totalRevenueVariation = $this->calculateVariation($totalRevenue, $totalRevenueOneMonthAgo);
        $monthlyRevenueVariation = $this->calculateVariation($monthlyRevenue, $lastMonthRevenue);

        // === DONNÉES GRAPHIQUE (7 derniers jours) ===
        $last7Days = [];
        $salesData = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $last7Days[] = $date->locale('fr')->isoFormat('ddd');
            
            $sales = Order::where('payment_status', 'paid')
                ->whereDate('created_at', $date)
                ->sum('total');
            
            $salesData[] = $sales;
        }

        // === TOP 5 PRODUITS ===
        $topProducts = Product::withCount(['orderItems as total_sold' => function($query) {
                $query->selectRaw('sum(quantity)');
            }])
            ->having('total_sold', '>', 0)
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();

        $stats = [
            'total_products' => $totalProducts,
            'active_products' => $activeProducts,
            'products_variation' => $productsVariation,
            
            'total_orders' => $totalOrders,
            'pending_orders' => $pendingOrders,
            'orders_variation' => $ordersVariation,
            
            'total_revenue' => $totalRevenue,
            'total_revenue_variation' => $totalRevenueVariation,
            
            'monthly_revenue' => $monthlyRevenue,
            'monthly_revenue_variation' => $monthlyRevenueVariation,
        ];

        // Commandes récentes (5)
        $recent_orders = Order::with('user')->latest()->take(5)->get();

        // Produits récents (5)
        $recent_products = Product::with('category')->latest()->take(5)->get();

        // Stock faible (5)
        $low_stock = Product::where('stock', '<', 5)
            ->where('stock', '>', 0)
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recent_orders',
            'recent_products',
            'low_stock',
            'last7Days',
            'salesData',
            'topProducts'
        ));
    }

    /**
     * Calculer la variation en pourcentage
     * Limite à +/- 100% pour éviter les valeurs extrêmes
     */
    private function calculateVariation($current, $previous)
    {
        // Si pas de données précédentes
        if ($previous == 0) {
            if ($current == 0) {
                return 0;
            }
            // Nouvelle donnée = +100%
            return 100;
        }

        // Calcul normal
        $variation = (($current - $previous) / $previous) * 100;
        
        // Limiter entre -100% et +100%
        if ($variation > 100) {
            return 100;
        }
        if ($variation < -100) {
            return -100;
        }
        
        return round($variation, 1);
    }
}