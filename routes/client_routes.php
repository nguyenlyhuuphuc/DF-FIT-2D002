<?php

use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\GoogleController;
use App\Http\Controllers\Client\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('google/redirect', [GoogleController::class, 'redirect'])->name('client.google.redirect');
Route::get('google/callback', [GoogleController::class, 'callback'])->name('client.google.callback');

Route::get('client/layout-master', function (){
    return view('client.layout.master');
});

Route::get('client/home',[HomeController::class, 'index'])->name('client.home.index');
Route::get('cart/add-product-to-cart/{product}', [CartController::class, 'addProductToCart'])->name('cart.add-product-to-cart');
Route::get('cart', [CartController::class, 'index'])->name('cart.index');

