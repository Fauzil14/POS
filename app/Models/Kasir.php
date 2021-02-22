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
}
