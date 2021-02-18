<?php

namespace App\Helpers;

use App\Models\RoleUser;

trait CodeGenerator {
    
    public function kodeUserPerRole($role_id) {
        if( RoleUser::where('role_id', $role_id)->exists() ) {
            $count = ltrim(substr(RoleUser::where('role_id', $role_id)->orderByDesc('id')->first()->kode_user, 1), 0) + 1;
        } else {
            $count = RoleUser::where('role_id', $role_id)->count() + 1;
        }
        return $role_id . sprintf("%03d", $count);
    }

}


?>