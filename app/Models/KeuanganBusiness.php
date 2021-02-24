<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeuanganBusiness extends Model
{
    protected $fillable = [
        'business_id'
        ,'pemasukan'
        ,'pengeluaran'
        ,'saldo'
    ];

    public function business() {
        return $this->hasOne('App\Models\Business', 'id', 'business_id');
    }
}
