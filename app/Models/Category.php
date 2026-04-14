<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Category extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'long_tail_keywords',
    ];

    
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate(); // Ne pas casser les URLs existantes
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
    
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Obtenir les keywords comme array
     */
    public function getMetaKeywordsArrayAttribute()
    {
        return $this->meta_keywords 
            ? array_map('trim', explode(',', $this->meta_keywords)) 
            : [];
    }

    /**
     * Obtenir les long-tail keywords comme array
     */
    public function getLongTailKeywordsArrayAttribute()
    {
        return $this->long_tail_keywords 
            ? array_map('trim', explode(',', $this->long_tail_keywords)) 
            : [];
    }
}