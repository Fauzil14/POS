<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembelianController extends Controller
{
    public function getFormPembelian($supplier_id, Pembelian $pembelian) 
    {
        $kode_transaksi = $pembelian->kodeTransaksi();

        $user = User::findOrFail(Auth::id());

        $data = Pembelian::firstOrCreate([
            'business_id'    => $user->roles->pluck('pivot.business_id')->first(),
            'staff_id'       => $user->id,
            'status'         => 'unfinished',
        ],[ 'kode_transaksi' => $kode_transaksi ]);
        
        if ( request()->wantsJson() ) {
            return $this->sendResponse('success', 'Form is ready', $data, 200);
        }
    }
}
