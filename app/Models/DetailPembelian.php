<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{
    protected $fillable = [
        'pembelian_id'
        ,'product_id'
        ,'quantity'
        ,'harga_beli'
        ,'diskon'
        ,'subtotal_harga'
    ];

    public function product() {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }
}
