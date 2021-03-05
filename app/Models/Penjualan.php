<?php

namespace App\Models;

use App\Models\User;
use App\Helpers\CodeGenerator;
use App\Models\BusinessTransaction;
use App\Observers\PenjualanObserver;
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

    public function scopeDate($query, $tanggal) {
        $query->whereDate('created_at', $tanggal);
    }
    
    public function scopeHarian($query, $bulan = null) {
        $query->whereMonth('created_at', is_null($bulan) ? now()->month() : $bulan);
    }

    public function scopeBulanan($query, $tahun = null) {
        $query->whereYear('created_at', is_null($tahun) ? now()->year() : $tahun);
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

    public function business_transaction() {
        return $this->hasOne(BusinessTransaction::class, 'transcaction_id', 'id');
    }

    public function user() {
        return $this->hasOne(User::class, 'id', 'kasir_id');
    }

}
