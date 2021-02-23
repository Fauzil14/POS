<?php

namespace App\Http\Controllers\Api\Kasir;

use App\Models\Member;
use App\Models\Product;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use function PHPUnit\Framework\throwException;

use Illuminate\Validation\ValidationException;

class PenjualanController extends Controller
{
    public function createDetailPenjualan(Request $request) 
    {
        $validatedData = $request->validate([
            'penjualan_id' => ['required', Rule::exists('penjualans','id')->where('status','unfinished') ],
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
        $penjualan->total_price = $penjualan->detail_penjualan()->sum('subtotal_harga');
        $penjualan->update();
        $data = $penjualan->refresh();

        return response()->json($data->load('detail_penjualan'));
    }

    public function finishPenjualan(Request $request)
    {
        $validatedData = $request->validate([
            'penjualan_id'     => ['required', Rule::exists('penjualans','id')->where('status', 'unfinished')],
            'member_id'        => ['required_if:jenis_pembayaran,debit', 'exists:members,id'],
            'jenis_pembayaran' => ['required'],
            'dibayar'          => ['required_unless:jenis_pembayaran,debit']
        ]);
        /* Note: required_unless */
        // The field under validation must be present and not empty unless the anotherfield field is equal to any value.

        $penjualan = Penjualan::findOrFail($validatedData['penjualan_id']);
        
        try {
        
            DB::transaction(function () use($penjualan, $validatedData) {
                
                if( isset($validatedData['member_id']) ) {
                    $penjualan->member_id = $validatedData['member_id'];
                    if( !is_null($penjualan->business->diskon_member) ) {
                        $penjualan->total_price = $penjualan->total_price - (($penjualan->total_price * $penjualan->business->diskon_member) / 100);  
                    }
                    $penjualan->jenis_pembayaran = $validatedData['jenis_pembayaran'];
                }
                $penjualan->update();
                
                $penjualan->refresh();
                if( $penjualan->jenis_pembayaran == 'debit' ) {
                    if($penjualan->member->saldo < $penjualan->total_price) {
                        return throwException(ValidationException::withMessages(['error' => 'Jumlah saldo yang anda miliki tidak mencukupi untuk melakakun transaksi',
                                                                          'saldo'  => $penjualan->member->saldo
                                                                        ]));
                    }
                    $penjualan->dibayar = $penjualan->total_price;
                    $penjualan->member->decrement('saldo', $penjualan->total_price);
                } else {
                    $penjualan->dibayar = $validatedData['dibayar'];
                    $penjualan->kembalian = round($validatedData['dibayar'] - $penjualan->total_price);
                }
                $penjualan->status = 'finished';
                $penjualan->update();
                $penjualan->kasir->increment('number_of_transaction', 1);
                $penjualan->kasir->increment('total_penjualan', $penjualan->total_price);
            });

            return $this->sendResponse('success', 'Transaksi berhasil', $penjualan->load('detail_penjualan'), 200);
        } catch(\Throwable $e) {
            return $this->sendResponse('failed', 'Transaksi gagal', $e->getMessage(), 500);
        }
    }
}
