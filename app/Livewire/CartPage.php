<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class CartPage extends Component
{
    public Collection $cartItems;
    public array $quantities = [];
    public float $subtotal = 0;
    public float $shippingCost = 2000;
    public float $total = 0;

    protected $listeners = ['cartUpdated' => 'loadCart'];

    public function mount()
    {
        $this->cartItems = collect();
        $this->loadCart();
    }

    public function loadCart()
    {
        $query = CartItem::with('product.category');

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('session_id', session()->getId());
        }

        $this->cartItems = $query->get();
        $this->syncQuantities();
        $this->calculateTotals();
    }

    public function syncQuantities()
    {
        $this->quantities = [];
        foreach ($this->cartItems as $item) {
            $this->quantities[$item->id] = $item->quantity;
        }
    }

    public function incrementQuantity($cartItemId)
    {
        $cartItem = CartItem::find($cartItemId);
        
        if ($cartItem && $cartItem->quantity < $cartItem->product->stock) {
            $cartItem->increment('quantity');
            $this->loadCart();
            $this->dispatch('cartUpdated');
        }
    }

    public function decrementQuantity($cartItemId)
    {
        $cartItem = CartItem::find($cartItemId);
        
        if ($cartItem && $cartItem->quantity > 1) {
            $cartItem->decrement('quantity');
            $this->loadCart();
            $this->dispatch('cartUpdated');
        }
    }

    public function removeItem($cartItemId)
    {
        CartItem::find($cartItemId)?->delete();
        $this->loadCart();
        $this->dispatch('cartUpdated');
    }

    public function clearCart()
    {
        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())->delete();
        } else {
            CartItem::where('session_id', session()->getId())->delete();
        }

        $this->loadCart();
        $this->dispatch('cartUpdated');
    }

    private function calculateTotals()
    {
        $this->subtotal = $this->cartItems->sum(function ($item) {
            return $item->quantity * $item->price;
        });

        $this->total = $this->subtotal + ($this->cartItems->count() > 0 ? $this->shippingCost : 0);
    }

    public function render()
    {
        return view('livewire.cart-page');
    }
}