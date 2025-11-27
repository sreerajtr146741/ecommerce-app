<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;

// ===========================================
// ROOT / HOME ROUTE
// ===========================================
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('products.index')
        : redirect()->route('login');
});

// ===========================================
// GUEST ONLY: Login & Register
// ===========================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// ===========================================
// AUTHENTICATED USERS ONLY
// ===========================================
Route::middleware('auth')->group(function () {

    // ULTIMATE LOGOUT — KILLS BACK BUTTON & CACHE FOREVER
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/login')->withHeaders([
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma'        => 'no-cache',
            'Expires'       => '0',
        ]);
    })->name('logout');

    // Products Dashboard
    Route::resource('products', ProductController::class);

    // Profile
    Route::get('/edit-profile', [AuthController::class, 'showEditProfile'])->name('edit.profile');
    Route::patch('/edit-profile', [AuthController::class, 'updateProfile']);

    // CART ROUTES
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // CHECKOUT ROUTES
    Route::get('/checkout', [CheckoutController::class, 'all'])->name('checkout.all');
    Route::get('/checkout/{id}', [CheckoutController::class, 'single'])->name('checkout.single');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');
});

// Optional: Old dashboard redirect
Route::get('/dashboard', fn() => redirect()->route('products.index'))
    ->middleware('auth')
    ->name('dashboard');