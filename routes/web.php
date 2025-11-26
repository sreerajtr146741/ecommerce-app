<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Public routes
// Route::get('/login', [AuthController::class, 'showLogin']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Protected routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/', [ProductController::class, 'index']); // root = products

    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');

    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});
// Public product detail route
Route::get('/products/{product}', [ProductController::class, 'show'])
    ->name('products.show')
    ->middleware('auth');

Route::get('/edit-profile', [AuthController::class, 'showEditProfile'])
    ->name('edit.profile')
    ->middleware('auth');

Route::patch('/edit-profile', [AuthController::class, 'updateProfile'])
    ->middleware('auth');




Route::put('/update-password', [ProfileController::class, 'updatePassword']);
