<?php

namespace App\Traits;

use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;

trait HasSEO
{
    private function defaultOgImage(): string
    {
        return asset('images/og-default.jpg');
    }

    private function addOgImage(string $imageUrl): void
    {
        $ogUrl = $this->resolveOgImageUrl($imageUrl);

        OpenGraph::addImage($ogUrl, [
            'width' => 1200,
            'height' => 630,
            'type' => 'image/jpeg',
            'alt' => 'Mbacol Communication - Électronique Pro Sénégal',
        ]);

        TwitterCard::setImage($ogUrl);
    }

    private function resolveOgImageUrl(string $imageUrl): string
    {
        if (!str_ends_with($imageUrl, '.webp')) {
            return $imageUrl;
        }

        $ogPath = str_replace('.webp', '_og.jpg', $imageUrl);
        $relativePath = preg_replace('#^.*/storage/#', '', $ogPath);

        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($relativePath)) {
            return asset('storage/' . $relativePath);
        }

        return $this->defaultOgImage();
    }

    public function setDefaultSocialTags(string $title, string $description, string $url, ?string $image = null): void
    {
        $ogImage = $image ?: $this->defaultOgImage();

        OpenGraph::setTitle($title)
            ->setDescription($description)
            ->setUrl($url)
            ->setType('website')
            ->setSiteName('Mbacol Communication');

        $this->addOgImage($ogImage);

        TwitterCard::setTitle($title)
            ->setDescription($description)
            ->setType('summary_large_image')
            ->setImage($ogImage);
    }

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

        // Open Graph + Twitter Card
        $ogImage = $category->image ? asset('storage/' . $category->image) : null;
        $this->setDefaultSocialTags(
            $category->meta_title ?: $category->name,
            $category->meta_description ?: $category->description,
            route('shop', ['category' => $category->slug]),
            $ogImage
        );

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
        $metaDesc = $product->meta_description
            ?: ($product->short_description ?: substr(strip_tags($product->description), 0, 160));

        $metaTitle = $product->meta_title
            ?: ($product->name . ' - ' . $product->category->name . ' | Mbacol');

        $keywords = $product->meta_keywords
            ? array_map('trim', explode(',', $product->meta_keywords))
            : [
                $product->name,
                $product->category->name,
                'acheter ' . $product->name . ' Sénégal',
                $product->name . ' Dakar',
                $product->category->name . ' Sénégal',
                'Khouma et Frères',
                'Mbacol Communication',
            ];

        // Meta Tags
        SEOMeta::setTitle($metaTitle)
            ->setDescription($metaDesc)
            ->setKeywords($keywords)
            ->setCanonical(route('product.show', $product))
            ->addMeta('product:price:amount', $product->price)
            ->addMeta('product:price:currency', 'XOF');

        // Open Graph Product
        $ogImage = $product->main_image ? asset('storage/' . $product->main_image) : $this->defaultOgImage();

        $ogTitle = $product->meta_title
            ? ($product->meta_title . ' | ' . $product->formatted_price)
            : ($product->name . ' | ' . $product->formatted_price);

        OpenGraph::setTitle($ogTitle)
            ->setDescription($metaDesc)
            ->setUrl(route('product.show', $product))
            ->setType('product')
            ->setSiteName('Mbacol Communication')
            ->addProperty('product:price:amount', $product->price)
            ->addProperty('product:price:currency', 'XOF')
            ->addProperty('product:availability', $product->stock > 0 ? 'in stock' : 'out of stock')
            ->addProperty('product:condition', 'new')
            ->addProperty('product:retailer_item_id', $product->id);

        $this->addOgImage($ogImage);

        // Twitter Card
        TwitterCard::setTitle($ogTitle)
            ->setDescription($metaDesc)
            ->setType('summary_large_image');

        // JSON-LD Product Schema
        $jsonLd = [
            '@context' => 'https://schema.org/',
            '@type' => 'Product',
            'name' => $product->name,
            'description' => $metaDesc,
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