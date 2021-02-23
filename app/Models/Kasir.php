<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kasir extends Model
{
    protected $fillable = [ 
                            'user_id'
                            ,'kode_user'
                            ,'business_id'
                            ,'number_of_transaction'
                            ,'total_penjualan'
                          ];

    public function penjualan() {
      return $this->hasMany('App\Models\Penjualan', 'kasir_id', 'user_id');
    }
}
