<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;

class HomeController extends Controller
{
    public function index()
    {
        // SEO Meta Tags
        SEOMeta::setTitle('Accueil - Électronique & Informatique au Sénégal')
            ->setDescription('Découvrez notre large gamme de smartphones, ordinateurs, tablettes et accessoires. Livraison rapide à Dakar. Paiement sécurisé Wave et Orange Money.')
            ->setKeywords(['électronique Sénégal', 'smartphone Dakar', 'ordinateur portable Sénégal', 'boutique informatique Dakar', 'Mbacol Communication'])
            ->setCanonical(route('home'))
            ->addMeta('robots', 'index, follow')
            ->addMeta('revisit-after', '7 days')
            ->addMeta('author', 'Mbacol Communication');

        // Open Graph
        OpenGraph::setTitle('Mbacol Communication - Votre Boutique Tech au Sénégal')
            ->setDescription('Smartphones, ordinateurs, accessoires. Prix compétitifs, livraison rapide à Dakar.')
            ->setUrl(route('home'))
            ->setType('website')
            ->addImage(asset('images/og-home.jpg'), ['height' => 630, 'width' => 1200]);

        // Twitter Card
        TwitterCard::setTitle('Mbacol Communication - Tech au Sénégal')
            ->setDescription('Smartphones, ordinateurs, accessoires. Livraison Dakar.')
            ->setType('summary_large_image')
            ->setImage(asset('images/twitter-home.jpg'))
            ->setSite('@MbacolComm');

        // JSON-LD Organization
        JsonLd::setTitle('Mbacol Communication')
            ->setDescription('Boutique d\'électronique et informatique au Sénégal')
            ->setType('Store')
            ->addValue('address', [
                '@type' => 'PostalAddress',
                'streetAddress' => 'Rue Amadou Lausane Ndoye x Mousse Diop',
                'addressLocality' => 'Dakar',
                'addressRegion' => 'Dakar',
                'addressCountry' => 'SN'
            ])
            ->addValue('telephone', '+221784465192')
            ->addValue('priceRange', '$$')
            ->addValue('openingHours', 'Mo-Sa 08:00-20:00')
            ->setUrl(route('home'));

        $categories = Category::withCount('products')
            ->orderBy('name')
            ->get();

        $featuredProducts = Product::with(['category', 'images'])
            ->where('is_featured', true)
            ->where('stock', '>', 0)
            ->latest()
            ->take(6)
            ->get();

        $reviews = Review::with(['user', 'product'])
            ->approved()
            ->latest()
            ->take(12)
            ->get();

        return view('home', compact('categories', 'featuredProducts', 'reviews'));
    }
}