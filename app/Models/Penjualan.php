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
                          ];

    public function penjualan_product() {
        return $this->belongsToMany('App\Models\Product', 'detail_penjualans')->withPivot('penjualan_id', 'product_id', 'quantity', 'harga_jual', 'diskon', 'subtotal_harga');
    }

    public function detail_penjualan() {
        return $this->hasMany('App\Models\DetailPenjualan');        
    }
}
