<?php

namespace App\Helpers;

use App\Models\Role;
use App\Models\Business;
use App\Models\RoleUser;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BusinessController;
use App\Models\KeuanganBusiness;
use Illuminate\Validation\ValidationException;

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

    public function assignRole($role, $business_id = null) {
        $role_id = Role::firstWhere('role_name', $role)->id;
        $kode_user = $this->kodeUserPerRole($role_id);

        if($role == 'admin') {
            $business = new Business;
            if ($business->checkAdmin($this->getKey())) {
                throw ValidationException::withMessages(['admin' => 'Anda sudah memiliki outlet sebelumnnya']);
            }; 
            $business = $business->create(['admin_id' => $this->getKey()]);
            $business_id = $business->id;
            KeuanganBusiness::create(['business_id' => $business_id]);
        }

        // return static::roles()->attach($role_id, ['business_id' => $business_id, 'kode_user' => $kode_user]);
        static::roles()->attach($role_id, ['business_id' => $business_id, 'kode_user' => $kode_user]);
        if($role == 'kasir') {
            static::kasir()->create(['kode_user' => $kode_user]);
        }
        if($role == 'staff') {
            static::staff()->create(['kode_user' => $kode_user]);
        }
    }

    public function syncRole($role) {
        $role_id = Role::firstWhere('role_name', $role)->id;
        $role_user = RoleUser::where('user_id', Auth::id())->first();

        static::roles()->updateExistingPivot($role_id, ['business_id' => $role_user->business_id, 'kode_user' => $role_user->kode_user]);
    }

}


?>