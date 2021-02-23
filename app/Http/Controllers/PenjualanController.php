<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class PenjualanController extends Controller
{
    public function getFormPenjualan(Penjualan $penjualan) 
    {
        $kode_transaksi = $penjualan->kodeTransaksi();

        $user = User::findOrFail(Auth::id());

        $data = Penjualan::firstOrCreate([
            'business_id'    => $user->roles->pluck('pivot.business_id')->first(),
            'kasir_id'       => $user->id,
            'status'         => 'unfinished',
        ],[ 'kode_transaksi' => $kode_transaksi ]);
        
        if ( request()->wantsJson() ) {
            return $this->sendResponse('success', 'Form is ready', $data->load('detail_penjualan'), 200);
        }
    }

}
