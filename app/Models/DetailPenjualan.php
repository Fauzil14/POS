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

    protected static function boot() {
        parent::boot();

        static::created(function($model) {
            $penjualan = Penjualan::find($model->penjualan_id);
            $penjualan->update(['total_price' => $penjualan->detail_penjualan->sum('subtotal_harga')]);
        });

        static::updated(function($model) {
            $penjualan = Penjualan::find($model->penjualan_id);
            $penjualan->update(['total_price' => $penjualan->detail_penjualan->sum('subtotal_harga')]);
        });

        static::deleted(function($model) {
            $penjualan = Penjualan::find($model->penjualan_id);
            $penjualan->total_price = $penjualan->detail_penjualan()->sum('subtotal_harga');
            $penjualan->update();
        });
    }

    public function product() {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }

    public function penjualan() {
        return $this->hasOne('App\Models\Penjualan', 'id', 'penjualan_id');
    }


}
