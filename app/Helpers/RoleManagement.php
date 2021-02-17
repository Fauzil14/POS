<?php

namespace App\Helpers;

use App\Models\Role;
use App\Models\RoleUser;
use Illuminate\Support\Facades\DB;

trait RoleManagement {
    
    public function hasAnyRoles($roles) {
        return static::roles()->whereIn('name', $roles)->first() ? TRUE : FALSE;
    }

    public function hasRole($role) {
        return static::roles()->where('name', $role)->first() ? TRUE : FALSE;
    }

    public function whatRole() {
        return static::roles()->first()->role_name ?? "Anda belum memilki role" ;
    }

    public function getRoleAttribute() {
        return $this->whatRole();
    }

    public function whoHasRole($role) {
        return static::whereHas('roles', function($q) use ($role) { // whereHas didn't return null data
            $q->where('name', $role);
        });
    }

    public function assignRole($role_id) {
        if( RoleUser::where('role_id', $role_id)->exists() ) {
            $count = ltrim(substr(RoleUser::where('role_id', $role_id)->orderByDesc('id')->first()->kode_user, 1), 0) + 1;
        } else {
            $count = RoleUser::where('role_id', $role_id)->count() + 1;
        }
        $kode_user = $role_id . sprintf("%03d", $count);

        return static::roles()->attach($role_id, ['kode_user' => $kode_user]);
    }

}


?>