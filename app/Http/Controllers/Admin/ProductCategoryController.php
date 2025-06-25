<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductCategoryStoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductCategoryController extends Controller
{
    public function create(){
        return view('admin.pages.product_category.create');
    }
    
    public function store(ProductCategoryStoreRequest $request){     
        //Fresh data
        $check = DB::insert("INSERT INTO product_category_test(id, name, status, created_at) VALUES (?, ?, ?, ?)",
         [null, $request->name, $request->status, null]);

        return redirect()->route('admin.product_category.index')->with('msg', $check ? 'success' : 'fail');
    }
}
