<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(){
        $cart = session()->get('cart');
        return view('client.pages.cart', ['cart' => $cart]);
    }


    public function addProductToCart(Product $product){
        $cart = session()->get('cart', []);
    
        $cart[$product->id] = [
            'name' => $product->name,
            'price' => $product->price,
            'qty' => ($cart[$product->id]['qty'] ?? 0) + 1,
            'main_image' => asset('images/'. $product->main_image)
        ];

        session()->put('cart', $cart);

        return response()->json(['message' => 'Add product to cart successfully']);
    }
}
