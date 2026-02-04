<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ProductController extends Controller
{
    private ImageManager $imageManager;

    public function __construct()
    {
        // Initialiser une seule fois
        $this->imageManager = new ImageManager(new Driver());
    }

    /**
     * Upload et optimise une image
     */
    private function uploadImage($imageFile, string $prefix = ''): string
    {
        try {
            $filename = time() . $prefix . uniqid() . '.webp';
            
            $img = $this->imageManager->read($imageFile->getPathname());
            $img->scale(width: 800);
            
            Storage::disk('public')->put(
                'products/' . $filename,
                $img->toWebp(80)
            );
            
            return 'products/' . $filename;
        } catch (\Exception $e) {
            \Log::error('Image upload failed: ' . $e->getMessage());
            throw new \Exception('Erreur lors de l\'upload de l\'image');
        }
    }

    public function index(Request $request)
    {
        $query = Product::with('category')->latest();

        // Filtres
        if ($request->filter === 'active') {
            $query->active();
        } elseif ($request->filter === 'inactive') {
            $query->where('is_active', false);
        } elseif ($request->filter === 'out_of_stock') {
            $query->where('stock', 0);
        }

        $products = $query->paginate(20);
        
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::active()->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'nullable|string|unique:products,sku',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Upload image principale
        if ($request->hasFile('main_image')) {
            $validated['main_image'] = $this->uploadImage($request->file('main_image'), '_main_');
        }

        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');

        $product = Product::create($validated);

        // Upload images supplémentaires
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $this->uploadImage($image, "_gallery_{$index}_"),
                    'order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produit créé avec succès !');
    }

    public function edit(Product $product)
    {
        $categories = Category::active()->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'nullable|string|unique:products,sku,' . $product->id,
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Upload nouvelle image principale
        if ($request->hasFile('main_image')) {
            // Supprimer ancienne image
            if ($product->main_image) {
                Storage::disk('public')->delete($product->main_image);
            }

            $validated['main_image'] = $this->uploadImage($request->file('main_image'), '_main_');
        }

        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');

        $product->update($validated);

        // Upload nouvelles images supplémentaires
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $this->uploadImage($image, "_gallery_{$index}_"),
                    'order' => $product->images()->max('order') + 1 + $index,
                ]);
            }
        }

        return redirect()->route('admin.products.edit', $product)
            ->with('success', 'Produit mis à jour avec succès !');
    }

    public function destroy(Product $product)
    {
        // Supprimer images
        if ($product->main_image) {
            Storage::disk('public')->delete($product->main_image);
        }

        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produit supprimé avec succès !');
    }

    public function deleteImage(ProductImage $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return back()->with('success', 'Image supprimée avec succès !');
    }
}