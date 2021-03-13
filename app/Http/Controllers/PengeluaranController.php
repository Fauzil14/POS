<?php

namespace App\Http\Controllers;

use App\Http\Resources\PengeluaranResource;
use App\Models\RoleUser;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class PengeluaranController extends Controller
{
    public function getPengeluaran($waktu)
    {   
        // $waktu = hari_ini/bulan_ini

        $pengeluaran = Pengeluaran::where('business_id', RoleUser::firstWhere('user_id', Auth::id())->business_id)
                                    ->where(function($query) use ($waktu) {
                                        $query->when($waktu == 'hari_ini', function($q) {
                                           return $q->whereDate('tanggal', today()); 
                                        });
                                        $query->when($waktu == 'bulan_ini', function($q) {
                                            return $q->whereMonth('tanggal', now()->month);
                                        });
                                    })->get();

        if( Route::currentRouteName() == "api-get-pengeluaran" ) {
            return $this->sendResponse('success', "Pengeluaran $waktu", $pengeluaran, 200); 
        }
    }

    public function makePengeluaran(Request $request)
    {

        $validatedData = $request->validate([
            'tanggal'               => 'sometimes',
            'beban_id'              => 'required|exists:bebans,id',
            'deskripsi'             => 'nullable',
            'subtotal_pengeluaran'  => 'required_with:beban_id',
        ]);
        
        $pengeluaran = Pengeluaran::firstOrCreate([
            'tanggal'     => isset($validatedData['tanggal']) ? $validatedData['tanggal'] : today()->format('Y-m-d'),
            'business_id' => RoleUser::firstWhere('user_id', Auth::id())->business_id,
        ]);

        $pengeluaran->detail_pengeluaran()->create([
            'pegawai_id'            => Auth::id(),
            'beban_id'              => $validatedData['beban_id'],
            'deskripsi'             => $validatedData['deskripsi'],
            'subtotal_pengeluaran'  => $validatedData['subtotal_pengeluaran'],
        ]);
        
        if( $request->wantsJson() ) {
            $data = new PengeluaranResource($pengeluaran->fresh());
            return response()->json($data);
        }
    }
   
/* Note: Beban
    1.'Beban Gaji Karyawan',
    2.'Beban Listrik',
    3.'Beban Air',
    4.'Beban Penyewaan Gedung',
    5.'Beban Angkut Penjualan',
    6.'Harga Pokok Penjualan',
    7.'Beban Lain-Lain',
 */
}
