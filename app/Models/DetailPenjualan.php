<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    protected $fillable = [
                            'penjualan_id'
                            ,'product_id'
                            ,'quantity'
                            ,'harga_jual'
                            ,'diskon'
                            ,'subtotal_harga'
                         ];

    public function product() {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }
}
