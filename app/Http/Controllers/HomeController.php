<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::active()->get();
        $featuredProducts = Product::with('category')
            ->active()
            ->featured()
            ->inStock()
            ->latest()
            ->take(6)
            ->get();

        return view('home', compact('categories', 'featuredProducts'));
    }
}