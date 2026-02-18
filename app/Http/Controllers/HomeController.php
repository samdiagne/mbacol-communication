<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')
            ->orderBy('name')
            ->get();

        $featuredProducts = Product::with(['category', 'images'])
            ->where('is_featured', true)
            ->where('stock', '>', 0)
            ->latest()
            ->take(6)
            ->get();

        // 🆕 Récupérer les avis approuvés avec les relations
        $reviews = Review::with(['user', 'product'])
            ->approved()
            ->latest()
            ->take(12) // Prendre plus d'avis pour le carousel
            ->get();

        return view('home', compact('categories', 'featuredProducts', 'reviews'));
    }
}