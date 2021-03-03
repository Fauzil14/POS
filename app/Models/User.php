<?php

namespace App\Models;

use App\Helpers\RoleManagement;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements MustVerifyEmail, JWTSubject
{
    use Notifiable, RoleManagement;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'umur', 'alamat'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = [ 'role' ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function roles() {
        return $this->belongsToMany('App\Models\Role')->withPivot('user_id', 'role_id', 'business_id', 'kode_user');
    }

    public function admin_business() {
        return $this->hasMany('App\Models\Business', 'admin_id', 'id');
    }

    public function kasir() {
        return $this->hasMany('App\Models\Kasir', 'user_id', 'id');
    }
    
    public function staff() {
        return $this->hasMany('App\Models\Staff', 'user_id', 'id');
    }

    public function request_role() {
        return $this->hasOne(RequestRole::class, 'user_id', 'id');
    }
}
