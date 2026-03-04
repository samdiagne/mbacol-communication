<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartPage extends Component
{
    public function incrementQuantity($cartItemId)
    {
        $cartItem = CartItem::find($cartItemId);
        
        if ($cartItem && $cartItem->product && $cartItem->quantity < $cartItem->product->stock) {
            $cartItem->increment('quantity');
        }
        
        // ✅ Refresh complet
        return redirect()->route('cart')->with('navigate', true);
    }

    public function decrementQuantity($cartItemId)
    {
        $cartItem = CartItem::find($cartItemId);
        
        if ($cartItem && $cartItem->quantity > 1) {
            $cartItem->decrement('quantity');
        }
        
        // ✅ Refresh complet
        return redirect()->route('cart')->with('navigate', true);
    }

    public function removeItem($cartItemId)
    {
        $cartItem = CartItem::find($cartItemId);
        
        if ($cartItem) {
            $productName = $cartItem->product?->name ?? 'Article';
            $cartItem->delete();
            
            session()->flash('success', $productName . ' supprimé du panier');
        }
        
        // ✅ Refresh complet
        return redirect()->route('cart')->with('navigate', true);
    }

    public function clearCart()
    {
        $count = 0;
        
        if (Auth::check()) {
            $count = CartItem::where('user_id', Auth::id())->count();
            CartItem::where('user_id', Auth::id())->delete();
        } else {
            $count = CartItem::where('session_id', session()->getId())->count();
            CartItem::where('session_id', session()->getId())->delete();
        }
        
        session()->flash('success', "$count article(s) supprimé(s)");
        
        // ✅ Refresh complet
        return redirect()->route('cart')->with('navigate', true);
    }

    public function render()
    {
        $query = CartItem::with('product.category');

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('session_id', session()->getId());
        }

        $cartItems = $query->get();
        
        $subtotal = $cartItems->sum(function ($item) {
            return $item->quantity * $item->price;
        });
        
        return view('livewire.cart-page', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
        ]);
    }
}