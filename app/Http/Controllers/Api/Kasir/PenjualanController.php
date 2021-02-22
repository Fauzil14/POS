<?php

namespace App\Http\Controllers\Api\Kasir;

use App\Models\Product;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class PenjualanController extends Controller
{
    public function createDetailPenjualan(Request $request) 
    {
        $validatedData = $request->validate([
            'penjualan_id' => ['required', 'exists:penjualans,id'],
            'product_id'   => ['required', Rule::exists('products','id')->where(function($q) {
                $q->where('stok', '>', 0);
            })],
            'quantity'     => ['required_with:product_id', 'integer'], //The field under validation must be present and not empty only if any of the other specified fields are present.
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

        return response()->json($penjualan->load('detail_penjualan'));
    }
}
