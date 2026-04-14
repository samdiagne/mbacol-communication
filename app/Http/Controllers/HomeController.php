<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;

class HomeController extends Controller
{
    public function index()
    {
        // ✅ SEO amélioré avec les vraies infos
        SEOMeta::setTitle('Mbacol Communication - Khouma et Frères | Import/Export Électronique Sénégal')
            ->setDescription('Import/Export matériel électronique professionnel : chargeurs GaN, stations soudage, microscopes, outils réparation smartphone. Livraison rapide Dakar, Sénégal.')
            ->setKeywords([
                'Mbacol Communication',
                'Khouma et Frères',
                'import export électronique Sénégal',
                'matériel réparation téléphone Dakar',
                'station soudage professionnel',
                'microscope réparation smartphone',
                'chargeur GaN USB-C Dakar',
                'outils réparation électronique Sénégal',
                'pièces détachées téléphone Dakar'
            ])
            ->setCanonical(route('home'))
            ->addMeta('robots', 'index, follow')
            ->addMeta('revisit-after', '7 days')
            ->addMeta('author', 'Mbacol Communication - Khouma et Frères');

        // Open Graph
        OpenGraph::setTitle('Mbacol Communication - Khouma et Frères | Électronique Pro Sénégal')
            ->setDescription('Import/Export matériel électronique professionnel. Chargeurs, stations soudage, microscopes. Livraison Dakar.')
            ->setUrl(route('home'))
            ->setType('website')
            ->addImage(asset('images/og-home.jpg'), ['height' => 630, 'width' => 1200])
            ->addImage(asset('images/logo.webp')); // Fallback si og-home.jpg absent

        // Twitter Card
        TwitterCard::setTitle('Mbacol Communication - Électronique Pro Sénégal')
            ->setDescription('Import/Export matériel professionnel. Livraison Dakar.')
            ->setType('summary_large_image')
            ->setImage(asset('images/twitter-home.jpg') ?: asset('images/logo.webp'));

        // ✅ JSON-LD Organization amélioré
        JsonLd::addValues([
            '@context' => 'https://schema.org',
            '@type' => 'Store',
            'name' => 'Mbacol Communication',
            'alternateName' => 'Khouma et Frères',
            'description' => 'Import/Export matériel électronique professionnel au Sénégal',
            'url' => route('home'),
            'logo' => asset('images/logo.png'),
            'image' => asset('images/og-home.jpg'),
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => 'Colobane rue 43×45',
                'addressLocality' => 'Dakar',
                'addressRegion' => 'Dakar',
                'addressCountry' => 'SN'
            ],
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'telephone' => '+221-78-446-51-92',
                'contactType' => 'Service client',
                'areaServed' => 'SN',
                'availableLanguage' => ['fr']
            ],
            'priceRange' => '3000 FCFA - 250000 FCFA',
            'openingHours' => 'Mo-Sa 08:00-20:00',
            'paymentAccepted' => ['Wave', 'Orange Money', 'Free Money', 'Carte Bancaire', 'Espèces']
        ]);

        $categories = Category::withCount('products')
            ->orderBy('name')
            ->get();

        $featuredProducts = Product::with(['category', 'images'])
            ->where('is_featured', true)
            ->where('stock', '>', 0)
            ->latest()
            ->take(12)
            ->get();

        $reviews = Review::with(['user', 'product'])
            ->approved()
            ->latest()
            ->take(12)
            ->get();

        return view('home', compact('categories', 'featuredProducts', 'reviews'));
    }
}