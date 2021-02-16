<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestRole extends Model
{
    protected $fillable = [ 'user_id', 'role_id' ];
}
