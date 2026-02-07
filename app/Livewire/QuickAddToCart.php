<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class QuickAddToCart extends Component
{
    public Product $product;

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function addToCart()
    {
        if ($this->product->stock < 1) {
            return;
        }

        $sessionId = Auth::check() ? null : session()->getId();
        $userId = Auth::id();

        // Vérifier si l'article existe déjà
        $existingItem = CartItem::where('product_id', $this->product->id)
            ->where(function($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->first();

        if ($existingItem) {
            // Mettre à jour la quantité
            $newQuantity = min($existingItem->quantity + 1, $this->product->stock);
            
            $existingItem->update([
                'quantity' => $newQuantity,
                'price' => $this->product->price,
            ]);
        } else {
            // Créer un nouvel article
            CartItem::create([
                'user_id' => $userId,
                'session_id' => $sessionId,
                'product_id' => $this->product->id,
                'quantity' => 1,
                'price' => $this->product->price,
            ]);
        }

        $this->dispatch('cartUpdated');
        $this->dispatch('product-added', name: $this->product->name);
    }

    public function render()
    {
        return view('livewire.quick-add-to-cart');
    }
}