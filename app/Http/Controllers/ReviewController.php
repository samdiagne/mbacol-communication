<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour laisser un avis.');
        }

        // Vérifier si l'utilisateur a déjà laissé un avis
        $existingReview = Review::where('user_id', Auth::id())
                                ->where('product_id', $product->id)
                                ->first();

        if ($existingReview) {
            return back()->with('error', 'Vous avez déjà laissé un avis pour ce produit.');
        }

        // Validation
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
        ], [
            'rating.required' => 'Veuillez sélectionner une note.',
            'rating.min' => 'La note doit être comprise entre 1 et 5.',
            'rating.max' => 'La note doit être comprise entre 1 et 5.',
            'comment.required' => 'Le commentaire est obligatoire.',
            'comment.min' => 'Le commentaire doit contenir au moins 10 caractères.',
            'comment.max' => 'Le commentaire ne peut pas dépasser 1000 caractères.',
        ]);

        // Créer l'avis
        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'is_approved' => false, // En attente de modération
        ]);

        return back()->with('success', 'Votre avis a été soumis et sera publié après validation par notre équipe.');
    }
}