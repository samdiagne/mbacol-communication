<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    // Liste des admins
    public function index(Request $request)
    {
        $query = User::where('role', 'admin')->withTrashed(); // Inclut les supprimés

        // Filtre par recherche
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        // Filtre par statut
        if ($request->has('status') && $request->status) {
            if ($request->status === 'active') {
                $query->whereNull('deleted_at');
            } elseif ($request->status === 'inactive') {
                $query->whereNotNull('deleted_at');
            }
        }

        $admins = $query->orderBy('name')->paginate(10);

        $stats = [
            'total' => User::where('role', 'admin')->count(),
            'active' => User::where('role', 'admin')->whereNull('deleted_at')->count(),
            'inactive' => User::where('role', 'admin')->whereNotNull('deleted_at')->count(),
        ];

        return view('admin.team.index', compact('admins', 'stats'));
    }

    // Formulaire création
    public function create()
    {
        return view('admin.team.create');
    }

    // Stockage d'un nouvel admin
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'admin', // ✅ on force le rôle admin
        ]);

        return redirect()->route('admin.team.index')->with('success', 'Admin ajouté avec succès');
    }

    // Activer/Désactiver admin
    public function toggleStatus($id)
    {
        // Inclut les soft-deleted
        $user = User::withTrashed()->findOrFail($id);

        if ($user->trashed()) {
            $user->restore();
        } else {
            $user->delete();
        }

        return redirect()->back()->with('success', 'Statut mis à jour');
    }
}