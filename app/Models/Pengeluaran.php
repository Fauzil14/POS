<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    const CREATED_AT = null; // disable created_at columm on creating

    public $timestamps = ['updated_at'];

    protected $fillable = [
        'tanggal'
        ,'business_id'
        ,'total_pengeluaran'
    ];

    public function detail_pengeluaran() {
        return $this->hasMany('App\Models\DetailPengeluaran', 'pengeluaran_id', 'id');
    }

    

}
