<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Pembelian;
use App\Models\Penjualan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LaporanController extends Controller
{
    /* 
     *   Harian | Bulanan
     *   1. Stok Barang
     *   2. Transaksi Pembelian
     *   3. Transaksi Penjualan
     *   $. Laba/Rugi
    */
    public function getLaporan($jenis_laporan, $waktu) 
    {

        switch ($jenis_laporan) {
            case $jenis_laporan == 'stok_barang' :
                $result = $this->laporanStokBarang($waktu);
                return $this->sendResponse('success', 'Laporan stok barang ' . $result[0], $result[1], 200);
                break;
            case $jenis_laporan == 'transaksi_pembelian' : 
                $result = $this->laporanPembelian($waktu);
                return $this->sendResponse('success', 'Laporan transaksi pembelian ' . $result[0], $result[1], 200);
                break;
            case $jenis_laporan == 'transaksi_penjualan' : 
                $result = $this->laporanPenjualan($waktu);
                return $this->sendResponse('success', 'Laporan transaksi penjualan ' . $result[0], $result[1], 200);
                break;
            case $jenis_laporan == 'laba_rugi';
                $result = $this->laporanLabaRugi($waktu);
                return $this->sendResponse('success', 'Laporan laba rugi ' . $result[0], $result[1], 200);                
                break;
        }
    }

    public function laporanStokBarang($waktu) 
    {
        $stok = Product::get();
        return $stok;
    }

    public function laporanPembelian($waktu) 
    {
        $pembelian = Pembelian::get();
        return $pembelian;
    }

    public function laporanPenjualan($waktu) 
    {
        switch (strlen($waktu)) {
            case 10 : // full set date
                $penjualan = Penjualan::finished()->date($waktu)->get();
                $processed = $this->processPenjualan($penjualan);
                $waktu = "tanggal " . Carbon::parse($waktu)->translatedFormat('d F Y');
                break;
            case 7 : // full set month
                $penjualan = Penjualan::finished()->month($waktu)->get();
                $processed = $this->processPenjualan($penjualan);
                $penjualan = $penjualan->groupBy(function($penjualan) {
                    return $penjualan->created_at->format('W'); // weeks
                });
                $penjualan = $penjualan->map(function($item, $key) {
                    $new = array_merge([ 'minggu_ke' => $key ], $this->processPenjualan($item));
                    return $new;
                })->values()->all();
                $waktu = "bulan " . Carbon::parse($waktu)->translatedFormat('F Y');
                break;
            case 4 : // year
                $penjualan = Penjualan::finished()->year($waktu)->get();
                $processed = $this->processPenjualan($penjualan);
                $penjualan = $penjualan->groupBy(function($penjualan) {
                    return $penjualan->created_at->format('Y-m'); // month
                });
                $penjualan = $penjualan->map(function($item, $key) {
                    $new = array_merge([ 'bulan' => Carbon::parse($key)->translatedFormat('F') ], $this->processPenjualan($item));
                    return $new;
                })->values()->all();
                $waktu = "tahun " . Carbon::parse($waktu)->translatedFormat('Y');
                break;
        }
        
        return [$waktu, array_merge($processed, [ 'penjualan' => $penjualan ])];
    }

    public function processPenjualan($penjualan) 
    {
        return [
                'jumlah_penjualan' => count($penjualan),
                'jumlah_kasir' => count($penjualan->groupBy('kasir_id')),
                'transaksi_member' => $penjualan->where('member_id', '!=', null)->count(),
                'transaksi_non_member' => $penjualan->where('member_id', null)->count(),
                'total_penjualan' => Str::decimalForm($penjualan->sum('total_price'), true),
                'jumlah_tunai' => $penjualan->where('jenis_pembayaran', 'tunai')->count(),
                'jumlah_debit' => $penjualan->where('jenis_pembayaran', 'debit')->count(),
        ];
    }

    public function laporanLabaRugi($waktu) 
    {
        $message = 'laporanLabaRugi here';
        return $message;
    }
}
