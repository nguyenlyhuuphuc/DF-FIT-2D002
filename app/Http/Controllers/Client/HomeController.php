<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $products = Product::where('status', 1)->orderBy('id', 'desc')->take(8)->get();
        return view('client.pages.home', ['products' => $products]);
    }
}
