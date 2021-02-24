<?php

namespace App\Models;

use App\Helpers\CodeGenerator;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use CodeGenerator;

    protected $fillable = [
                            'kode_transaksi'
                            ,'business_id'
                            ,'kasir_id'
                            ,'member_id'
                            ,'total_price'
                            ,'jenis_pembayaran'
                            ,'dibayar'
                            ,'kembalian'
                            ,'status'
                          ];

    protected static function boot() {
        parent::boot();

        static::creating(function($query) {
            $query->jenis_pembayaran = 'tunai';
        });
    }

    public function penjualan_product() {
        return $this->belongsToMany('App\Models\Product', 'detail_penjualans')->withPivot('penjualan_id', 'product_id', 'quantity', 'harga_jual', 'diskon', 'subtotal_harga');
    }

    public function detail_penjualan() {
        return $this->hasMany('App\Models\DetailPenjualan');        
    }

    public function business() {
        return $this->hasOne('App\Models\Business', 'id', 'business_id');
    }

    public function kasir() {
        return $this->hasOne('App\Models\Kasir', 'user_id', 'kasir_id');
    }

    public function member() {
        return $this->hasOne('App\Models\Member', 'id', 'member_id');
    }
}
