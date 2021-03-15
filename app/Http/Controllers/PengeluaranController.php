<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Beban;
use App\Models\RoleUser;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\DetailPengeluaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Resources\PengeluaranResource;

class PengeluaranController extends Controller
{
    public function index() 
    {
        $pengeluarans = DetailPengeluaran::whereHas('pengeluaran', function ($q) {
            $q->where('business_id', Auth::user()->roles->pluck('pivot.business_id')->first());
        })->get();

        $bebans = Beban::get();

        return view('pengeluaran.index', compact('pengeluarans', 'bebans'));
    }

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


    /* Note: Beban
        1.'Beban Gaji Karyawan',
        2.'Beban Listrik',
        3.'Beban Air',
        4.'Beban Penyewaan Gedung',
        5.'Beban Angkut Penjualan',
        6.'Harga Pokok Penjualan',
        7.'Beban Lain-Lain',
    */
    public function makePengeluaran(Request $request)
    {

        $validatedData = $request->validate([
            'tanggal'               => 'sometimes',
            'beban_id'              => 'required|exists:bebans,id',
            'deskripsi'             => 'nullable',
            'subtotal_pengeluaran'  => 'required_with:beban_id',
        ]);

        if( isset($validatedData['tanggal']) ) {
            $tanggal = Carbon::parse($validatedData['tanggal'])->format('Y-m-d');
        }

        $pengeluaran = Pengeluaran::firstOrCreate([
            'tanggal'     => isset($tanggal) ? $tanggal : today()->format('Y-m-d'),
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

    public function update(Request $request)
    {
        $detail_pengeluaran = DetailPengeluaran::findOrFail($request->id);

        $validatedData = $request->validate([
            'tanggal' => ['required'],
            'beban_id' => ['required', 'exists:bebans,id'],
            'deskripsi' => ['sometimes'],
            'subtotal_pengeluaran' => ['required'],
        ]);

        if(isset($validatedData['tanggal'])) {
            Pengeluaran::where('id', $detail_pengeluaran->pengeluaran_id)->update(['tanggal' => $validatedData['tanggal']]);
        }

        $detail_pengeluaran->update($validatedData);
        $detail_pengeluaran->refresh();

        return response()->json([
            'tanggal' => Carbon::parse($detail_pengeluaran->pengeluaran->tanggal)->format('d-m-Y'),
            'nama_pegawai' => $detail_pengeluaran->pegawai->name,
            'jenis_beban' => $detail_pengeluaran->beban->jenis_beban,
            'deskripsi' => $detail_pengeluaran->deskripsi,
            'subtotal_pengeluaran' => $detail_pengeluaran->subtotal_pengeluaran
        ]);
    }

    public function show($detail_pengeluaran_id)
    {
        $pengeluaran = DetailPengeluaran::findOrFail($detail_pengeluaran_id);
        $bebans = Beban::get();
        $pengeluaran->load('pegawai','beban');
        return view('pengeluaran.detail-pengeluaran', compact('pengeluaran', 'bebans'));
    }

    public function delete($detail_pengeluaran_id)
    {
        $detail_pengeluaran = DetailPengeluaran::findOrFail($detail_pengeluaran_id);

        try {
            $detail_pengeluaran->delete();
    
            Alert::success('Berhasil', 'Pengeluaran berhasil di hapus');
            return redirect()->route('pengeluaran');
        } catch(\Throwable $e) {
            Alert::error('Gagal', 'Pengeluaran gagal di hapus');
            return back();
        }
    }
   
}
