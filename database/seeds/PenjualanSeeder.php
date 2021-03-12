<?php

use App\Models\Member;
use App\Models\Product;
use App\Models\Penjualan;
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
        dd($product = Product::withoutGlobalScope('business')->where('business_id', 2)->where('stok', '>', 0)->get());

        $penjualan = new Penjualan;
        $kasir_id = rand(4,5);

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

        foreach($dateRange as $key => $value) {
            $penjualan = $penjualan->create([
                'kode_transaksi' => $penjualan->kodeTransaksi($kasir_id),
                'business_id' => 2,
                'kasir_id' => $kasir_id,
                'created_at' => $value
            ]);

            for($i = 0; $i <= 2; $i++) {

                $product = Product::withoutGlobalScope('business')->where('stok', '>', 0)->inRandomOrder()->first();
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
        } 
    }
}
