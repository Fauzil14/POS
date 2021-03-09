<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::get();
        $categories = Category::get();
        $suppliers = Supplier::get();

        return view('inventaris.index', compact('products', 'categories', 'suppliers'));
    }

    public function cariBarang($keyword = null) {

        $data = Product::where(function($query) use ($keyword) {
            $query->where('uid', $keyword)
                  ->orWhere(function($query) use ($keyword) {
                        $lkey = strtolower($keyword);
                        return $query->whereRaw('lower(nama) like (?)',["%{$lkey}%"])
                                     ->orWhereRaw('lower(merek) like (?)',["%{$lkey}%"]);
                  });  
        })->get();

        if( count($data) == 0 ) {
            throw ValidationException::withMessages(['barang' => 'Barang dengan kata kunci yang anda masukkan tidak ditemukan']);
        }
        if ( Route::current()->action['prefix'] == "api") {
            return $this->sendResponse('success', 'Product berhasil di dapat', $data, 200);
        } 
        dd('data to view');
    }

    public function newProduct(Request $request) 
    {
        $validatedData = $request->validate([
            'uid'         => 'nullable|unique:products|min:8',
            'merek'       => 'required',
            'nama'        => 'required',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id', 
            'stok'        => 'required',
            'harga_beli'  => 'required',
            'harga_jual'  => 'required',
            'diskon'      => 'nullable',
        ]);

        $product = Product::create($validatedData);
    
        if($request->wantsJson()) {
            return response()->json($product);
        }
    }
}
