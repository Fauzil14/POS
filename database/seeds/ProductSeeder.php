<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $raws = [
            [ "7118441101378", 2, "ABC", "ABC KECAP MANIS POUCH 600ML" ],
            [ "8991002101654", 5, "ABC", "ABC KOPI SUSU BAG 20X32G" ],
            [ "711844330207", 2, "ABC", "ABC MACKEREL TOMATO 155GR" ],
            [ "711844120013", 4, "ABC", "ABC SAMBAL ASLI 340ML" ],
            [ "711844120075", 4, "ABC", "ABC SAMBAL EXTRA PEDAS 415ML" ],
            [ "711844120099", 4, "ABC", "ABC SAMBAL MANIS PEDAS 415ML" ],
            [ "711844130012", 4, "ABC", "ABC TOMATO KETCHUP 340ML" ],
            [ "9415007006329", 5, "ANLENE", "ANLENE MILK ACTIFIT 600 GR" ],
            [ "9415007009146", 5, "ANLENE", "ANLENE MILK GOLD 51+ 600 ML" ],
            [ "8992779022203", 6, "AXI", "AXI PEMBERSIH LANTAI APPLE GREEN POUCH 800ML" ],
            [ "8993169221008", 2, "AYAM JAGO", "AYAM JAGO BERAS WANGI BIRU 10 KG",  ],
            [ "8993169762051", 2, "AYAM JAGO", "AYAM JAGO BERAS WANGI BIRU 5 KG",  ],
            [ "8990121014029", 4, "BANGO", "BANGO KECAP MANIS PET 300ML" ],
            [ "8999999101190", 4, "BANGO", "BANGO KECAP MANIS POUCH 225ML" ],
            [ "8999999100506", 4, "BANGO", "BANGO KECAP MANIS POUCH 600 ML" ],
            [ "8998899013077", 6, "BAYCLIN", "BAYCLIN REGULER 500ML" ],
            [ "8998899001067", 10, "BAYGON", "BAYGON AE BIRU FTH DENGUE 600ML (63056)" ],
            [ "8998899001135", 10, "BAYGON", "BAYGON AEROSOL HIJAU 750ML" ],
            [ "8998899001210", 10, "BAYGON", "BAYGON OILSPRAY BTL 900ML" ],
            [ "8992696404441", 5, "BEAR BRAND", "BEAR BRAND TIN 195GR",  ],
            [ "8990057779023", 5, "BEBELAC", "BEBELAC 2 BOX 400G" ],
            [ "8990057780036", 5, "BEBELAC", "BEBELAC 3 MADU BOX 400G" ],
            [ "8990057780029", 5, "BEBELAC", "BEBELAC 3 SUSU PERTUMBUHAN W/DHA VANILA BOX 400G" ],
            [ "8990057782061", 5, "BEBELAC", "BEBELAC 4 SUSU PERTUMBUHAN VANILA 400 GR" ],
            [ "8992753282500", 5, "BENDERA", "BENDERA 123 CHOCO BOX 600GR" ],
            [ "8992753283507", 5, "BENDERA", "BENDERA 123 MADU BOX 600GR" ],
            [ "8992753281701", 5, "BENDERA", "BENDERA 123 VANILA 900 GR" ],
            [ "8992753882502", 5, "BENDERA", "BENDERA 456 CHOCO BOX 600GR" ],
            [ "8992753150809", 5, "BENDERA", "BENDERA BUBUK INSTANT 1000 GR" ],
            [ "8992753120307", 5, "BENDERA", "BENDERA FULL CREAM 400 GR" ],
            [ "8992753100101", 5, "BENDERA", "BENDERA SUSU KENTAL MANIS 385 GR" ],
            [ "8886001038011", 4, "BENG BENG", "BENG BENG WAFER CHOCOLATE 20 GR",  ],
            [ "8992628020152", 2, "BIMOLI", "BIMOLI OIL POUCH 2LT" ],
            [ "8992727001724", 3, "BIORE", "BIORE BODY FOAM DAILY ANTISEPTIC POUCH 450ML" ],
            [ "8992727001700", 3, "BIORE", "BIORE BODY FOAM PURE MILD POUCH 450ML" ],
            [ "8992727000673", 3, "BIORE", "BIORE F/FOAM ENERGIZING COOL 100G" ],
            [ "8992727000635", 3, "BIORE", "BIORE F/FOAM PURE MILD 100G" ],
            [ "8992727001182", 3, "BIORE", "BIORE FACIAL ANTI ACNE 100G" ],
            [ "8999999197049", 2, "BLUE BAND", "BLUE BAND MARGARINE 250GR",  ],
            [ "8999999198862", 2, "BLUE BAND", "BLUE BAND MARGARINE SACHET 200GR" ],
            [ "8998866605199", 3, "BOOM", "BOOM POWDER DET 600 GR" ],
            [ "4902931110185", 2, "BOTAN", "BOTAN MACKAREL KECIL 155GR" ],
            [ "4902931110482", 2, "BOTAN", "BOTAN SARDINES PREMIUM KECIL 155GR" ],
        ];

        
        foreach($raws as $raw) {
            $harga_beli = rand(300, 100000);
            $diskon = rand(0, 50);
            $harga_jual = round($harga_beli + (($harga_beli * ($diskon + 10) / 100)), 0, PHP_ROUND_HALF_UP);

            $seed[] = [
                        'nama' => $raw[3],
                        'UID' => $raw[0],
                        'harga_beli' => $harga_beli,
                        'harga_jual' => $harga_jual,
                        'category_id' => $raw[1],
                        'supplier_id' => rand(1, 19),
                        'merek' => $raw[2],
                        'stok' => rand(0, 50),
                        'diskon' => $diskon,
                        'created_at' => now(),
                        'updated_at' => now(),
                      ];
        }

        DB::table('products')->insert($seed);
    }
}
