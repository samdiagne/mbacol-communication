<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Product extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'short_description',
        'price',
        'old_price',
        'stock',
        'sku',
        'main_image',
        'is_featured',
        'is_active',
        'views',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'old_price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Relation : Un produit appartient à une catégorie
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relation : Un produit a plusieurs images
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('order');
    }

    /**
     * Relation : Un produit a plusieurs items de commande
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Scope : Seulement les produits actifs
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope : Produits en vedette
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope : Produits en stock
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Accessor : Prix formaté
     */
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 0, ',', ' ') . ' FCFA';
    }

    /**
     * Accessor : Ancien prix formaté
     */
    public function getFormattedOldPriceAttribute()
    {
        return $this->old_price ? number_format($this->old_price, 0, ',', ' ') . ' FCFA' : null;
    }

    /**
     * Accessor : Réduction en pourcentage
     */
    public function getDiscountPercentageAttribute()
    {
        if (!$this->old_price || $this->old_price <= $this->price) {
            return 0;
        }
        
        return round((($this->old_price - $this->price) / $this->old_price) * 100);
    }

    /**
     * Vérifier si le produit est en stock
     */
    public function isInStock(): bool
    {
        return $this->stock > 0;
    }

    /**
     * Incrémenter les vues
     */
    public function incrementViews()
    {
        $this->increment('views');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews()
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    // Moyenne des notes
    public function getAverageRatingAttribute()
    {
        return $this->approvedReviews()->avg('rating') ?? 0;
    }

    // Nombre d'avis
    public function getReviewsCountAttribute()
    {
        return $this->approvedReviews()->count();
    }
}