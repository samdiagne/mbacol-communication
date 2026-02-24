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
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\Admin\StatisticsController;





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

Route::get('/a-propos', fn() => view('about'))->name('about');
Route::get('/contact', fn() => view('contact'))->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
Route::get('/cgv', fn() => view('terms'))->name('terms');
Route::get('/faq', [FaqController::class, 'index'])->name('faq');


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

// Reviews Frontend (authentification requise)
Route::middleware('auth')->group(function () {
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

// Reviews Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
    Route::patch('reviews/{review}/approve', [AdminReviewController::class, 'approve'])->name('reviews.approve');
    Route::patch('reviews/{review}/reject', [AdminReviewController::class, 'reject'])->name('reviews.reject');
    Route::delete('reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');

    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics');

});

// Routes client (après auth)
Route::middleware('auth')->prefix('mon-compte')->name('customer.')->group(function () {
    Route::get('commandes', [CustomerOrderController::class, 'index'])->name('orders.index');
    Route::get('commandes/{order}', [CustomerOrderController::class, 'show'])->name('orders.show');
});

// Routes paiement
Route::prefix('payment')->name('payment.')->group(function () {
    // Simulation (sandbox)
    Route::get('simulate/{order}', [PaymentController::class, 'simulate'])->name('simulate');
    Route::post('simulate/{order}/confirm', [PaymentController::class, 'simulateConfirm'])->name('simulate.confirm');
    
    // Callbacks (production)
    Route::get('success/{order}', [PaymentController::class, 'success'])->name('success');
    Route::get('error/{order}', [PaymentController::class, 'error'])->name('error');
    
    // Webhooks (production)
    Route::post('webhook/{provider}', [PaymentController::class, 'webhook'])->name('webhook');
});

require __DIR__.'/auth.php';