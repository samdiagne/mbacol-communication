<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Smartphones
            [
                'category_id' => 1,
                'name' => 'iPhone 15 Pro Max',
                'description' => 'Le dernier iPhone avec puce A17 Pro, écran Super Retina XDR de 6,7 pouces et système de caméra avancé.',
                'short_description' => 'iPhone 15 Pro Max 256Go',
                'price' => 850000,
                'old_price' => 950000,
                'stock' => 15,
                'sku' => 'IP15PM-256',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'category_id' => 1,
                'name' => 'Samsung Galaxy S24 Ultra',
                'description' => 'Galaxy S24 Ultra avec écran Dynamic AMOLED 2X, S Pen intégré et caméra 200MP.',
                'short_description' => 'Samsung Galaxy S24 Ultra 512Go',
                'price' => 780000,
                'old_price' => null,
                'stock' => 12,
                'sku' => 'S24U-512',
                'is_featured' => true,
                'is_active' => true,
            ],
            // Ordinateurs
            [
                'category_id' => 2,
                'name' => 'MacBook Pro 14"',
                'description' => 'MacBook Pro avec puce M3 Pro, écran Liquid Retina XDR et autonomie exceptionnelle.',
                'short_description' => 'MacBook Pro 14" M3 Pro',
                'price' => 1200000,
                'old_price' => 1350000,
                'stock' => 8,
                'sku' => 'MBP14-M3',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'category_id' => 2,
                'name' => 'Dell XPS 15',
                'description' => 'PC portable premium avec écran InfinityEdge 4K, processeur Intel Core i7 et carte graphique NVIDIA.',
                'short_description' => 'Dell XPS 15 - i7 32Go RAM',
                'price' => 950000,
                'old_price' => null,
                'stock' => 5,
                'sku' => 'DXPS15-I7',
                'is_featured' => false,
                'is_active' => true,
            ],
            // Accessoires
            [
                'category_id' => 3,
                'name' => 'AirPods Pro 2',
                'description' => 'Écouteurs sans fil avec réduction active du bruit, audio spatial et boîtier de charge MagSafe.',
                'short_description' => 'AirPods Pro 2ème génération',
                'price' => 85000,
                'old_price' => 95000,
                'stock' => 30,
                'sku' => 'APP2-GEN2',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'category_id' => 3,
                'name' => 'Chargeur Rapide 65W',
                'description' => 'Chargeur USB-C 65W compatible avec smartphones, tablettes et ordinateurs portables.',
                'short_description' => 'Chargeur USB-C 65W',
                'price' => 15000,
                'old_price' => null,
                'stock' => 50,
                'sku' => 'CHG-65W',
                'is_featured' => false,
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}