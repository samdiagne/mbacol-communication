<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Traits\HasSEO;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOMeta;

class ShopController extends Controller
{
    use HasSEO;

    public function index(Request $request)
    {
        $query = Product::with('category')->where('stock', '>', 0);

        // Filtres
        if ($request->filled('category')) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
                
                // ✅ SEO automatique via le trait
                $this->setSEOForCategory($category);
            }
        } elseif ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
            
            // SEO pour recherche
            SEOMeta::setTitle('Recherche : ' . $searchTerm . ' - Mbacol Communication')
                ->setDescription('Résultats de recherche pour "' . $searchTerm . '" sur Mbacol Communication.')
                ->addMeta('robots', 'noindex, follow');
        } else {
            // SEO page boutique générale
            SEOMeta::setTitle('Boutique Électronique Professionnelle - Mbacol | Khouma et Frères')
                ->setDescription('Import/Export matériel électronique professionnel : chargeurs, stations soudage, microscopes, outils réparation. Livraison Dakar, Sénégal.')
                ->setKeywords([
                    'matériel électronique professionnel Sénégal',
                    'station soudage Dakar',
                    'microscope réparation téléphone',
                    'outils réparation smartphone Dakar',
                    'chargeur GaN Sénégal',
                    'Khouma et Frères',
                    'Mbacol Communication'
                ])
                ->setCanonical(route('shop'));
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'name':
                    $query->orderBy('name', 'asc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::withCount('products')->get();

        return view('shop', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        $product->load(['category', 'images', 'reviews.user']);

        // ✅ SEO automatique via le trait
        $this->setSEOForProduct($product);

        // Produits similaires
        $relatedProducts = Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('stock', '>', 0)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('product', compact('product', 'relatedProducts'));
    }
}