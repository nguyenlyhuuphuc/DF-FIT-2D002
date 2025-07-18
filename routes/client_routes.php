<?php

use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\GoogleController;
use App\Http\Controllers\Client\HomeController;
use App\Mail\TestEmailTemplate;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('google/redirect', [GoogleController::class, 'redirect'])->name('client.google.redirect');
Route::get('google/callback', [GoogleController::class, 'callback'])->name('client.google.callback');

Route::get('client/layout-master', function (){
    return view('client.layout.master');
});

Route::get('client/home',[HomeController::class, 'index'])->name('client.home.index');
Route::get('cart/add-product-to-cart/{product}', [CartController::class, 'addProductToCart'])->name('cart.add-product-to-cart')->middleware('auth');
Route::get('cart', [CartController::class, 'index'])->name('cart.index')->middleware('auth');
Route::get('checkout', [CartController::class, 'checkout'])->name('cart.checkout')->middleware('auth');
Route::post('place-order', [CartController::class, 'placeOrder'])->name('client.cart.place-order')->middleware('auth');

Route::get('test-mail', function(){
    $product = Product::find(1);
    Mail::to('nguyenlyhuuphucwork@gmail.com')->send(new TestEmailTemplate($product));
});

Route::get('vnpay_return', function (Request $request){
    dd($request->all());
});