<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login_action', [AuthController::class, 'login_action'])->name('login_action');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'register_action'])->name('register_action');
});

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('role:admin')->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('payments', [PaymentsController::class, 'index'])->name('payments');

        Route::prefix('managements')
            ->name('managements.')
            ->group(function () {
                // Categories
                Route::resource('categories', CategoriesController::class);
                // Products
                Route::resource('products', ProductsController::class)->except(['show']);
                Route::patch('products/{product}/restock', [ProductsController::class, 'restock'])->name('products.restock');
                // Orders
                Route::get('orders', [OrdersController::class, 'index'])->name('orders.index');
                Route::patch('orders/{order}/update-status', [OrdersController::class, 'updateStatus'])->name('orders.updateStatus');
            });
        Route::patch('/orders/{order}/cancel', [OrdersController::class, 'cancelByUser'])->name('orders.cancelByUser');
    });

    Route::prefix('profile')
        ->name('profile.')
        ->group(function () {
            Route::get('/', [ProfileController::class, 'index'])->name('index');
            Route::put('/', [ProfileController::class, 'update'])->name('update');
            Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password');
        });

    Route::prefix('cart')
        ->name('cart.')
        ->group(function () {
            Route::get('/', [CartController::class, 'index'])->name('index');
            Route::post('/add', [CartController::class, 'add'])->name('add');
            Route::patch('/update/{productId}', [CartController::class, 'update'])->name('update');
            Route::delete('/remove/{productId}', [CartController::class, 'remove'])->name('remove');
            Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
        });
    Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
});
