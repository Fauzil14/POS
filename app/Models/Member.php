<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
                            'kode_member'
                            ,'nama'
                            ,'no_telephone'
                            ,'saldo'
                          ];

    
}
