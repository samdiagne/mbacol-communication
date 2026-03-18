<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Liste des clients
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'customer')
            ->withCount(['orders', 'reviews'])
            ->withSum('orders as total_spent', 'total');

        // Recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filtre par statut
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->whereNull('deleted_at');
            } elseif ($request->status === 'inactive') {
                $query->onlyTrashed();
            }
        }

        // Tri
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        
        $query->orderBy($sortBy, $sortOrder);

        $clients = $query->paginate(20);

        // Stats
        $stats = [
            'total' => User::where('role', 'customer')->count(),
            'active' => User::where('role', 'customer')->whereNull('deleted_at')->count(),
            'with_orders' => User::where('role', 'customer')
                ->has('orders')
                ->count(),
            'total_revenue' => User::where('role', 'customer')
                ->join('orders', 'users.id', '=', 'orders.user_id')
                ->where('orders.payment_status', 'paid')
                ->sum('orders.total'),
        ];

        return view('admin.clients.index', compact('clients', 'stats'));
    }

    /**
     * Détails d'un client
     */
    public function show($userId)
    {
        // ✅ Inclure les soft deleted
        $user = User::withTrashed()->findOrFail($userId);
        
        if ($user->role !== 'customer') {
            abort(404);
        }

        $user->load([
            'orders' => fn($q) => $q->latest()->take(10),
            'reviews' => fn($q) => $q->latest()->take(5)
        ]);

        $stats = [
            'total_orders' => $user->orders()->count(),
            'total_spent' => $user->orders()->where('payment_status', 'paid')->sum('total'),
            'pending_orders' => $user->orders()->where('status', 'pending')->count(),
            'completed_orders' => $user->orders()->where('status', 'delivered')->count(),
            'total_reviews' => $user->reviews()->count(),
            'avg_rating' => $user->reviews()->avg('rating'),
        ];

        return view('admin.clients.show', compact('user', 'stats'));
    }

    /**
     * Activer/Désactiver un client
     */
    public function toggleStatus($userId)
    {
        // ✅ Chercher le user même s'il est soft deleted
        $user = User::withTrashed()->findOrFail($userId);
        
        if ($user->role !== 'customer') {
            abort(404);
        }

        if ($user->trashed()) {
            $user->restore();
            $message = 'Client réactivé avec succès';
        } else {
            $user->delete();
            $message = 'Client désactivé avec succès';
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Supprimer définitivement un client
     */
    public function destroy(User $user)
    {
        if ($user->role !== 'customer') {
            abort(404);
        }

        // Vérifier s'il a des commandes
        if ($user->orders()->count() > 0) {
            return redirect()->back()->with('error', 'Impossible de supprimer un client avec des commandes');
        }

        $user->forceDelete();

        return redirect()->route('admin.clients.index')
            ->with('success', 'Client supprimé définitivement');
    }
}