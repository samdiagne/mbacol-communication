<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->where('stock', '>', 0);

        // Filtres
        if ($request->filled('category')) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
                
                // SEO pour catégorie
                SEOMeta::setTitle($category->name . ' - Mbacol Communication')
                    ->setDescription('Découvrez notre sélection de ' . strtolower($category->name) . ' au Sénégal. Prix compétitifs, livraison rapide à Dakar.')
                    ->setKeywords([$category->name . ' Sénégal', $category->name . ' Dakar', 'acheter ' . $category->name])
                    ->setCanonical(route('shop', ['category' => $category->slug]));
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
                ->addMeta('robots', 'noindex, follow'); // Pas d'indexation des pages de recherche
        } else {
            // SEO page boutique générale
            SEOMeta::setTitle('Boutique - Tous nos Produits')
                ->setDescription('Parcourez notre catalogue complet : smartphones, ordinateurs, tablettes, accessoires. Livraison rapide à Dakar.')
                ->setKeywords(['boutique électronique Sénégal', 'acheter smartphone Dakar', 'matériel informatique Sénégal'])
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

        // SEO Meta Tags
        SEOMeta::setTitle($product->name . ' - ' . $product->category->name)
            ->setDescription($product->short_description ?: substr(strip_tags($product->description), 0, 160))
            ->setKeywords([
                $product->name,
                $product->category->name,
                'acheter ' . $product->name . ' Sénégal',
                $product->name . ' Dakar',
                $product->category->name . ' Sénégal'
            ])
            ->setCanonical(route('product.show', $product))
            ->addMeta('product:price:amount', $product->price)
            ->addMeta('product:price:currency', 'XOF');

        // Open Graph Product
        OpenGraph::setTitle($product->name)
            ->setDescription($product->short_description ?: substr(strip_tags($product->description), 0, 160))
            ->setUrl(route('product.show', $product))
            ->setType('product')
            ->addProperty('product:price:amount', $product->price)
            ->addProperty('product:price:currency', 'XOF')
            ->addProperty('product:availability', $product->stock > 0 ? 'in stock' : 'out of stock')
            ->addProperty('product:condition', 'new')
            ->addProperty('product:retailer_item_id', $product->id);

        if ($product->main_image) {
            OpenGraph::addImage(asset('storage/' . $product->main_image), [
                'height' => 630,
                'width' => 1200
            ]);
        }

        // Twitter Card
        TwitterCard::setTitle($product->name)
            ->setDescription($product->short_description ?: substr(strip_tags($product->description), 0, 160))
            ->setType('summary_large_image');

        if ($product->main_image) {
            TwitterCard::setImage(asset('storage/' . $product->main_image));
        }

        // JSON-LD Product Schema
        $jsonLd = [
            '@context' => 'https://schema.org/',
            '@type' => 'Product',
            'name' => $product->name,
            'description' => $product->short_description ?: substr(strip_tags($product->description), 0, 160),
            'image' => $product->main_image ? asset('storage/' . $product->main_image) : null,
            'sku' => $product->sku ?? 'PROD-' . $product->id,
            'brand' => [
                '@type' => 'Brand',
                'name' => 'Mbacol Communication'
            ],
            'offers' => [
                '@type' => 'Offer',
                'url' => route('product.show', $product),
                'priceCurrency' => 'XOF',
                'price' => $product->price,
                'availability' => $product->stock > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
                'seller' => [
                    '@type' => 'Organization',
                    'name' => 'Mbacol Communication'
                ]
            ]
        ];

        // Ajouter les avis si disponibles
        if ($product->reviews->count() > 0) {
            $jsonLd['aggregateRating'] = [
                '@type' => 'AggregateRating',
                'ratingValue' => round($product->average_rating, 1),
                'reviewCount' => $product->reviews->count(),
                'bestRating' => 5,
                'worstRating' => 1
            ];

            $jsonLd['review'] = $product->reviews->take(5)->map(function($review) {
                return [
                    '@type' => 'Review',
                    'author' => [
                        '@type' => 'Person',
                        'name' => $review->user->name
                    ],
                    'datePublished' => $review->created_at->toIso8601String(),
                    'reviewBody' => $review->comment,
                    'reviewRating' => [
                        '@type' => 'Rating',
                        'ratingValue' => $review->rating,
                        'bestRating' => 5,
                        'worstRating' => 1
                    ]
                ];
            })->toArray();
        }

        JsonLd::addValues($jsonLd);

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