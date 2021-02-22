<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{    
    public function users() {
        return $this->belongsToMany('App\Models\User')->withPivot('user_id', 'role_id', 'kode_user');
    }
}
