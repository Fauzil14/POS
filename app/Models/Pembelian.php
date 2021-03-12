<?php

namespace App\Models;

use App\Models\User;
use App\Helpers\CodeGenerator;
use App\Models\BusinessTransaction;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use CodeGenerator;

    protected $fillable = [
        'kode_transaksi'
        ,'business_id'
        ,'staff_id'
        ,'supplier_id'
        ,'total_price'
        ,'status'
        ,'created_at'
        ,'updated_at'
    ];

    public function pembelian_product() {
        return $this->belongsToMany('App\Models\Product', 'detail_pembelians')->withPivot('pembelian_id', 'product_id', 'quantity', 'harga_beli', 'subtotal_harga');
    }

    public function detail_pembelian() {
        return $this->hasMany('App\Models\DetailPembelian');        
    }

    public function business() {
        return $this->hasOne('App\Models\Business', 'id', 'business_id');
    }

    public function supplier() {
        return $this->hasOne('App\Models\Supplier', 'id', 'supplier_id');
    }

    public function staff() {
        return $this->hasOne('App\Models\Staff', 'user_id', 'staff_id');
    }

    public function business_transaction() {
        return $this->hasOne(BusinessTransaction::class, 'transcaction_id', 'id');
    }

    public function user() {
        return $this->hasOne(User::class, 'id', 'staff_id');
    }

}
