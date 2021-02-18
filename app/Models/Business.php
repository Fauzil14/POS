<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $fillable = [
        'nama_bisnis'
        ,'pimpinan_id'
        ,'admin_id'
        ,'alamat_bisnis'
        ,'telepon'
        ,'logo_bisnis'
        ,'diskon_member'
    ];

    public function business() {
        return $this->hasOne('App\Models\Users', 'id','admin_id');
    }
}
