<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $fillable = [
        'kode_transaksi'
        ,'business_id'
        ,'staff_id'
        ,'supplier_id'
        ,'total_price'
        ,'status'
    ];

    public function pembelian_product() {
        return $this->belongsToMany('App\Models\Product', 'detail_pembelians')->withPivot('pembelian_id', 'product_id', 'quantity', 'harga_beli', 'diskon', 'subtotal_harga');
    }

    public function detail_pembelian() {
        return $this->hasMany('App\Models\DetailPembelian');        
    }

    public function business() {
        return $this->hasOne('App\Models\Business', 'id', 'business_id');
    }

    public function staff() {
        return $this->hasOne('App\Models\Staff', 'user_id', 'staff_id');
    }

}
