<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $seed = [
            [ 'category_name' => 'alat tulis' ], //1
            [ 'category_name' => 'sembako' ], //2
            [ 'category_name' => 'peralatan mandi dan mencuci' ], //3
            [ 'category_name' => 'jajanan dan makanan ringan' ], //4
            [ 'category_name' => 'minuman' ], //5
            [ 'category_name' => 'perlengkapan rumah tangga' ], //6
            [ 'category_name' => 'obat-obatan' ], //7
            [ 'category_name' => 'gas elpiji' ], //8
            [ 'category_name' => 'keperluan bayi' ], //9
            [ 'category_name' => 'lain-lain' ], //10
        ];

        DB::table('categories')->insert($seed);
    }
}
