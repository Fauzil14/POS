<?php

namespace App\Observers;

use App\Models\Pembelian;
use App\Models\Product;

class PembelianObserver
{
    public function updated(Pembelian $pembelian) {
        if($pembelian->status == 'finished') {
            $pembelian->detail_pembelian()->pluck('harga_beli', 'product_id')->each(function($item, $key) {
                Product::where('id', $key)->update(['harga_beli' => $item]);
            });
        }
    }
}
