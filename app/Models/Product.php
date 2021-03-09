<?php

namespace App\Models;

use App\Models\Business;
use App\Helpers\CodeGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use CodeGenerator;

    protected $fillable = [
        'business_id'
        ,'uid'
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

        static::addGlobalScope('business', function(Builder $builder) {
            $builder->where('business_id', Auth::user()->roles->pluck('pivot.business_id')->first());
        });

        static::creating(function($query) {
            $query->business_id = Auth::user()->roles->pluck('pivot.business_id')->first();
            $query->uid = strlen($query->uid) < 8 ? parent::setKodeProduct($query->supplier_id, $query->category_id) : $query->uid;
            $query->diskon = !is_null($query->diskon) ? $query->diskon : null;
        });
    }

    public function setKodeProduct($supplier_id, $category_id) {
        return $this->kodeProduct($supplier_id, $category_id);
    }

    public function product_penjualan() {
        return $this->belongsToMany('App\Models\Penjualan', 'detail_penjualans')->withPivot('penjualan_id', 'product_id', 'quantity', 'harga_jual', 'diskon', 'subtotal_harga');
    }

    public function business() {
        return $this->hasOne(Business::class, 'id', 'business_id');
    }

    public function category() {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function supplier() {
        return $this->hasOne(Supplier::class, 'id', 'supplier_id');
    }
}
