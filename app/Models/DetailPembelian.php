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

    protected static function boot() {
        parent::boot();

        static::creating(function($model) {
            $model->created_at = $model->pembelian()->created_at;
        });

        static::created(function($model) {
            $pembelian = Pembelian::find($model->pembelian_id);
            $pembelian->update(['total_price' => $pembelian->detail_pembelian->sum('subtotal_harga')]);
        });

        static::updated(function($model) {
            $pembelian = Pembelian::find($model->pembelian_id);
            $pembelian->update(['total_price' => $pembelian->detail_pembelian->sum('subtotal_harga')]);
        });

        static::deleted(function($model) {
            $pembelian = Pembelian::find($model->pembelian_id);
            $pembelian->total_price = $pembelian->detail_pembelian()->sum('subtotal_harga');
            $pembelian->update();
        });
    }
    

    public function product() {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }

    public function pembelian() {
        return $this->hasOne('App\Models\Pembelian', 'id', 'pembelian_id');
    }
}
