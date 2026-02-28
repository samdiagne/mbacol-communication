<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;
use App\Mail\NewOrderAdmin;
use App\Services\Payment\PaymentService;
use App\Models\Payment;

class Checkout extends Component
{
    // Informations client
    public string $customer_name = '';
    public string $customer_email = '';
    public string $customer_phone = '';
    public string $customer_address = '';
    public string $customer_city = 'Dakar';
    
    // Livraison - AJOUT
    public ?string $delivery_zone = null;
    
    // Paiement
    public string $payment_method = 'wave';
    public string $notes = '';
    public $payment_phone;

    // Données panier
    public Collection $cartItems;
    public float $subtotal = 0;
    public float $shippingCost = 0; // Sera calculé dynamiquement
    public float $total = 0;

    // Configuration des zones - AJOUT
    protected array $deliveryZones = [
        'dakar_centre' => 2000,
        'dakar_peripherie' => 2500,
        'banlieue_proche' => 3500,
        'rufisque' => 5000,
    ];

    protected function rules()
    {
        $rules = [
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
            'customer_city' => 'required|string|max:100',
            'delivery_zone' => 'required|in:dakar_centre,dakar_peripherie,banlieue_proche,rufisque', // AJOUT
            'payment_method' => 'required|in:wave,orange_money,cash',
            'notes' => 'nullable|string|max:500',
        ];

        // Si paiement mobile money, le numéro est requis
        if (in_array($this->payment_method, ['wave', 'orange_money'])) {
            $rules['payment_phone'] = 'required|string|digits:9|starts_with:77,78,76,70,75';
        }

        return $rules;
    }

    protected function messages()
    {
        return [
            'customer_name.required' => 'Le nom est obligatoire.',
            'customer_email.required' => 'L\'email est obligatoire.',
            'customer_email.email' => 'L\'email doit être valide.',
            'customer_phone.required' => 'Le téléphone est obligatoire.',
            'customer_address.required' => 'L\'adresse de livraison est obligatoire.',
            'customer_city.required' => 'La ville est obligatoire.',
            'delivery_zone.required' => 'Veuillez sélectionner une zone de livraison.', // AJOUT
            'payment_method.required' => 'Veuillez sélectionner un mode de paiement.',
            'payment_phone.required' => 'Le numéro de téléphone mobile money est obligatoire.',
            'payment_phone.digits' => 'Le numéro doit contenir exactement 9 chiffres.',
            'payment_phone.starts_with' => 'Le numéro doit commencer par 77, 78, 76, 70 ou 75.',
        ];
    }

    public function mount()
    {
        $this->cartItems = collect();
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

    // AJOUT : Calculer le coût de livraison selon la zone
    public function updatedDeliveryZone($value)
    {
        $this->shippingCost = $this->deliveryZones[$value] ?? 0;
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

        try {
            DB::beginTransaction();

            // Créer la commande
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => 'CMD-' . strtoupper(uniqid()),
                'customer_name' => $this->customer_name,
                'customer_email' => $this->customer_email,
                'customer_phone' => $this->customer_phone,
                'customer_address' => $this->customer_address,
                'customer_city' => $this->customer_city,
                'delivery_zone' => $this->delivery_zone, // AJOUT
                'payment_method' => $this->payment_method,
                'payment_status' => 'pending',
                'status' => 'pending',
                'subtotal' => $this->subtotal,
                'shipping_cost' => $this->shippingCost,
                'total' => $this->total,
                'notes' => $this->notes,
            ]);

            // Créer les order items
            foreach ($this->cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                    'total' => $item->quantity * $item->product->price,
                ]);

                // Décrémenter le stock
                $item->product->decrement('stock', $item->quantity);
            }

            // Vider le panier
            if (Auth::check()) {
                CartItem::where('user_id', Auth::id())->delete();
            } else {
                CartItem::where('session_id', session()->getId())->delete();
            }

            DB::commit();

            // Traiter le paiement
            $paymentService = new PaymentService();
            $paymentResult = $paymentService->processPayment($order, $this->payment_phone);

            // Envoyer les emails
            try {
                Mail::to($order->customer_email)->send(new OrderConfirmation($order));
                Mail::to(config('mail.from.address'))->send(new NewOrderAdmin($order));
            } catch (\Exception $e) {
                \Log::error('Email error: ' . $e->getMessage());
            }

            // Redirection selon le résultat du paiement
            if ($paymentResult['success']) {
                if (isset($paymentResult['checkout_url'])) {
                    return redirect($paymentResult['checkout_url']);
                } else {
                    return redirect()->route('order.confirmation', $order);
                }
            } else {
                session()->flash('error', $paymentResult['message'] ?? 'Erreur lors du paiement');
                return redirect()->route('checkout');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Order creation error: ' . $e->getMessage());
            session()->flash('error', 'Une erreur est survenue lors de la commande.');
            return redirect()->route('checkout');
        }
    }

    public function render()
    {
        return view('livewire.checkout');
    }
}