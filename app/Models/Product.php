<?php

namespace App\Models;

use App\Helpers\CodeGenerator;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use CodeGenerator;

    protected $fillable = [
        'UID'
        ,'merek'
        ,'nama'
        ,'category_id'
        ,'supplier_id'
        ,'stok'
        ,'harga_beli'
        ,'harga_jual'
        ,'diskon'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($query) {
            $query->UID = parent::setKodeProduct($query->supplier_id, $query->category_id);
            $query->diskon = !is_null($query->diskon) ? $query->diskon : null;
        });
    }

    public function setKodeProduct($supplier_id, $category_id) {
        return $this->kodeProduct($supplier_id, $category_id);
    }

    public function product_penjualan() {
        return $this->belongsToMany('App\Models\Penjualan', 'detail_penjualans')->withPivot('penjualan_id', 'product_id', 'quantity', 'harga_jual', 'diskon', 'subtotal_harga');
    }

    
}
