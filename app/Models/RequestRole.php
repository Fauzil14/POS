<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestRole extends Model
{
    protected $fillable = [ 'user_id', 'role_id' ];

    protected static function boot() {
        parent::boot();

        static::creating(function($model) {
            $model->status = 'menunggu';
        });
    }

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
