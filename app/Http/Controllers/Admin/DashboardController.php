<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'active_products' => Product::active()->count(),
            'out_of_stock' => Product::where('stock', 0)->count(),
            'total_categories' => Category::count(),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
        ];

        $recent_products = Product::with('category')->latest()->take(5)->get();
        $low_stock = Product::where('stock', '>', 0)->where('stock', '<=', 5)->get();

        return view('admin.dashboard', compact('stats', 'recent_products', 'low_stock'));
    }
}