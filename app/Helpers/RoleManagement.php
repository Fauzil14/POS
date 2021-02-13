<?php

namespace App\Helpers;

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

    public function assignRole($role) {
        return static::roles()->attach($role);
    }

}


?>