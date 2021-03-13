<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Pembelian;
use App\Models\Penjualan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\BusinessTransaction;
use App\Http\Controllers\Controller;
use App\Http\Resources\LaporanPembelianResource;
use App\Http\Resources\LaporanPenjualanResource;

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
                $result = $this->laporanStokBarang($waktu);
            case $jenis_laporan == 'transaksi_pembelian' : 
                $result = $this->laporanPembelian($waktu);
                return $this->sendResponse('success', 'Laporan transaksi pembelian ' . $result[0], $result[1], 200);
                break;
            case $jenis_laporan == 'transaksi_penjualan' : 
                $result = $this->laporanPenjualan($waktu);
                return $this->sendResponse('success', 'Laporan transaksi penjualan ' . $result[0], $result[1], 200);
                break;
            case $jenis_laporan == 'laba_rugi' :
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

    public function laporanPenjualan($waktu) 
    {
        switch (strlen($waktu)) {
            case 10 : // full set date
                $penjualan = Penjualan::finished()->date($waktu)->get();
                $processed = $this->processPenjualan($penjualan);
                $penjualan = LaporanPenjualanResource::collection($penjualan);
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
                'jumlah_produk_terjual' => $penjualan->sum('total_produk'),
                'total_penjualan' => Str::decimalForm($penjualan->sum('total_price'), true),
                'jumlah_tunai' => $penjualan->where('jenis_pembayaran', 'tunai')->count(),
                'jumlah_debit' => $penjualan->where('jenis_pembayaran', 'debit')->count(),
        ];
    }

    public function laporanPembelian($waktu) 
    {
        switch (strlen($waktu)) {
            case 10 : // full set date
                $pembelian = Pembelian::finished()->date($waktu)->get();
                $processed = $this->processPembelian($pembelian);
                $pembelian = LaporanPembelianResource::collection($pembelian);
                $waktu = "tanggal " . Carbon::parse($waktu)->translatedFormat('d F Y');
                break;
            case 7 : // full set month
                $pembelian = Pembelian::finished()->month($waktu)->get();
                $processed = $this->processPembelian($pembelian);
                $pembelian = $pembelian->groupBy(function($pembelian) {
                    return $pembelian->created_at->format('W'); // weeks
                });
                $pembelian = $pembelian->map(function($item, $key) {
                    $new = array_merge([ 'minggu_ke' => $key ], $this->processPembelian($item));
                    return $new;
                })->values()->all();
                $waktu = "bulan " . Carbon::parse($waktu)->translatedFormat('F Y');
                break;
            case 4 : // year
                $pembelian = Pembelian::finished()->year($waktu)->get();
                $processed = $this->processPembelian($pembelian);
                $pembelian = $pembelian->groupBy(function($pembelian) {
                    return $pembelian->created_at->format('Y-m'); // month
                });
                $pembelian = $pembelian->map(function($item, $key) {
                    $new = array_merge([ 'bulan' => Carbon::parse($key)->translatedFormat('F') ], $this->processPembelian($item));
                    return $new;
                })->values()->all();
                $waktu = "tahun " . Carbon::parse($waktu)->translatedFormat('Y');
                break;
        }
        
        return [$waktu, array_merge($processed, [ 'pembelian' => $pembelian ])];
    }

    public function processPembelian($pembelian) 
    {
        return [
                'jumlah_pembelian' => count($pembelian),
                'jumlah_staff' => count($pembelian->groupBy('staff_id')),
                'jumlah_supplier' => count($pembelian->groupBy('supplier_id')),
                'jumlah_produk_dibeli' => $pembelian->sum('total_produk'),
                'total_pembelian' => Str::decimalForm($pembelian->sum('total_price'), true),
        ];
    }

    public function laporanLabaRugi($waktu) 
    {
        switch (strlen($waktu)) {
            case 10 : // full set date
                $transaksi = BusinessTransaction::date($waktu)->get();
                $processed = $this->processLabaRugi($transaksi);
                // $transaksi = LaporanPembelianResource::collection($transaksi);
                $waktu = "tanggal " . Carbon::parse($waktu)->translatedFormat('d F Y');
                break;
            case 7 : // full set month
                $transaksi = BusinessTransaction::month($waktu)->get();
                $processed = $this->processLabaRugi($transaksi);
                $transaksi = $transaksi->groupBy(function($transaksi) {
                    return $transaksi->created_at->format('W'); // weeks
                });
                $transaksi = $transaksi->map(function($item, $key) {
                    $new = array_merge([ 'minggu_ke' => $key ], $this->processLabaRugi($item));
                    return $new;
                })->values()->all();
                $waktu = "bulan " . Carbon::parse($waktu)->translatedFormat('F Y');
                break;
            case 4 : // year
                $transaksi = BusinessTransaction::year($waktu)->get();
                $processed = $this->processLabaRugi($transaksi);
                $transaksi = $transaksi->groupBy(function($transaksi) {
                    return $transaksi->created_at->format('Y-m'); // month
                });
                $transaksi = $transaksi->map(function($item, $key) {
                    $new = array_merge([ 'bulan' => Carbon::parse($key)->translatedFormat('F') ], $this->processLabaRugi($item));
                    return $new;
                })->values()->all();
                $waktu = "tahun " . Carbon::parse($waktu)->translatedFormat('Y');
                break;
        }
        
        return [$waktu, array_merge($processed, [ 'transaksi' => $transaksi ])];
    }

    public function processLabaRugi($transaksi) 
    {
        return [
                'jumlah_penjualan' => count($transaksi->where('jenis_transaksi', 'penjualan')),
                'total_penjualan' => Str::decimalForm($transaksi->where('jenis_transaksi', 'penjualan')->sum('pemasukan'), true),
                'jumlah_pembelian' => count($transaksi->where('jenis_transaksi', 'pembelian')),
                'total_pembelian' => Str::decimalForm($transaksi->where('jenis_transaksi', 'pembelian')->sum('pengeluaran'), true),

        ];
    }

}
