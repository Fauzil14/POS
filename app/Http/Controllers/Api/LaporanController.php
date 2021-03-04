<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\Pembelian;
use App\Models\Penjualan;
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
                return $this->sendResponse('success', 'Laporan stok barang ' . $waktu, $this->laporanStokBarang($waktu), 200);
                break;
            case $jenis_laporan == 'transaksi_pembelian' : 
                return $this->sendResponse('success', 'Laporan transaksi pembelian ' . $waktu, $this->laporanTransPembelian($waktu), 200);
                break;
            case $jenis_laporan == 'transaksi_penjualan' : 
                return $this->sendResponse('success', 'Laporan transaksi penjualan ' . $waktu, $this->laporanTransPenjualan($waktu), 200);
                break;
            case $jenis_laporan == 'laba_rugi';
                return $this->sendResponse('success', 'Laporan laba rugi ' . $waktu, $this->laporanLabaRugi($waktu), 200);                
                break;
        }
    }

    public function laporanStokBarang($waktu) 
    {
        $stok = Product::get();
        return $stok;
        // $stok_barang = new Product;
        
    }

    public function laporanTransPembelian($waktu) 
    {
        $pembelian = Pembelian::get();
        return $pembelian;
    }

    public function laporanTransPenjualan($waktu) 
    {
        $penjualan = Penjualan::get();
        return $penjualan;
    }

    public function laporanLabaRugi($waktu) 
    {
        $message = 'laporanLabaRugi here';
        return $message;
    }
}
