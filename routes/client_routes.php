<?php

use App\Http\Controllers\Client\GoogleController;
use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;

Route::get('client/about', function (){
    return view('client.pages.about');
});

Route::get('php', function(){
    return view('template.php');
});
Route::get('html', function(){
    return view('template.html');
});
Route::get('css', function(){
    return view('template.css');
});
Route::get('about-us', function(){
    return view('template.about-us');
});
Route::get('home', function(){
    return view('template.home');
});
Route::get('layout-master', function(){
    return view('layout.master');
});

Route::get('client/layout-master', function (){
    return view('client.layout.master');
});
Route::get('client/home', function (){
    return view('client.pages.home');
});

Route::get('google/redirect', [GoogleController::class, 'redirect'])->name('client.google.redirect');
 
Route::get('google/callback', [GoogleController::class, 'callback'])->name('client.google.callback');