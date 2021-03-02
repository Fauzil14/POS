<?php

namespace App\Http\Controllers\Api\Kasir;

use App\Models\Product;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\PenjualanResource;
use Illuminate\Validation\ValidationException;

class PenjualanController extends Controller
{
    public function createDetailPenjualan(Request $request) 
    {
        $validatedData = $request->validate([
            'penjualan_id' => ['required', Rule::exists('penjualans','id')->where('status','unfinished') ],
            'product_id'   => ['required', 'exists:products,id'],
            'quantity'     => ['required_with:product_id', 'integer', function($attribute, $value, $fail) use ($request) {
                if(Product::find($request->product_id)->stok < $request->quantity) {
                    $fail('Jumlah stok dari produk tidak mencukupi untuk transaksi');
                }
            }], 
            //The field under validation must be present and not empty only if any of the other specified fields are present.
        ]);
        
        $product = Product::find($validatedData['product_id']);

        $penjualan = Penjualan::find($validatedData['penjualan_id']);
        $penjualan->detail_penjualan()->updateOrCreate([
            'product_id'     => $validatedData['product_id'],
        ],[ 
            'quantity'       => $validatedData['quantity'],
            'harga_jual'     => $product->harga_jual,
            'diskon'         => $product->diskon ,
            'subtotal_harga' => is_null($product->diskon) 
                                ? $validatedData['quantity'] * $product->harga_jual 
                                : ($validatedData['quantity'] * $product->harga_jual) - (($product->harga_jual * $product->diskon) / 100),
        ]);
        $penjualan->total_price = $penjualan->detail_penjualan()->sum('subtotal_harga');
        $penjualan->update();
        $data = new PenjualanResource($penjualan->refresh());

        return response()->json($data);
    }

    public function finishPenjualan(Request $request) // if a controller has multiple update method it will loop the updated Model event
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
        
            DB::beginTransaction();
                
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
                        throw ValidationException::withMessages([
                            'message' => 'Jumlah saldo yang anda miliki tidak mencukupi untuk melakakun transaksi',
                            'saldo_member' => $penjualan->member->saldo
                        ]);
                    }
                    $penjualan->dibayar = $penjualan->total_price;
                    $penjualan->member->decrement('saldo', $penjualan->total_price);
                } else {
                    if($validatedData['dibayar'] < $penjualan->total_price) {
                        throw ValidationException::withMessages([
                            'message' => 'Uang yang anda bayar tidak mencukupi untuk melakakun transaksi',
                            'kekurangan'  => $validatedData['dibayar'] - $penjualan->total_price
                        ]); 
                    }
                    $penjualan->dibayar = $validatedData['dibayar'];
                    $penjualan->kembalian = round($validatedData['dibayar'] - $penjualan->total_price);
                }
                $penjualan->status = 'finished';
                $penjualan->update();
                if( $this->checkAuthRole('kasir') ) {
                    $penjualan->kasir->increment('number_of_transaction', 1);
                    $penjualan->kasir->increment('total_penjualan', $penjualan->total_price);
                    if( $penjualan->kasir->status == 'on_shift' ) {
                        $penjualan->kasir->shift->increment('transaction_on_shift', 1);
                        $penjualan->kasir->shift->increment('total_penjualan_on_shift', $penjualan->total_price);
                    };
                }
                $product = new Product;
                $penjualan->detail_penjualan->pluck('quantity', 'product_id')->each(function($item, $key) use ($product) {
                    $product->where('id',$key)->decrement('stok', $item);
                });
                $penjualan->business->keuangan->increment('pemasukan', $penjualan->total_price);
                $penjualan->business->keuangan->increment('saldo', $penjualan->total_price);
            
            DB::commit();

            $data = new PenjualanResource($penjualan->refresh());

            return $this->sendResponse('success', 'Transaksi berhasil', $data, 200);
        } catch(ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'failed',
                'error' => $e->errors()
            ]);
        } catch(\Throwable $e) {
            DB::rollback();
            return $this->sendResponse('failed', 'Transaksi gagal', $e->getMessage(), 200);
        }
    }
}
