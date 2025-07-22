<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

Route::get('/', [LoginController::class, 'show'])->name('login');


Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');


Route::middleware(['auth:sanctum', 'role:user'])->group(function () {
    Route::get('/showcase', [ProductController::class, 'showcase'])->name('products.showcase');

    Route::get('my-cart/data', [CartController::class, 'getData'])->name('cart.getData');
    Route::get('cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

    Route::post('/orders/place', [OrderController::class, 'place'])->name('orders.place');
    Route::get('/orders/index', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/getData', [OrderController::class, 'getData'])->name('orders.getData');
    Route::get('/orders/viewDetails/{id}', [OrderController::class, 'viewDetails'])->name('orders.viewDetails');

});

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('products/data', [ProductController::class, 'getData'])->name('products.getData');
    Route::resource('products', ProductController::class);

});
