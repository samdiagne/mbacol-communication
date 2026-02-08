<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class Checkout extends Component
{
    // Informations client
    public string $customer_name = '';
    public string $customer_email = '';
    public string $customer_phone = '';
    public string $customer_address = '';
    public string $customer_city = 'Dakar';
    
    // Paiement
    public string $payment_method = 'wave';
    public string $notes = '';
    
    // Données panier
    public Collection $cartItems;
    public float $subtotal = 0;
    public float $shippingCost = 2000;
    public float $total = 0;

    protected $rules = [
        'customer_name' => 'required|string|min:3|max:255',
        'customer_email' => 'required|email|max:255',
        'customer_phone' => 'required|string|min:9|max:20',
        'customer_address' => 'required|string|min:10',
        'customer_city' => 'required|string',
        'payment_method' => 'required|in:wave,orange_money,free_money,cash',
    ];

    protected $messages = [
        'customer_name.required' => 'Veuillez entrer votre nom complet',
        'customer_name.min' => 'Le nom doit contenir au moins 3 caractères',
        'customer_email.required' => 'Veuillez entrer votre email',
        'customer_email.email' => 'Email invalide',
        'customer_phone.required' => 'Veuillez entrer votre numéro de téléphone',
        'customer_phone.min' => 'Numéro de téléphone invalide',
        'customer_address.required' => 'Veuillez entrer votre adresse de livraison',
        'customer_address.min' => 'Adresse trop courte',
        'customer_city.required' => 'Veuillez sélectionner une ville',
    ];

    public function mount()
    {
        $this->cartItems = collect(); // Initialiser comme Collection vide
        $this->loadCart();
        
        // Pré-remplir si connecté
        if (Auth::check()) {
            $this->customer_name = Auth::user()->name;
            $this->customer_email = Auth::user()->email;
        }
    }

    public function loadCart()
    {
        $query = CartItem::with('product');

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('session_id', session()->getId());
        }

        $this->cartItems = $query->get();
        
        // Rediriger si panier vide
        if ($this->cartItems->isEmpty()) {
            return redirect()->route('cart');
        }

        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        $this->subtotal = $this->cartItems->sum(function ($item) {
            return $item->quantity * $item->price;
        });

        $this->total = $this->subtotal + $this->shippingCost;
    }

    public function placeOrder()
    {
        $this->validate();

        // Vérifier que le panier n'est pas vide
        if ($this->cartItems->isEmpty()) {
            session()->flash('error', 'Votre panier est vide');
            return redirect()->route('cart');
        }

        DB::beginTransaction();

        try {
            // Créer la commande
            $order = Order::create([
                'user_id' => Auth::id(),
                'customer_name' => $this->customer_name,
                'customer_email' => $this->customer_email,
                'customer_phone' => $this->customer_phone,
                'customer_address' => $this->customer_address,
                'customer_city' => $this->customer_city,
                'subtotal' => $this->subtotal,
                'shipping_cost' => $this->shippingCost,
                'total' => $this->total,
                'payment_method' => $this->payment_method,
                'payment_status' => 'pending',
                'status' => 'pending',
                'notes' => $this->notes,
            ]);

            // Créer les items de commande
            foreach ($this->cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'product_name' => $cartItem->product->name,
                    'price' => $cartItem->price,
                    'quantity' => $cartItem->quantity,
                    'total' => $cartItem->quantity * $cartItem->price,
                ]);

                // Décrémenter le stock
                $cartItem->product->decrement('stock', $cartItem->quantity);
            }

            // Vider le panier
            if (Auth::check()) {
                CartItem::where('user_id', Auth::id())->delete();
            } else {
                CartItem::where('session_id', session()->getId())->delete();
            }

            DB::commit();

            // Rediriger vers la page de confirmation
            return redirect()->route('order.confirmation', $order);

        } catch (\Exception $e) {
            DB::rollBack();
            
            session()->flash('error', 'Une erreur est survenue. Veuillez réessayer.');
            return;
        }
    }

    public function render()
    {
        return view('livewire.checkout');
    }
}