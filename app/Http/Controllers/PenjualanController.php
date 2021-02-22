<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class PenjualanController extends Controller
{
    public function getFormTransaksi(Penjualan $penjualan) 
    {
        $kode_transaksi = $penjualan->kodeTransaksi();

        $user = User::findOrFail(Auth::id());

        $data = Penjualan::firstOrCreate([
            'business_id'    => $user->roles->pluck('pivot.business_id')->first(),
            'kasir_id'       => $user->id,
            'status'         => 'unfinished',
        ],[ 'kode_transaksi' => $kode_transaksi ]);
        
        if ( request()->wantsJson() ) {
            return $this->sendResponse('success', 'Form is ready', $data->load('detail_penjualan'), 200);
        }
    }

    public function createDetailPenjualan(Request $request) 
    {
        $validatedData = $request->validate([
            'penjualan_id' => ['required', 'exists:penjualans,id'],
            'product_id'   => ['required', Rule::exists('products','id')->where(function($q) {
                $q->where('stok', '>', 0);
            })],
            'quantity'     => ['required', 'number'],
        ]);
        
        $product = Product::find($validatedData['product_id']);

        $penjualan = Penjualan::find($validatedData['penjualan_id']);
        $penjualan->attach($validatedData['product_id'], [
            'quantity'       => $validatedData['quantity'],
            'harga_jual'     => $product->harga_jual,
            'diskon'         => $product->diskon,
            'subtotal_harga' => ($validatedData['quantity'] * $product->harga_jual) - (($product->harga_jual * $product->diskon) / 100),
        ]);
    }
}
