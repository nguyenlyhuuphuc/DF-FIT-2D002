<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategoryTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $itemPerPage = config('my-config.abc.xyz.a.b.c.item_per_page');

        //Query Builder
        // $datas = DB::table('product')
        // ->select('product.*', 'product_category_test.name as product_category_name')
        // ->leftJoin('product_category_test', 'product.product_category_id', '=', 'product_category_test.id')
        // ->where('product.status', '=', 1)
        // ->orderBy('product.id', 'desc')
        // ->paginate($itemPerPage);

        //Eloquent
        $datas = Product::with('productCategory')->where('product.status', '=', 1)->orderBy('product.id', 'desc')->paginate(100);

        return view('admin.pages.product.list', ['datas' => $datas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $msg = $product->delete() ? 'success' : 'fail';
        
        return redirect()->route('admin.product.index')->with('msg', $msg);
    }
}
