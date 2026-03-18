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
        $query = User::where('role', 'admin');

        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        $admins = $query->orderBy('name')->paginate(10);

        $stats = [
            'total' => User::where('role', 'admin')->count(),
            'active' => User::where('role', 'admin')->count(), // On n'utilise plus status
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
    public function toggleStatus(User $user)
    {
        if ($user->trashed()) {
            $user->restore(); // Réactive
        } else {
            $user->delete(); // Désactive
        }

        return redirect()->back()->with('success', 'Statut mis à jour');
    }
}