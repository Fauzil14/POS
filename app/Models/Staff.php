<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = [
                            'user_id'
                            ,'business_id'
                            ,'kode_user'
                            ,'number_of_transaction'
                            ,'total_pembelian'
                          ];

}
