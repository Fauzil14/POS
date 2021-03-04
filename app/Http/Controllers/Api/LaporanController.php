<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

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
        
    }

    public function laporanStokBarang($waktu) 
    {
        $stok_barang = new Product;
        if($waktu == 'harian') {

        }
    }

    public function laporanTransPembelian($waktu) 
    {

    }

    public function laporanTransPenjualan($waktu) 
    {

    }

    public function laporanLabaRugi($waktu) 
    {

    }
}
