<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Smartphones',
                'description' => 'Les derniers modèles de smartphones disponibles',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'Ordinateurs',
                'description' => 'Ordinateurs portables et de bureau',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'Accessoires',
                'description' => 'Casques, chargeurs, câbles et plus',
                'is_active' => true,
                'order' => 3,
            ],
            [
                'name' => 'Tablettes',
                'description' => 'Tablettes Android et iOS',
                'is_active' => true,
                'order' => 4,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}