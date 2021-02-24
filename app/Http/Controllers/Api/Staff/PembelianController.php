<?php

namespace App\Http\Controllers\Api\Staff;

use App\Models\Product;
use App\Models\Pembelian;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class PembelianController extends Controller
{
    public function createDetailPembelian(Request $request) {
        $validatedData = $request->validate([
            'pembelian_id'   => ['required', Rule::exists('pembelians','id')->where('status','unfinished') ],
            'product_id'     => ['required', 'exists:products,id'],
            'quantity'       => ['required_with:product_id', 'integer'],
            'harga_beli'     => ['required'],
        ]);

        $product = Product::find($validatedData['product_id']);

        $pembelian = Pembelian::find($validatedData['pembelian_id']);
        $pembelian->detail_pembelian()->updateOrCreate([
            'product_id'     => $validatedData['product_id'],
        ],[ 
            'quantity'       => $validatedData['quantity'],
            'harga_beli'     => $product->harga_beli,
            'subtotal_harga' => $validatedData['quantity'] * $product->harga_beli,
        ]);
        $pembelian->total_price = $pembelian->detail_pembelian()->sum('subtotal_harga');
        $pembelian->update();
        $data = $pembelian->refresh();
        // $data = new PembelianResource($pembelian->refresh());

        return response()->json($data);
    }
    
    public function finishPembelian(Request $request) {

    }
}
