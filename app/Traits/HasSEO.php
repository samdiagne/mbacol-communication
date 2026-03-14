<?php

namespace App\Traits;

use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;

trait HasSEO
{
    /**
     * Configurer le SEO pour une catégorie
     */
    public function setSEOForCategory($category)
    {
        // Meta Tags
        SEOMeta::setTitle($category->meta_title ?: $category->name . ' - Mbacol Communication')
            ->setDescription($category->meta_description ?: $category->description)
            ->setKeywords($category->meta_keywords_array)
            ->setCanonical(route('shop', ['category' => $category->slug]))
            ->addMeta('robots', 'index, follow');

        // Open Graph
        OpenGraph::setTitle($category->meta_title ?: $category->name)
            ->setDescription($category->meta_description ?: $category->description)
            ->setUrl(route('shop', ['category' => $category->slug]))
            ->setType('website');

        if ($category->image) {
            OpenGraph::addImage(asset('storage/' . $category->image), [
                'height' => 630,
                'width' => 1200
            ]);
        }

        // Twitter Card
        TwitterCard::setTitle($category->meta_title ?: $category->name)
            ->setDescription($category->meta_description ?: $category->description)
            ->setType('summary_large_image');

        if ($category->image) {
            TwitterCard::setImage(asset('storage/' . $category->image));
        }

        // JSON-LD Category Page
        JsonLd::addValues([
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => $category->name,
            'description' => $category->description,
            'url' => route('shop', ['category' => $category->slug]),
        ]);

        // Breadcrumb
        $this->addBreadcrumb([
            ['name' => 'Accueil', 'url' => route('home')],
            ['name' => 'Boutique', 'url' => route('shop')],
            ['name' => $category->name, 'url' => route('shop', ['category' => $category->slug])],
        ]);
    }

    /**
     * Configurer le SEO pour un produit
     */
    public function setSEOForProduct($product)
    {
        $shortDesc = $product->short_description ?: substr(strip_tags($product->description), 0, 160);

        // Meta Tags
        SEOMeta::setTitle($product->name . ' - ' . $product->category->name . ' | Mbacol')
            ->setDescription($shortDesc)
            ->setKeywords([
                $product->name,
                $product->category->name,
                'acheter ' . $product->name . ' Sénégal',
                $product->name . ' Dakar',
                $product->category->name . ' Sénégal',
                'Khouma et Frères',
                'Mbacol Communication'
            ])
            ->setCanonical(route('product.show', $product))
            ->addMeta('product:price:amount', $product->price)
            ->addMeta('product:price:currency', 'XOF');

        // Open Graph Product
        OpenGraph::setTitle($product->name)
            ->setDescription($shortDesc)
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
                'width' => 1200,
                'alt' => $product->name
            ]);
        }

        // Twitter Card
        TwitterCard::setTitle($product->name)
            ->setDescription($shortDesc)
            ->setType('summary_large_image');

        if ($product->main_image) {
            TwitterCard::setImage(asset('storage/' . $product->main_image));
        }

        // JSON-LD Product Schema
        $jsonLd = [
            '@context' => 'https://schema.org/',
            '@type' => 'Product',
            'name' => $product->name,
            'description' => $shortDesc,
            'image' => $product->main_image ? asset('storage/' . $product->main_image) : null,
            'sku' => $product->sku ?? 'PROD-' . $product->id,
            'brand' => [
                '@type' => 'Brand',
                'name' => 'Mbacol Communication - Khouma et Frères'
            ],
            'offers' => [
                '@type' => 'Offer',
                'url' => route('product.show', $product),
                'priceCurrency' => 'XOF',
                'price' => $product->price,
                'availability' => $product->stock > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
                'seller' => [
                    '@type' => 'Organization',
                    'name' => 'Mbacol Communication',
                    'alternateName' => 'Khouma et Frères'
                ]
            ]
        ];

        // Ajouter les avis si disponibles
        if ($product->reviews && $product->reviews->count() > 0) {
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

        // Breadcrumb
        $this->addBreadcrumb([
            ['name' => 'Accueil', 'url' => route('home')],
            ['name' => 'Boutique', 'url' => route('shop')],
            ['name' => $product->category->name, 'url' => route('shop', ['category' => $product->category->slug])],
            ['name' => $product->name, 'url' => route('product.show', $product)],
        ]);
    }

    /**
     * Ajouter un fil d'Ariane (Breadcrumb)
     */
    private function addBreadcrumb(array $items)
    {
        $breadcrumb = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => []
        ];

        foreach ($items as $index => $item) {
            $breadcrumb['itemListElement'][] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $item['name'],
                'item' => $item['url']
            ];
        }

        JsonLd::addValues($breadcrumb);
    }
}