<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPengeluaran extends Model
{
    protected $fillable = [
        'pengeluaran_id'
        ,'pegawai_id'
        ,'beban_id'
        ,'deskripsi'
        ,'subtotal_pengeluaran'
    ];

    public function pengeluaran() {
        return $this->hasOne('App\Models\Pengeluaran', 'id', 'pengeluaran_id');
    }
}
