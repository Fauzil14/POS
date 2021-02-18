<?php

namespace App\Helpers;

use App\Models\Role;
use App\Models\RoleUser;

trait RoleManagement {
    use CodeGenerator;
    
    public function hasAnyRoles($roles) {
        return static::roles()->whereIn('role_name', $roles)->first() ? TRUE : FALSE;
    }

    public function hasRole($role) {
        return static::roles()->where('role_name', $role)->first() ? TRUE : FALSE;
    }

    public function whatRole() {
        return static::roles()->first()->role_name ?? "Anda belum memilki role" ;
    }

    public function getRoleAttribute() {
        return $this->whatRole();
    }

    public function whoHasRole($role) {
        return static::whereHas('roles', function($q) use ($role) { // whereHas didn't return null data
            $q->where('role_name', $role);
        });
    }

    public function assignRole($role) {
        $role_id = Role::firstWhere('role_name', $role)->id;
        $kode_user = $this->kodeUserPerRole($role_id);

        return static::roles()->attach($role_id, ['kode_user' => $kode_user]);
    }

}


?>