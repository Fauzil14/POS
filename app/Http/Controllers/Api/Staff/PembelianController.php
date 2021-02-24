<?php

namespace App\Http\Controllers\Api\Staff;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PembelianController extends Controller
{
    public function createDetailPembelian(Request $request) {
        $validatedData = $request->validate([
            'pembelian_id'   => ['required', Rule::exists('pembelians','id')->where('status','unfinished') ],
            'product_id'     => ['required', 'exists:products,id'],
            'quantity'       => ['required_with:product_id', 'integer'],
            'harga_beli'     => ['required'],
            'diskon'         => ['nullable']
        ]);

        $product = Product::find($validatedData['product_id']);

        $penjualan = Penjualan::find($validatedData['penjualan_id']);
        $penjualan->detail_penjualan()->updateOrCreate([
            'product_id'     => $validatedData['product_id'],
        ],[ 
            'quantity'       => $validatedData['quantity'],
            'harga_jual'     => $product->harga_jual,
            'diskon'         => $product->diskon,
            'subtotal_harga' => ($validatedData['quantity'] * $product->harga_jual) - (($product->harga_jual * $product->diskon) / 100),
        ]);
        $penjualan->total_price = $penjualan->detail_penjualan()->sum('subtotal_harga');
        $penjualan->update();
        $data = new PenjualanResource($penjualan->refresh());

        return response()->json($data);
    }
    
    public function finishPembelian(Request $request) {

    }
}
