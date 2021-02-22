<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenjualanController extends Controller
{
    public function getFormTransaksi(Penjualan $penjualan) 
    {
        $kode_transaksi = $penjualan->kodeTransaksi();

        $user = User::findOrFail(Auth::id());

        $data = Penjualan::firstOrCreate([
            'kode_transaksi' => $kode_transaksi,
            'business_id'    => $user->roles->pluck('pivot.business_id')->first(),
            'kasir_id'       => $user->id,
        ]);
        
        if ( request()->wantsJson() ) {
            return $this->sendResponse('success', 'Form is ready', $data, 200);
        }
    }

    // public function
}
