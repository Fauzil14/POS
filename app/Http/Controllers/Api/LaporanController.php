<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Shift;
use App\Models\Product;
use App\Models\Pembelian;
use App\Models\Penjualan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DetailPembelian;
use App\Models\DetailPenjualan;
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
            case $jenis_laporan == 'absensi_kasir' :
                $result = $this->laporanAbsensiKasir($waktu) ;
                return $this->sendResponse('success', 'Laporan absensi kasir ' . $result[0], $result[1], 200);                
                break;
        }
    }

    public function laporanStokBarang($waktu) 
    {
        $stok = Product::get();

        switch (strlen($waktu)) {
            case 10 : // full set date
                $keluar = DetailPenjualan::whereHas('penjualan', function($q) use ($waktu) {
                    return $q->finished()->date($waktu);
                })->select('product_id', 'quantity')->get();
                $masuk = DetailPembelian::whereHas('pembelian', function($q) use ($waktu) {
                    return $q->finished()->date($waktu);
                })->select('product_id', 'quantity')->get();
                $stok = $this->processStokBarang($keluar, $masuk);
                $waktu = "tanggal " . Carbon::parse($waktu)->translatedFormat('d F Y');
                break;
            case 7 : // full set month
                $keluar = DetailPenjualan::whereHas('penjualan', function($q) use ($waktu) {
                    return $q->finished()->month($waktu);
                })->select('product_id', 'quantity', 'created_at')->get()->groupBy(function($q) {
                    return $q->created_at->format('W'); // weeks
                });

                    $masuk = DetailPembelian::whereHas('pembelian', function($q) use ($waktu) {
                        return $q->finished()->month($waktu);
                    })->select('product_id', 'quantity', 'created_at')->get()->groupBy(function($q) {
                        return $q->created_at->format('W'); // weeks
                    });

                $keluar = $keluar->map(function($item, $key) {
                    $new = array_merge([ 'minggu_ke' => $key ], $this->processStokBarang($item, null));
                    return $new;
                })->values()->all();

                    $masuk = $masuk->map(function($item, $key) {
                        $new = array_merge([ 'minggu_ke' => $key ], $this->processStokBarang(null, $item));
                        return $new;
                    })->values()->all();

                $stok = [];
                foreach ($keluar as $key => $value){
                    $stok[] = array_merge((array)$masuk[$key], (array)$value);
                }
                $waktu = "bulan " . Carbon::parse($waktu)->translatedFormat('F Y');
                break;
            case 4 : // year
                $keluar = DetailPenjualan::whereHas('penjualan', function($q) use ($waktu) {
                    return $q->finished()->year($waktu);
                })->select('product_id', 'quantity', 'created_at')->get()->groupBy(function($q) {
                    return $q->created_at->format('Y-m'); // months
                });

                    $masuk = DetailPembelian::whereHas('pembelian', function($q) use ($waktu) {
                        return $q->finished()->year($waktu);
                    })->select('product_id', 'quantity', 'created_at')->get()->groupBy(function($q) {
                        return $q->created_at->format('Y-m'); // months
                    });

                $keluar = $keluar->map(function($item, $key) {
                    $new = array_merge([ 'bulan_' => Carbon::parse($key)->translatedFormat('F') ], $this->processStokBarang($item, null));
                    return $new;
                })->values()->all();

                    $masuk = $masuk->map(function($item, $key) {
                        $new = array_merge([ 'bulan_' => Carbon::parse($key)->translatedFormat('F') ], $this->processStokBarang(null, $item));
                        return $new;
                    })->values()->all();

                $stok = [];
                foreach ($keluar as $key => $value){
                    $stok[] = array_merge((array)$masuk[$key], (array)$value);
                }
                $waktu = "tahun " . Carbon::parse($waktu)->translatedFormat('Y');
                break;
        }

        return [$waktu, $stok];
    }

    public function processStokBarang($keluar = null, $masuk = null) 
    {
        if ( $keluar != null ) {
            $stok_keluar = ['stok_keluar' => $keluar->groupBy('product_id')->map(function($item, $key) {
                                $product = Product::find($key);
                                return [ 
                                    'nama_produk' => empty($product) ? 'Produk sudah di hapus' : $product->nama,
                                    'total_keluar' => $item->sum('quantity')
                                ];
                            })->values()->all()];
            
            if( $masuk == null ) {
                return $stok_keluar;
            }
            
        }

        if ( $masuk != null ) {
            $stok_masuk = ['stok_masuk' => $masuk->groupBy('product_id')->map(function($item, $key) {
                                $product = Product::find($key);
                                return [ 
                                    'nama_produk' => empty($product) ? 'Produk sudah di hapus' : $product->nama,
                                    'total_masuk' => $item->sum('quantity')
                                ];
                            })->values()->all()];

            if( $keluar == null ) {
                return $stok_masuk;
            }
        }

        return array_merge($stok_keluar, $stok_masuk);
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
        $total_penjualan = $transaksi->where('jenis_transaksi', 'penjualan')->sum('pemasukan');
        $total_pembelian = $transaksi->where('jenis_transaksi', 'pembelian')->sum('pengeluaran');
        $total_pengeluaran = $transaksi->where('jenis_transaksi', 'pengeluaran')->sum('pengeluaran');
        $laba_rugi = $total_penjualan - ($total_pembelian + $total_pengeluaran);

        return [
                'jumlah_penjualan' => count($transaksi->where('jenis_transaksi', 'penjualan')),
                'total_penjualan' => Str::decimalForm($total_penjualan, true),
                'jumlah_pembelian' => count($transaksi->where('jenis_transaksi', 'pembelian')),
                'total_pembelian' => Str::decimalForm($total_pembelian, true),
                'jumlah_pengeluaran' => count($transaksi->where('jenis_transaksi', 'pengeluaran')),
                'total_pengeluaran' => Str::decimalForm($total_pengeluaran, true),
                'laba_rugi' => Str::decimalForm($laba_rugi, true)
        ];
    }

    public function laporanAbsensiKasir($waktu) 
    {
        switch (strlen($waktu)) {
            case 10 : // full set date
                $shift = Shift::date($waktu)->get();
                $processed = $this->processAbsensiKasir($shift);
                
                $shift = $shift->map(function($item,$key) {
                    $new = $this->processAbsensiKasirByDay($item);
                    return $new;
                })->values()->all();
                $waktu = "tanggal " . Carbon::parse($waktu)->translatedFormat('d F Y');
                break;
            case 7 : // full set month
                $shift = Shift::oldest('start_time')->month($waktu)->get();
                $processed = $this->processAbsensiKasir($shift);
                $shift = $shift->map(function($item,$key) {
                    $new = $this->processAbsensiKasirByDay($item);
                    return $new;
                });
                $waktu = "bulan " . Carbon::parse($waktu)->translatedFormat('F Y');
                break;
            }
        return [$waktu, isset($processed) ? array_merge($processed, [ 'shift' => $shift ]) : [ 'shift' => $shift ]];
    }

    public function processAbsensiKasir($shift) {
        return [
            'sum_transaction_on_shift' => $shift->sum('transaction_on_shift'),
            'sum_total_penjualan_on_shift' => Str::decimalForm($shift->sum('total_penjualan_on_shift'), true)
        ];
    }

    public function processAbsensiKasirByDay($shift) {
        $new = [];
        $arr = $shift->toArray();
        foreach($arr as $key => $value) {
            
            $user = User::find($arr['kasir_id']);
            $start_time = Carbon::parse($arr['start_time']);
            $new = [
                'nama_kasir' => empty($user) ? 'Data kasir sudah tidak ada' : $user->name,
                'tanggal' => $start_time->translatedFormat('l d F Y'),
                'start_time' => $start_time->translatedFormat('H:i:s'),
                'end_time' => Carbon::parse($arr['end_time'])->translatedFormat('H:i:s'),
                'transaction_on_shift' => $arr['transaction_on_shift'],
                'total_penjualan_on_shift' => Str::decimalForm($arr['total_penjualan_on_shift'], true)
            ];
        }

        return $new;
    }


}
