<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable = [
        'UID'
        ,'merek'
        ,'category_id'
        ,'nama'
        ,'stok'
        ,'harga_beli'
        ,'harga_jual'
        ,'diskon'
    ];
}
