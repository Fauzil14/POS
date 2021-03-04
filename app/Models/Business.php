<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $fillable = [
        'nama_bisnis'
        ,'pimpinan_id'
        ,'admin_id'
        ,'alamat_bisnis'
        ,'telepon'
        ,'logo_bisnis'
        ,'diskon_member'
    ];

    public function product() {
        return $this->hasOne(Product::class, 'business_id', 'id');
    }

    public function admin_business() {
        return $this->hasOne('App\Models\Users', 'id','admin_id');
    }

    public function checkAdmin($admin_id) {
        return self::where('admin_id', $admin_id)->exists();
    }

    public function penjualan() {
        return $this->hasOne('App\Models\Penjualan', 'business_id', 'id');
    }

    public function keuangan() {
        return $this->hasOne('App\Models\KeuanganBusiness', 'business_id', 'id');
    }

    public function business_transaction() {
        return $this->hasMany(BusinessTransaction::class, 'business_id', 'id');
    }

}
