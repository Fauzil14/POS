<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ProductController extends Controller
{
    public function cariBarang($keyword = null) {
        $data = Product::where(function($query) use ($keyword) {
            $query->where('UID', $keyword)
                  ->orWhere(function($query) use ($keyword) {
                        $lkey = strtolower($keyword);
                        return $query->whereRaw('lower(nama) like (?)',["%{$lkey}%"])
                              ->orWhereRaw('lower(merek) like (?)',["%{$lkey}%"]);
                  });  
        })->get();
        
        if ( Route::current()->action['prefix'] == "api") {
            return response()->json($data);
        } 
        dd('data to view');
    }
}
