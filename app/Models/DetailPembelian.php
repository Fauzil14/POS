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
        ,'harga_jual'
        ,'subtotal_harga'
    ];

    /* $touches update the parent timestamp when the child model is updated */
    protected $touches = ['Pembelian']; // need relation

    public function product() {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }

    public function pembelian() {
        return $this->hasOne('App\Models\Pembelian', 'id', 'pembelian_id');
    }
}
