<?php

namespace App\Http\Controllers;

use App\Models\RoleUser;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengeluaranController extends Controller
{
    public function makePengeluaran(Request $request)
    {
        $validatedData = $request->validate([
            'tanggal'               => 'somtimes',
            'beban_id'              => 'required|exists:bebans,id',
            'deskripsi'             => 'sometimes',
            'subtotal_pengeluaran'  => 'required_with:beban_id',
        ]);
        
        $pengeluaran = Pengeluaran::firstOrCreate([
            'tanggal'     => isset($validatedData['tanggal']) ? $validatedData['tanggal'] : now()->toDateString(),
            'business_id' => RoleUser::firstWhere('user_id', Auth::id())->business_id,
        ]);

        $pengeluaran->detail_pengeluaran()->create([
            'pegawai_id'            => Auth::id(),
            'beban_id'              => $validatedData['beban_id'],
            'deskripsi'             => $validatedData['deskripsi'],
            'subtotal_pengeluaran'  => $validatedData['subtotal_pengeluaran'],
        ]);

        if( $request->wantsJson() ) {
            return response()->json($pengeluaran);
        }
    }
}
