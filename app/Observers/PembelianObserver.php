<?php

namespace App\Observers;

use App\Models\Pembelian;
use App\Models\Product;

class PembelianObserver
{

    public function creating(Pembelian $pembelian)
    {
        $pembelian->status = 'unfinished';
    }

    public function updated(Pembelian $pembelian) 
    {
        
        if($pembelian->status == 'finished') {
            $product = new Product;
            $pembelian->detail_pembelian()->get(['product_id', 'harga_beli', 'harga_jual', 'quantity'])->each(function($item, $key) use ($product) {
                $change = $product->find($item->product_id);
                $change->harga_beli = $item->harga_beli;
                $change->stok += $item->quantity;
                if( !is_null($item->harga_jual) ) {
                    $change->harga_jual = $item->harga_jual;
                }
                $change->update();
            });
            $pembelian->business->business_transaction()->create([
                'transaction_id'    => $pembelian->id,
                'jenis_transaksi'   => 'pembelian',
                'pengeluaran'       => $pembelian->total_price,
                'saldo_transaksi'   => $pembelian->business->keuangan->saldo - $pembelian->total_price,
                'created_at'        => $pembelian->created_at
            ]);
            $pembelian->business->keuangan->increment('pengeluaran', $pembelian->total_price);
            $pembelian->business->keuangan->decrement('saldo', $pembelian->total_price);
            
            if( $pembelian->user->role == "staff" ) {
                $pembelian->staff->increment('number_of_transaction', 1);
                $pembelian->staff->increment('total_pembelian', $pembelian->total_price);
            }
        }
    }
}
