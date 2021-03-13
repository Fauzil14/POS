<?php

use App\Models\Member;
use App\Models\Product;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\Pengeluaran;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class PenjualanSeeder extends Seeder
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

                $penjualan = $penjualan->create([
                    'kode_transaksi' => $penjualan->kodeTransaksi($kasir_id),
                    'business_id' => 2,
                    'kasir_id' => $kasir_id,
                    'created_at' => $value
                ]);
    
                for($i = 0; $i <= 2; $i++) {
    
                    $product = Product::withoutGlobalScope('business')
                                        ->where('business_id', 2)
                                        ->where('stok', '>', 0)
                                        ->inRandomOrder()->first();
                                        
                    $quantity = rand(1,5);
                    
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

            if( $value->isSaturday() || $value->isThursday() ) { 
                $n = $value->isSaturday() ? 4 : 2;
                
                // Pembelian
                $pembelian = $pembelian->create([
                    'kode_transaksi' => $pembelian->kodeTransaksi($staff_id),
                    'business_id' => 2,
                    'staff_id' => $staff_id,
                    'created_at' => $value
                ]);

                for($i = 0; $i <= $n; $i++) {

                    $product = Product::withoutGlobalScope('business')
                                        ->where('business_id', 2)
                                        ->inRandomOrder()->first();
                    $quantity = rand(1,5);
                    $harga_beli = rand($product->harga_beli, rand(1000, 75000));
                    
                    $pembelian->detail_pembelian()->updateOrCreate([
                        'product_id'     => $product->id,
                    ],[    
                        'quantity'       => $quantity,
                        'harga_beli'     => $harga_beli,
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
                    'Beban Gaji Karyawan' => 1000000,
                    'Beban Listrik' => 500000,
                    'Beban Air' => 200000,
                    'Beban Penyewaan Gedung' => 1000000,
                    'Beban Angkut Penjualan' => 750000,
                    'Harga Pokok Penjualan' => 0,
                    'Beban Lain-Lain' => 157000,
                ];
                
                $pengeluaran = Pengeluaran::firstOrCreate([
                    'tanggal' => $value,
                    'business_id' => 2,
                ]);

                for($i = 0; $i <= 6; $i++) {
                    if( $i != 5 ) {
                        $pengeluaran->detail_pengeluaran()->updateOrCreate([
                            'pegawai_id' => $staff_id,
                            'beban_id' => $i+1,
                            'deskripsi' => array_search($desc[$i], $desc), // return key of the array
                            'subtotal_pengeluaran' => $desc[$i],
                        ]);
                    } else {
                        continue;
                    }
                }
            }
        } 
    }
}
