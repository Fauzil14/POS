<?php

namespace App\Models;

use App\Models\Kasir;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $fillable = [
        'kasir_id'
        ,'start_time'
        ,'end_time'
        ,'transaction_on_shift'
        ,'total_penjualan_on_shift'
    ];

    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function($query) {
            $query->transaction_on_shift = 0;
            $query->total_penjualan_on_shift = 0;
        });

        static::created(function($model) {
            $model->kasir->update(['status' => 'on_shift']);
        });

        static::updated(function($model) {
            $model->kasir->update(['status' => 'not_on_shift']);
        });
    }

    public function user() {
        return $this->hasOne(User::class, 'id', 'kasir_id');
    }

    public function kasir() {
        return $this->hasOne(Kasir::class, 'user_id', 'kasir_id');
    }
}
