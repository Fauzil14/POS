<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\RoleUser;
use Illuminate\Support\Facades\Auth;

trait CodeGenerator {
    
    public function kodeUserPerRole($role_id) {
        if( RoleUser::where('role_id', $role_id)->exists() ) {
            $count = ltrim(substr(RoleUser::where('role_id', $role_id)->orderByDesc('id')->first()->kode_user, 1), 0) + 1;
        } else {
            $count = RoleUser::where('role_id', $role_id)->count() + 1;
        }
        return $role_id . sprintf("%03d", $count);
    }

    public function kodeTransaksi() {
        $user = User::find(Auth::id());

        switch (TRUE) {
            case request()->is('*/penjualan/*') : // asterrisk for wildcard
                $prenumb = 1;
                $kode_user = $user->kasir()->first()->kode_user;
                if(static::where('kasir_id', $user->id)->exists()) {
                    $last_number = $this->parseTransactionCode(static::latest()->where('kasir_id', $user->id)->first()->kode_transaksi) + 1;
                } else {
                    $last_number = 1;
                }
                break;
            case request()->is('*/pembelian/*') : 
                $prenumb = 2;
                $kode_user = $user->staff()->first()->kode_user;
                break;
        }

        return $prenumb . now()->format('y') . $kode_user . sprintf("%05d", $last_number);
    }

    public function parseTransactionCode($raw) {
        return ltrim(substr($raw, 7), 0);
    }

}


?>