<?php

namespace App\Models;

use App\Models\BusinessTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Pengeluaran extends Model
{
    const CREATED_AT = null; // disable created_at columm on creating

    public $timestamps = ['updated_at'];

    protected $fillable = [
        'tanggal'
        ,'business_id'
        ,'total_pengeluaran'
    ];

    protected static function booted() 
    {
        static::addGlobalScope('business', function(Builder $builder) {
            if(!empty(Auth::user())) {
                $builder->where('business_id', Auth::user()->roles->pluck('pivot.business_id')->first());
            }
        });
    }

    public function detail_pengeluaran() {
        return $this->hasMany('App\Models\DetailPengeluaran', 'pengeluaran_id', 'id');
    }

    public function business_transaction() {
        return $this->hasOne(BusinessTransaction::class, 'transcaction_id', 'id');
    }

    public function business() {
        return $this->hasOne(Business::class, 'id', 'business_id');
    }

}
