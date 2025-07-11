<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Middleware\CheckIsAdmin;

Route::get('admin/layout', function (){
    return view('admin.layout.master');
});

Route::get('admin/home', function (){
    return view('admin.pages.home');
});

Route::prefix('admin/product_category')
->controller(ProductCategoryController::class)
->name('admin.product_category.')
->middleware(CheckIsAdmin::class)
->group(function(){
    Route::get('index', 'index')->name('index');
    Route::post('store', 'store')->name('store');
    Route::get('create', 'create')->name('create');    
    Route::get('make_slug', 'makeSlug')->name('make_slug');
    Route::post('destroy/{productCategory}', 'destroy')->name('destroy');
    Route::get('detail/{productCategory}', 'detail')->name('detail');
    Route::post('update/{productCategory}', 'update')->name('update');
    Route::post('restore/{productCategory}', 'restore')->name('restore');
});

Route::resource('admin/product', ProductController::class)->names('admin.product')->middleware(CheckIsAdmin::class);


?>