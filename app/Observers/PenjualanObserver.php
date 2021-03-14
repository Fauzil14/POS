<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\Penjualan;
use Illuminate\Support\Facades\Auth;

class PenjualanObserver
{
    public function creating(Penjualan $penjualan)
    {
        if( request('member_id') !== null ) {
            $penjualan->member_id = request('member_id');
            if( !is_null($penjualan->business->diskon_member) ) {
                $penjualan->total_price = $penjualan->total_price - (($penjualan->total_price * $penjualan->business->diskon_member) / 100);  
            }
            $penjualan->jenis_pembayaran = request('jenis_pembayaran');
            $penjualan->update();
        } else {
            $penjualan->jenis_pembayaran = 'tunai';
            $penjualan->status = 'unfinished';
        }
    }

    public function updated(Penjualan $penjualan)
    {

        if( $penjualan->status == 'finished' ) {
            $product = new Product;
            $penjualan->detail_penjualan->pluck('quantity', 'product_id')->each(function($item, $key) use ($product) {
                $product->where('id',$key)->decrement('stok', $item);
            });
            $penjualan->business->business_transaction()->create([
                'transaction_id'    => $penjualan->id,
                'jenis_transaksi'   => 'penjualan',
                'pemasukan'         => $penjualan->total_price,
                'saldo_transaksi'   => $penjualan->business->keuangan->saldo + $penjualan->total_price,
                'created_at'        => $penjualan->created_at
            ]);
            $penjualan->business->keuangan->increment('pemasukan', $penjualan->total_price);
            $penjualan->business->keuangan->increment('saldo', $penjualan->total_price);

            if( $penjualan->user->role == 'kasir' ) {
                $penjualan->user->kasir->increment('number_of_transaction', 1);
                $penjualan->user->kasir->increment('total_penjualan', $penjualan->total_price);
                if( $penjualan->user->kasir->status == 'on_shift' ) {
                    $penjualan->user->kasir->shift->where('end_time', null)->first()->increment('transaction_on_shift', 1);
                    $penjualan->user->kasir->shift->where('end_time', null)->first()->increment('total_penjualan_on_shift', $penjualan->total_price);
                };
            }
        }
    } 
}
