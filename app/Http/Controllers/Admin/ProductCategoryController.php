<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductCategoryStoreRequest;
use App\Http\Requests\Admin\ProductCategoryUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    public function index(Request $request){
        $result = DB::select('SELECT count(*) as count FROM product_category_test');
        $totalItems = $result[0]->count;
        $itemPerpage = 5;
        $totalPages = (int)ceil($totalItems / $itemPerpage);
        
        $page = $request->page ?? 1;
        $offset = ($page - 1)* $itemPerpage;

        $datas = DB::select('SELECT * FROM product_category_test 
        ORDER BY created_at DESC LIMIT ?,?', [$offset, $itemPerpage]);

        return view('admin.pages.product_category.list', ['datas' => $datas, 'totalPages' => $totalPages]);
    }
    
    public function create(){
        return view('admin.pages.product_category.create');
    }
    
    public function store(ProductCategoryStoreRequest $request){     
        //Fresh data
        $check = DB::insert("INSERT INTO product_category_test(id, name, slug, status, created_at) VALUES (?, ?, ?, ?, ?)",
         [null, $request->name, $request->slug, $request->status, null]);

        return redirect()->route('admin.product_category.index')->with('msg', $check ? 'success' : 'fail');
    }

    public function makeSlug(Request $request){
        $slug = Str::slug($request->slug);
        $result = DB::select('SELECT count(*) as count FROM product_category_test WHERE slug = ?',[$slug]);

        if($result[0]->count > 0){
            $slug .= '-'.uniqid();
        }

        return response()->json(['slug' => $slug]);
    }

    public function destroy(string $id){
        $result = DB::delete('DELETE FROM product_category_test where id = ?', [$id]);

        $msg = $result ? 'success' : 'fail';
        
        //Flash message
        return redirect()->route('admin.product_category.index')->with('msg', $msg);
    }

    public function detail(string $id){
        $data = DB::select('select * from product_category_test where id = ?', [$id]);

        if(!count($data)){
            abort(404);
        }

        return view('admin.pages.product_category.detail')->with('data', $data[0]);
    }

    public function update(ProductCategoryUpdateRequest $request, string $id){
        $check = DB::update("UPDATE product_category_test SET name = ?, slug = ?, status = ? WHERE id = ?",
        [$request->name, $request->slug, $request->status, $id]);

       return redirect()->route('admin.product_category.index')->with('msg', $check ? 'success' : 'fail');
    }
}
