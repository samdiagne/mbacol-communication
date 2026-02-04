<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class AddToCart extends Component
{
    public Product $product;
    public int $quantity = 1;
    public bool $showNotification = false;

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function increment()
    {
        if ($this->quantity < $this->product->stock) {
            $this->quantity++;
        }
    }

    public function decrement()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function addToCart()
    {
        if ($this->product->stock < $this->quantity) {
            $this->dispatch('notification', [
                'type' => 'error',
                'message' => 'Stock insuffisant'
            ]);
            return;
        }

        // IMPORTANT : S'assurer que session_id est défini
        if (!Auth::check() && !session()->has('_token')) {
            session()->regenerate();
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
            $newQuantity = $existingItem->quantity + $this->quantity;
            
            if ($newQuantity > $this->product->stock) {
                $newQuantity = $this->product->stock;
            }
            
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
                'quantity' => $this->quantity,
                'price' => $this->product->price,
            ]);
        }

        $this->showNotification = true;
        $this->dispatch('cartUpdated');
        $this->dispatch('hideNotification');
    }

    public function render()
    {
        return view('livewire.add-to-cart');
    }
}