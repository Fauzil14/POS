<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

class SupplierController extends Controller
{
    public function index() 
    {
        $suppliers = Supplier::get();

        return view('supplier.index')
    }

    public function cariSupplier($keyword = null) {

        $data = Supplier::where(function($query) use ($keyword) {
            $query->where('telepon_supplier', $keyword)
                  ->orWhere(function($query) use ($keyword) {
                        $lkey = strtolower($keyword);
                        return $query->whereRaw('lower(nama_supplier) like (?)',["%{$lkey}%"]);
                  });  
        })->get();

        if( count($data) == 0 ) {
            throw ValidationException::withMessages(['supplier' => 'Supplier dengan kata kunci yang anda masukkan tidak ditemukan']);
        }

        if ( Route::current()->action['prefix'] == "api/staff") {
            return response()->json($data);
        } 
        dd('data to view');
    }

}
