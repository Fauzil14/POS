<?php

namespace App\Observers;

use App\Models\Pembelian;
use App\Models\Product;

class PembelianObserver
{
    public function updated(Pembelian $pembelian) {
        $product = new Product;
        if($pembelian->status == 'finished') {
            $pembelian->detail_pembelian()->get(['product_id', 'harga_beli', 'harga_jual'])->each(function($item, $key) use ($product) {
                $change = $product->find($item->product_id);
                $change->harga_beli = $item->harga_beli;
                if( !is_null($item->harga_jual) ) {
                    $change->harga_jual = $item->harga_jual;
                }
                $change->update();
            });
            $pembelian->business->keuangan->increment('pengeluaran', $pembelian->total_price);
            $pembelian->business->keuangan->decrement('saldo', $pembelian->total_price);
        }
    }
}
