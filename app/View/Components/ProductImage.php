<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class ProductImage extends Component
{
    public string $src;
    public string $alt;
    public string $class;
    public ?string $title;
    public string $loading;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $src,
        mixed $product = null,
        ?string $alt = null,
        string $class = '',
        ?string $title = null,
        string $loading = 'lazy'
    ) {
        $this->src = $src;
        $this->class = $class;
        $this->loading = $loading;

        // Générer alt text intelligent
        if ($alt) {
            $this->alt = $alt;
        } elseif ($product) {
            $this->alt = $this->generateAlt($product);
        } else {
            $this->alt = 'Image produit - Mbacol Communication';
        }

        // Générer title
        if ($title) {
            $this->title = $title;
        } elseif ($product && is_object($product)) {
            $this->title = $product->name;
        } else {
            $this->title = null;
        }
    }

    /**
     * Génère un alt text SEO optimisé
     */
    private function generateAlt(mixed $product): string
    {
        // Si c'est juste une string
        if (is_string($product)) {
            return $product . ' - Mbacol Communication Sénégal';
        }

        // Si c'est un objet Product
        if (is_object($product)) {
            $parts = [$product->name];
            
            // Ajouter la catégorie si disponible
            if (isset($product->category) && $product->category) {
                $parts[] = $product->category->name;
            }
            
            // Ajouter le prix si disponible (bon pour SEO)
            if (isset($product->formatted_price)) {
                $parts[] = $product->formatted_price;
            }
            
            $parts[] = 'Mbacol Communication Sénégal';
            
            return implode(' - ', $parts);
        }
        
        return 'Produit - Mbacol Communication Sénégal';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.product-image');
    }
}