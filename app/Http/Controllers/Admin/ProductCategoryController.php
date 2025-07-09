<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductCategoryStoreRequest;
use App\Http\Requests\Admin\ProductCategoryUpdateRequest;
use App\Models\ProductCategoryTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    public function index(Request $request){
        // $result = DB::select('SELECT count(*) as count FROM product_category_test');
        // $totalItems = $result[0]->count;
        // $itemPerpage = 5;
        // $totalPages = (int)ceil($totalItems / $itemPerpage);
        
        // $page = $request->page ?? 1;
        // $offset = ($page - 1)* $itemPerpage;

        // $datas = DB::select('SELECT * FROM product_category_test 
        // ORDER BY created_at DESC LIMIT ?,?', [$offset, $itemPerpage]);

        //Eloquent
        // $itemPerPage = env('ITEM_PER_PAGE', 5);
        $itemPerPage = config('my-config.abc.xyz.a.b.c.item_per_page');
        // $datas = ProductCategoryTest::orderBy('created_at', 'desc')->paginate($itemPerPage);        
        // dd($datas);

        //Query Builder
        $datas = DB::table('product_category_test')->orderBy('id', 'desc')->paginate($itemPerPage);    

        return view('admin.pages.product_category.list', ['datas' => $datas]);
    }
    
    public function create(){
        return view('admin.pages.product_category.create');
    }
    
    public function store(ProductCategoryStoreRequest $request){     
        //Fresh data
        // $check = DB::insert("INSERT INTO product_category_test(id, name, slug, status, created_at) VALUES (?, ?, ?, ?, ?)",
        //  [null, $request->name, $request->slug, $request->status, null]);

        //Query Builder
        // $check = DB::table('product_category_test')->insert([
        //     'name' => $request->name,
        //     'slug' => $request->slug,
        //     'status' => $request->status,
        //     'created_at' => now(),
        //     'updated_at' => now()
        // ]);

        //Eloquent
        $productCategoryTest = new ProductCategoryTest();
        $productCategoryTest->status = $request->status;
        $productCategoryTest->name = $request->name;
        $productCategoryTest->slug = $request->slug;
        $check = $productCategoryTest->save(); //Insert record

        // $data = ProductCategoryTest::create([
        //         'name' => $request->name,
        //         'slug' => $request->slug,
        //         'status' => $request->status,
        //     ]);

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

    public function destroy(ProductCategoryTest $productCategory){
        $msg = $productCategory->delete() ? 'success' : 'fail';
        
        //Flash message
        return redirect()->route('admin.product_category.index')->with('msg', $msg);
    }

    public function detail(ProductCategoryTest $productCategory){
        return view('admin.pages.product_category.detail')->with('data', $productCategory);
    }

    public function update(ProductCategoryUpdateRequest $request, ProductCategoryTest $productCategory){
        $productCategory->name = $request->name;
        $productCategory->slug = $request->slug;
        $productCategory->status = $request->status;
        $check = $productCategory->save();

       return redirect()->route('admin.product_category.index')->with('msg', $check ? 'success' : 'fail');
    }
}