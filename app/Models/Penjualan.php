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
        return $this->belongsToMany('App\Models\Products')->using('App\Models\DetailPenjualan');
    }
}
