<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('items')
            ->latest()
            ->paginate(10);
        
        return view('customer.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Vérifier que c'est bien sa commande
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('items.product');
        
        return view('customer.orders.show', compact('order'));
    }
}