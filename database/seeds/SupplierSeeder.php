<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $raws = [
            [
                'nama_supplier' => 'CV Bangun Mandiri',
                'alamat_supplier' => 'Jl Bugisan Selatan 334 Yogyakarta',
                'telepon_supplier' => '0274380457'
            ],
            [
                'nama_supplier' => 'PT Cemako Mandiri Corp',
                'alamat_supplier' => 'Jl Ring Road Barat RT 04 RW 29 Yogyakarta',
                'telepon_supplier' => '0274620903'
            ],
            [
                'nama_supplier' => 'UD Eka Maju',
                'alamat_supplier' => 'Jl Sunten 294 RT 08 RW 32 Yogyakarta',
                'telepon_supplier' => '0274383883'
            ],
            [
                'nama_supplier' => 'PT Faretina',
                'alamat_supplier' => 'Jl Tegalrejo 50 A Yogyakarta',
                'telepon_supplier' => '0274417417'
            ],
            [
                'nama_supplier' => 'PT Intermas Tata Trading',
                'alamat_supplier' => 'Jl Imogiri Km 4 / 24 Yogyakarta',
                'telepon_supplier' => '0274414182'
            ],
            [
                'nama_supplier' => 'PT Niramas Utama Niaga',
                'alamat_supplier' => 'Jl Mangkuyudan 36 D Yogyakarta',
                'telepon_supplier' => '0274375960'
            ],
            [
                'nama_supplier' => 'Sari Kencana Ltd',
                'alamat_supplier' => 'Jl Sidobali 11 Yogyakarta',
                'telepon_supplier' => '0274540958'
            ],
            [
                'nama_supplier' => 'PT Sari Makmur Sanjaya',
                'alamat_supplier' => 'Jl Pakuningratan 1-2 Yogyakarta',
                'telepon_supplier' => '0274517944'
            ],
            [
                'nama_supplier' => 'PT Trio Hutama',
                'alamat_supplier' => 'Jl Ring Road Selatan 112 Yogyakarta',
                'telepon_supplier' => '0274450653'
            ],
            [
                'nama_supplier' => 'Wicaksana Overseas International PT Tbk',
                'alamat_supplier' => 'Jl Cibadak 261 Yogyakarta',
                'telepon_supplier' => '02746011017'
            ],
            [
                'nama_supplier' => 'Oentung Abadi Group',
                'alamat_supplier' => 'Gang Manyar No. 1 Yogyakarta DIY', 
                'telepon_supplier' => '0274551528'
            ],
            [
                'nama_supplier' => 'Depo Fadhilla – agen distribusi ice cream Indoeskrim',
                'alamat_supplier' => 'Jongkang Rt 07 Rw 30 No 109 Yogyakarta',
                'telepon_supplier' => '0274867959'
            ],
            [
                'nama_supplier' => 'Yappindopenjualan daging sapi',
                'alamat_supplier' => 'Jl. Raya Tajem Maguwoharjo Sleman DIY',
                'telepon_supplier' => '02744462713'
            ],
            [
                'nama_supplier' => 'Rumah Bakso',
                'alamat_supplier' => 'Jl. Sawojajar No 3 Wijilan Yogyakarta',
                'telepon_supplier' => '02749610999'
            ],
            [
                'nama_supplier' => 'UD Interutama Sakti',
                'alamat_supplier' => 'Jl Pringgokusuman 2 RT 024/06 Yogyakarta',
                'telepon_supplier' => '0274582566'
            ],
            [
                'nama_supplier' => 'CV Lima Saudara Sejahtera',
                'alamat_supplier' => 'Jl Wates Kadipiro Baru DK V RT 006/13 Yogyakarta',
                'telepon_supplier' => '0274626980'
            ],
            [
                'nama_supplier' => 'PT Madistrindo Abadi',
                'alamat_supplier' => 'Jl Palagan Tentara Pelajar 25 Yogyakarta',
                'telepon_supplier' => '0274889372'
            ],
            [
                'nama_supplier' => 'PT Matolindo Primantara',
                'alamat_supplier' => 'Jl Dr Sutomo Gedung Bioskop Mataram Blok A-9/57 Yogyakarta',
                'telepon_supplier' => '0274544068'
            ],
            [
                'nama_supplier' => 'PT Mitra Sehati Sekata',
                'alamat_supplier' => 'Jl Parangtritis Km 4,5 Yogyakarta',
                'telepon_supplier' => '0274450838'
            ]        
        ];

        foreach ($raws as $raw) {
            $seeds[] = array_merge($raw, [
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        DB::table('suppliers')->insert($seeds);
    }
}
