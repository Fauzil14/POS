<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\ValidationException;

class SupplierController extends Controller
{
    public function index() 
    {
        $suppliers = Supplier::get();

        return view('supplier.index', compact('suppliers'));
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

    public function newSupplier(Request $request)
    {
        $validatedData = $request->validate([
            'nama_supplier' => 'required|max:20',
            'alamat_supplier' => 'required|max:50',
            'telepon_supplier' => 'required|unique:suppliers',
        ]);

        $supplier = Supplier::create($validatedData);

        return response()->json($supplier);
    }

    public function show($supplier_id)
    {
        $supplier = Supplier::findOrFail($supplier_id);
        $supplier->load('product');

        return view('supplier.detail-supplier', compact('supplier'));
    }

    public function update(Request $request)
    {
        $supplier = Supplier::findOrFail($request->id);

        $validatedData = $request->validate([
            'nama_supplier' => ['required', 'max:50'],
            'alamat_supplier' => ['required', 'max:100'],
            'telepon_supplier' => ['required', Rule::unique('suppliers')->ignore($supplier->id)],
        ]);

        $supplier->update($validatedData);

        return response()->json($supplier->refresh());
    }

    public function delete($supplier_id)
    {
        $supplier = Supplier::findOrFail($supplier_id);

        try {
            $supplier->delete();
    
            Alert::success('Berhasil', 'Supplier berhasil di hapus');
            return redirect()->route('supplier');
        } catch(\Throwable $e) {
            Alert::error('Gagal', 'Supplier gagal di hapus');
            return back();
        }
    }

}
