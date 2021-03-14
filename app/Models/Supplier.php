<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'nama_supplier'
        ,'alamat_supplier'
        ,'telepon_supplier'
    ];

    public function product() {
        return $this->hasMany(Product::class, 'supplier_id', 'id');
    }
}
