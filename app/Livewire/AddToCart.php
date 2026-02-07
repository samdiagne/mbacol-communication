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

    /**
     * Incrémenter la quantité LOCALE (pas dans le panier)
     */
    public function increment()
    {
        if ($this->quantity < $this->product->stock) {
            $this->quantity++;
        }
    }

    /**
     * Décrémenter la quantité LOCALE (pas dans le panier)
     */
    public function decrement()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    /**
     * Ajouter au panier avec la quantité choisie
     */
    public function addToCart()
    {
        if ($this->product->stock < $this->quantity) {
            return;
        }

        $sessionId = Auth::check() ? null : session()->getId();
        $userId = Auth::id();

        // Vérifier si l'article existe déjà dans le panier
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
            // Ajouter la quantité sélectionnée à l'existante
            $newQuantity = $existingItem->quantity + $this->quantity;
            
            if ($newQuantity > $this->product->stock) {
                $newQuantity = $this->product->stock;
            }
            
            $existingItem->update([
                'quantity' => $newQuantity,
                'price' => $this->product->price,
            ]);
        } else {
            // Créer avec la quantité sélectionnée
            CartItem::create([
                'user_id' => $userId,
                'session_id' => $sessionId,
                'product_id' => $this->product->id,
                'quantity' => $this->quantity,
                'price' => $this->product->price,
            ]);
        }

        // Afficher la notification
        $this->showNotification = true;
        
        // Réinitialiser la quantité à 1 après ajout
        $this->quantity = 1;
        
        // Mettre à jour l'icône panier
        $this->dispatch('cartUpdated');
        
        // Masquer la notification après 3 secondes
        $this->js('setTimeout(() => $wire.showNotification = false, 3000)');
    }

    public function render()
    {
        return view('livewire.add-to-cart');
    }
}