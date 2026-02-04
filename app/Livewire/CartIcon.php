<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartIcon extends Component
{
    public $cartCount = 0;

    protected $listeners = ['cartUpdated' => 'updateCartCount'];

    public function mount()
    {
        $this->updateCartCount();
    }

    public function updateCartCount()
    {
        if (Auth::check()) {
            $this->cartCount = CartItem::where('user_id', Auth::id())->sum('quantity');
        } else {
            $this->cartCount = CartItem::where('session_id', session()->getId())->sum('quantity');
        }
    }

    public function render()
    {
        return view('livewire.cart-icon');
    }
}