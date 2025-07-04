<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductCategoryController;

Route::get('admin/layout', function (){
    return view('admin.layout.master');
});

Route::get('admin/home', function (){
    return view('admin.pages.home');
});

Route::prefix('admin/product_category')
->controller(ProductCategoryController::class)
->name('admin.product_category.')
->group(function(){
    Route::get('index', 'index')->name('index');
    Route::post('store', 'store')->name('store');
    Route::get('create', 'create')->name('create');    
    Route::get('make_slug', 'makeSlug')->name('make_slug');
    Route::post('destroy/{id}', 'destroy')->name('destroy');
    Route::get('detail/{id}', 'detail')->name('detail');
    Route::post('update/{id}', 'update')->name('update');
});
?>