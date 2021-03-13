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
                            ,'created_at'
                            ,'updated_at'
                          ];

    protected $appends = [ 'total_produk' ];

    public function getTotalProdukAttribute() {
        return $this->attributes['total_produk'] = $this->detail_penjualan()->sum('quantity');
    }

    public function scopeFinished($query) {
        $query->where('status', 'finished');
    }

    public function scopeDate($query, $tanggal) {
        $query->whereDate('created_at', $tanggal);
    }
    
    public function scopeMonth($query, $bulan) {
        $bulan = explode('-', $bulan);
        $query->whereYear('created_at', $bulan[0])
                ->whereMonth('created_at', $bulan[1]);
    }

    public function scopeYear($query, $tahun) {
        $query->whereYear('created_at', $tahun);
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
