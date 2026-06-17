<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Review;

class TrashController extends Controller
{
    public function index()
    {
        $products = Product::onlyTrashed()->with('category')->latest('deleted_at')->get();
        $categories = Category::onlyTrashed()->latest('deleted_at')->get();
        $reviews = Review::onlyTrashed()->with(['user', 'product'])->latest('deleted_at')->get();

        $totalTrashed = $products->count() + $categories->count() + $reviews->count();

        return view('admin.trash.index', compact('products', 'categories', 'reviews', 'totalTrashed'));
    }
}
