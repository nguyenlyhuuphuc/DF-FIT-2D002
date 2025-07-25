<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductCategoryStoreRequest;
use App\Http\Requests\Admin\ProductCategoryUpdateRequest;
use App\Models\Product;
use App\Models\ProductCategoryTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    public function index(Request $request){        
        $keyword = $request->keyword ?? null;
        $sort = $request->sort ?? 'latest';

        $array = ['id', 'desc'];
        if($sort === 'oldest'){
            $array = ['id', 'asc'];
        }
        [$column, $sort] = $array;

        $itemPerPage = config('my-config.abc.xyz.a.b.c.item_per_page');
        $itemPerPage = 100;

        //Query Builder
        if(!$keyword){
            $datas = DB::table('product_category_test')->orderBy($column, $sort)->paginate($itemPerPage);    
        }else{
            $datas = DB::table('product_category_test')->where('name', 'LIKE', "%$keyword%")->orderBy($column, $sort)->paginate($itemPerPage);    
        }

        // $datas = ProductCategoryTest::withTrashed()->paginate(100);

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

    public function restore(string $id){
        $productCategory = ProductCategoryTest::withTrashed()->find($id);

        $productCategory->restore();

        return redirect()->route('admin.product_category.index')->with('msg', 'success');
    }
}