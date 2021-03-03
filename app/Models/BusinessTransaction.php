<?php

namespace App\Models;

use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\Pengeluaran;
use Illuminate\Database\Eloquent\Model;

class BusinessTransaction extends Model
{
    protected $fillable = [
        'business_id'
        ,'transaction_id'
        ,'jenis_transaksi'
        ,'pemasukan'
        ,'pengeluaran'
        ,'saldo_saat_ini'
    ];

    public function penjualan() {
        return $this->hasOne(Penjualan::class, 'id', 'transaction_id');
    }

    public function pembelian() {
        return $this->hasOne(Pembelian::class, 'id', 'transaction_id');
    }

    public function pengeluaran() {
        return $this->hasOne(Pengeluaran::class, 'id', 'transaction_id');
    }

    public function business() {
        return $this->hasOne(Business::class, 'id', 'business_id');
    }
}
