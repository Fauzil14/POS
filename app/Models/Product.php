<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'UID'
        ,'merek'
        ,'category_id'
        ,'nama'
        ,'stok'
        ,'harga_beli'
        ,'harga_jual'
        ,'diskon'
    ];

    public function product_penjualan() {
        return $this->belongsToMany('App\Models\Penjualan', 'detail_penjualans')->withPivot('penjualan_id', 'product_id', 'quantity', 'harga_jual', 'diskon', 'subtotal_harga');
    }
}
