<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\ProfileController;
use App\Livewire\Checkout;
use App\Livewire\CartPage;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;

// Routes publiques
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/boutique', [ShopController::class, 'index'])->name('shop');
Route::get('/produit/{product}', [ShopController::class, 'show'])->name('product.show');

Route::get('/panier', function () {
    return view('cart');
})->name('cart');

// Route checkout (temporaire)
Route::get('/commander', function () {
    return view('checkout');
})->name('checkout');

// Ajoute la route de confirmation (temporaire)
Route::get('/commande/{order}/confirmation', function (\App\Models\Order $order) {
    return view('order-confirmation', compact('order'));
})->name('order.confirmation');

// Autres Routes temporaires
Route::get('/a-propos', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Routes authentifiées (redirection)
Route::middleware('auth')->group(function () {
    // Redirection après connexion
    Route::get('/dashboard', function () {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('home');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes Admin (protégées)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Produits
    Route::resource('products', AdminProductController::class);
    Route::delete('products/{image}/delete-image', [AdminProductController::class, 'deleteImage'])->name('products.delete-image');
    
    // Commandes
    Route::get('orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::patch('orders/{order}/payment', [\App\Http\Controllers\Admin\OrderController::class, 'updatePaymentStatus'])->name('orders.update-payment-status');
});

// Routes client (après auth)
Route::middleware('auth')->prefix('mon-compte')->name('customer.')->group(function () {
    Route::get('commandes', [CustomerOrderController::class, 'index'])->name('orders.index');
    Route::get('commandes/{order}', [CustomerOrderController::class, 'show'])->name('orders.show');
});

require __DIR__.'/auth.php';