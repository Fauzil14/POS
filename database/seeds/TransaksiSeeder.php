<?php

use Carbon\Carbon;
use App\Models\Member;
use App\Models\Product;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\Pengeluaran;
use Illuminate\Database\Seeder;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

        $first_day = Carbon::parse('first day of January 2021');
        $last_day  = Carbon::parse('last day of February 2021');

        function dateRange( $first, $last, $step = '+1 day', $format = 'Y-m-d' ) {

            $dates = array();
            $current = strtotime( $first );
            $last = strtotime( $last );
        
            while( $current <= $last ) {
        
                $dates[] = Carbon::parse($current);
                $current = strtotime( $step, $current );
            }
        
            return $dates;
        }

        $dateRange = dateRange($first_day, $last_day);

        $penjualan = new Penjualan;
        $pembelian = new Pembelian;
        $kasir_id = rand(4,5);
        $staff_id = rand(6,7);

        foreach($dateRange as $key => $value) {
            $x = rand(1, 4);
            for($i = 1; $i <= $x; $i++) {
                $penjualan = $penjualan->firstOrCreate([
                    'kode_transaksi' => $penjualan->kodeTransaksi($kasir_id),
                    'business_id' => 2,
                    'kasir_id' => $kasir_id,
                    'created_at' => $value
                ]);
    
                for($a = 0; $a <= 2; $a++) {

                    $quantity = rand(1,3);
    
                    $product = Product::withoutGlobalScope('business')
                                        ->where('business_id', 2)
                                        ->where('stok', '>=', $quantity)
                                        ->inRandomOrder()->first();
                    
                    $penjualan->detail_penjualan()->updateOrCreate([
                        'product_id'     => $product->id,
                    ],[    
                        'quantity'       => $quantity,
                        'harga_jual'     => $product->harga_jual,
                        'diskon'         => $product->diskon ,
                        'subtotal_harga' => is_null($product->diskon) 
                                            ? $quantity * $product->harga_jual 
                                            : ($quantity * $product->harga_jual) - (($product->harga_jual * $product->diskon) / 100),
                    ]);
                }
    
                $penjualan->refresh();
                $member = Member::inRandomOrder()->first();
                $member_id = rand(null, $member->id);
                $penjualan->update([
                    'member_id' => $member_id == 0 ? null : $member_id,
                    'jenis_pembayaran' => 'tunai',
                    'dibayar' => $penjualan->total_price,
                    'status' => 'finished',
                ]);
            }

            if( $value->isSaturday() || $value->isThursday() ) { 
                $n = $value->isSaturday() ? 4 : 2;
                
                // Pembelian
                $pembelian = $pembelian->create([
                    'kode_transaksi' => $pembelian->kodeTransaksi($staff_id),
                    'business_id' => 2,
                    'staff_id' => $staff_id,
                    'created_at' => $value
                ]);

                for($b = 0; $b <= $n; $b++) {

                    $product_pembelian = Product::withoutGlobalScope('business')
                                        ->where('business_id', 2)
                                        ->where(function($query) {
                                            return $query->where('stok', '<', 20)
                                                            ->orWhere('stok', '<', 100)
                                                            ->orWhere('stok', '>=', 100);
                                        })
                                        ->inRandomOrder()->first();
                    $quantity = rand(5, 50);
                    $harga_beli = rand($product_pembelian->harga_beli - rand(1000, 3000), $product_pembelian->harga_beli + rand(1000, 3000));

                    $pembelian->detail_pembelian()->updateOrCreate([
                        'product_id'     => $product_pembelian->id,
                    ],[    
                        'quantity'       => $quantity,
                        'harga_beli'     => $harga_beli,
                        'harga_jual'     => empty($product_pembelian->diskon) 
                                                ? $harga_beli + 3000 
                                                : $harga_beli + (($harga_beli * ($product_pembelian->diskon + 10) / 100)),
                        'subtotal_harga' => $quantity * $harga_beli 
                    ]);
                }

                $pembelian->refresh();
                $pembelian->update([
                    'status' => 'finished',
                ]);
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
            if( $value->isSaturday('last week of ' . $value->format('F Y'))) {
                $desc = [
                    'Beban Gaji Karyawan',
                    'Beban Listrik',
                    'Beban Air',
                    'Beban Penyewaan Gedung',
                    'Beban Angkut Penjualan',
                    'Harga Pokok Penjualan',
                    'Beban Lain-Lain',
                ];

                $sbt = [
                    500000,
                    250000,
                    100000,
                    750000,
                    500000,
                    0,
                    157000,
                ];
                
                $pengeluaran = Pengeluaran::firstOrCreate([
                    'tanggal' => $value,
                    'business_id' => 2,
                ]);

                for($c = 0; $c <= 6; $c++) {
                    if( $c != 5 ) {
                        $pengeluaran->detail_pengeluaran()->updateOrCreate([
                            'pegawai_id' => $staff_id,
                            'beban_id' => $c+1,
                            'deskripsi' => $desc[$c], // return key of the array
                            'subtotal_pengeluaran' => $sbt[$c],
                        ]);
                    } else {
                        continue;
                    }
                }
            }
        }
    }
}
