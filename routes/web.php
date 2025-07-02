<?php

use App\Http\Controllers\Admin\ProductCategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // echo 'welcome';
    return view('welcome');

    // $name = 'Le Van Test';

    // return view('abc/xyz/ffff/a', ['name' => $name]);
});

Route::get('test', function() {
    echo '<h2>Test</h2>';
});

Route::get('a/b/c/d/e/f', function() {
    $name = 'NGuyen Van A';
    echo "<h2>$name</h2>";
});

Route::get('name/{name?}', function ($name = 'null'){
    echo $name;
});

Route::get('product/detail/{id}', function ($id){
    echo $id;
});

Route::get('ten/{ten?}/tuoi/{tuoi?}', function($name ='unknow', $age = 1){
    echo "ten : $name, tuoi: $age";
});

Route::get('test/{test?}', function ($test = 'null'){
    echo $test;
});

Route::get('scores', function(){
    return view('scores.scores');
});

Route::get('scores_blade', function(){
    return view('scores.scores_blade');
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
Route::get('client/about', function (){
    return view('client.pages.about');
});

Route::get('admin/layout', function (){
    return view('admin.layout.master');
});

Route::get('admin/home', function (){
    return view('admin.pages.home');
});



Route::get('admin/product_category/index', [ProductCategoryController::class, 'index'])->name('admin.product_category.index');

Route::post('admin/product_category/store', [ProductCategoryController::class, 'store'])->name('admin.product_category.store');

Route::get('admin/product_category/create', [ProductCategoryController::class, 'create'])->name('admin.product_category.create');

Route::get('admin/product_category/make_slug', [ProductCategoryController::class, 'makeSlug'])->name('admin.product_category.make_slug');

Route::post('admin/product_category/destroy/{id}', [ProductCategoryController::class, 'destroy'])->name('admin.product_category.destroy');

Route::get('admin/product_category/detail/{id}', [ProductCategoryController::class, 'detail'])->name('admin.product_category.detail');

Route::post('admin/product_category/update/{id}', [ProductCategoryController::class, 'update'])->name('admin.product_category.update');