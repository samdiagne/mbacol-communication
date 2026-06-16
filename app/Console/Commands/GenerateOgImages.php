<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class GenerateOgImages extends Command
{
    protected $signature = 'products:generate-og-images';
    protected $description = 'Generate JPEG OG images (1200x630) for existing products that only have WebP';

    public function handle(): int
    {
        $imageManager = new ImageManager(new Driver());

        $products = Product::whereNotNull('main_image')
            ->where('main_image', 'like', '%.webp')
            ->get();

        $generated = 0;
        $skipped = 0;

        foreach ($products as $product) {
            $ogPath = str_replace('.webp', '_og.jpg', $product->main_image);

            if (Storage::disk('public')->exists($ogPath)) {
                $skipped++;
                continue;
            }

            $sourcePath = Storage::disk('public')->path($product->main_image);

            if (!file_exists($sourcePath)) {
                $this->warn("Missing source: {$product->main_image}");
                continue;
            }

            try {
                $img = $imageManager->read($sourcePath);
                $img->cover(1200, 630);

                Storage::disk('public')->put($ogPath, $img->toJpeg(85));

                $generated++;
                $this->info("Generated: {$ogPath}");
            } catch (\Exception $e) {
                $this->error("Failed {$product->main_image}: {$e->getMessage()}");
            }
        }

        $this->info("Done. Generated: {$generated}, Skipped (already exist): {$skipped}");

        return self::SUCCESS;
    }
}
