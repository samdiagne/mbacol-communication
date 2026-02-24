<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    public function index()
    {
        // Commandes par mois (6 derniers mois seulement)
        $ordersPerMonth = Order::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(total) as revenue')
            )
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        $monthlyLabels = [];
        $monthlyOrdersData = [];
        $monthlyRevenueData = [];

        foreach ($ordersPerMonth as $data) {
            $monthlyLabels[] = Carbon::createFromDate($data->year, $data->month, 1)->format('M Y');
            $monthlyOrdersData[] = $data->count;
            $monthlyRevenueData[] = $data->revenue;
        }

        // Commandes par statut
        $ordersByStatus = Order::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        $statusLabels = [];
        $statusData = [];
        $statusColors = [
            'pending' => '#FCD34D',
            'confirmed' => '#60A5FA',
            'processing' => '#A78BFA',
            'shipped' => '#34D399',
            'delivered' => '#10B981',
            'cancelled' => '#EF4444',
        ];
        $statusBackgroundColors = [];

        foreach ($ordersByStatus as $data) {
            $statusLabels[] = $this->getStatusLabel($data->status);
            $statusData[] = $data->count;
            $statusBackgroundColors[] = $statusColors[$data->status] ?? '#9CA3AF';
        }

        // Top 5 produits
        $topProducts = DB::table('order_items')
            ->select('product_name', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_name')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();

        $topProductsLabels = $topProducts->pluck('product_name')->toArray();
        $topProductsData = $topProducts->pluck('total_sold')->toArray();

        // Stats globales
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total');
        $totalOrders = Order::count();
        $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        return view('admin.statistics', compact(
            'monthlyLabels',
            'monthlyOrdersData',
            'monthlyRevenueData',
            'statusLabels',
            'statusData',
            'statusBackgroundColors',
            'topProductsLabels',
            'topProductsData',
            'totalRevenue',
            'totalOrders',
            'avgOrderValue'
        ));
    }

    private function getStatusLabel($status)
    {
        $labels = [
            'pending' => 'En attente',
            'confirmed' => 'Confirmée',
            'processing' => 'En préparation',
            'shipped' => 'Expédiée',
            'delivered' => 'Livrée',
            'cancelled' => 'Annulée',
        ];

        return $labels[$status] ?? $status;
    }
}