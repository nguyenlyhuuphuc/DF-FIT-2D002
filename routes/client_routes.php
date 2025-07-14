<?php

use App\Http\Controllers\Client\GoogleController;
use Illuminate\Support\Facades\Route;

Route::get('client/layout-master', function (){
    return view('client.layout.master');
});
Route::get('client/home', function (){
    return view('client.pages.home');
});

Route::get('google/redirect', [GoogleController::class, 'redirect'])->name('client.google.redirect');
 
Route::get('google/callback', [GoogleController::class, 'callback'])->name('client.google.callback');