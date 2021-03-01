<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    protected $fillable = [
        'tanggal'
        ,'business_id'
        ,'total_pengeluaran'
    ];

    public function detail_pengeluaran() {
        return $this->hasMany('App\Models\DetailPengeluaran', 'pengeluaran_id', 'id');
    }

    

}
