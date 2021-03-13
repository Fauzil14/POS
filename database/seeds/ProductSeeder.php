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
            [ '8991001301031', 4, 'CERES', "CERES HAGELSLAG CLASSIC 225GR"],
            [ '8991001302274', 4, 'CERES', "CERES HAGELSLAG MILK 225GR"],
            [ '089686600841', 4, 'CHEETOS', "CHEETOS NET SEAWEED 70GR"],
            [ '089686600247', 4, 'CHEETOS', "CHEETOS ROASTED CORN 48GR"],
            [ '089686590135', 4, 'CHIKI', "CHIKI BALLS CHICKEN 12 GR"],
            [ '089686598056', 4, 'CHITATO', "CHITATO BEEF BBQ 75GR"],
            [ '089686598315', 4, 'CHITATO', "CHITATO PLAIN SALT 19GR"],
            [ '8999999711849', 3, 'CITRA', "CITRA BODY LOTION MANGIR 120ML"],
            [ '8999999717858', 3, 'CITRA', "CITRA BODY LOTION WHITE 120ML"],
            [ '8991111112114', 3, 'CLEAN', "CLEAN&CLEAR ACNE CLEARING CLEANSER 100G"],
            [ '8999999715250', 3, 'CLEAR', "CLEAR MAN SHAMPOO ACTIV 180 ML"],
            [ '8899999971569', 3, 'CLEAR', "CLEAR SHAMPOO CLEAN&ITCH CTRL 90ML"],
            [ '8999999715892', 3, 'CLEAR', "CLEAR SHAMPOO CPLT SOFTCARE 180 ML"],
            [ '8999999715748', 3, 'CLEAR', "CLEAR SHAMPOO HAIRFALL DEFENSE 180 ML"],
            [ '8999999715847', 3, 'CLEAR', "CLEAR SHAMPOO ICE COOL 180 ML"],
            [ '8999999712839', 3, 'CLEAR', "CLEAR SHMP ACTIVE CARE 200ML"],
            [ '8999999712884', 3, 'CLEAR', "CLEAR SHMP HAIR FALL 200ML"],
            [ '8999999712921', 3, 'CLEAR', "CLEAR SHMP ICE COOL 200ML"],
            [ '8999999713577', 3, 'CLEAR', "CLEAR SHP CPLT SOFTCARE 7.5ML X 12"],
            [ '8999999715786', 3, 'CLEAR', "CLEAR SHP HAIRFALL DEFENSE 5ML X 12"],
            [ '8999999715861', 3, 'CLEAR', "CLEAR SHP ICE COOL 5ML X 12"],
            [ '011747233033',  4, 'D/K', "D/K KACANG KULIT 250 GR"],
            [ '8998866607353', 3, 'DAIA', "DAIA DET SEGAR PUTIH I KG"],
            [ '8998866601436', 3, 'DAIA', "DAIA DET SENSASI BUNGA 1 KG"],
            [ '8992696405578', 5, 'DANCOW', "DANCOW 1+ MADU DHA 400GR"],
            [ '8992696405585', 5, 'DANCOW', "DANCOW 1+ MADU DHA 800GR"],
            [ '8992696405530', 5, 'DANCOW', "DANCOW 1+ PLAIN DHA 800GR"],
            [ '8992696407619', 5, 'DANCOW', "DANCOW 3+ COKLAT 800GR"],
            [ '8992696407039', 5, 'DANCOW', "DANCOW 3+ MADU DHA 400GR"],
            [ '8992696407701', 5, 'DANCOW', "DANCOW 3+ VANILLA DHA 800GR"],
            [ '8992696418905', 5, 'DANCOW', "DANCOW BATITA MILK 500 GR"],
            [ '8992696405486', 5, 'DANCOW', "DANCOW FULL CREAM BOX 400GR"],
            [ '8992696405448', 5, 'DANCOW', "DANCOW INSTANT BOX 800GR"],
            [ '8992716108724', 4, 'DANONE', "DANONE BISKUAT ENERGI COKLAT KRIM 49,5 GR"],
            [ '8992716108496', 4, 'DANONE', "DANONE BISKUAT SUSU KRIM 57GR"],
            [ '8993560026011', 3, 'DETTOL', "DETTOL SHOWER FOAM FRS POUCH 250 ML"],
            [ '8999999717308', 3, 'DOVE', "DOVE FF BEAUTY MOIST 100 ML"],
            [ '8999999717292', 3, 'DOVE', "DOVE FF FRESH MOIST 100ML"],
            [ '8999999716806', 3, 'DOVE', "DOVE SHAMPOO ANTI DANDRUF 180 ML"],
            [ '8999999719920', 3, 'DOVE', "DOVE SHAMPOO HAIRFALLTHERAPY 180 ML"],
            [ '8998866671729', 3, 'EKONOMI', "EKONOMI SABUN CREAM ANTI NODA 340GR"],
            [ '8998866100601', 3, 'EMERON', "EMERON SHP ALOE VERA 200 ML"],
            [ '8998866103121', 3, 'EMERON', "EMERON SHP ANTI DANDRUFF 200 ML"],
            [ '8998866104418', 3, 'EMERON', "EMERON SHP MELON & MINT 200 ML"],
            [ '8886001100305', 4, 'ENERGEN', "ENERGEN CHOCOLATE BOX 5 X 32 GR"],
            [ '8886001100909', 4, 'ENERGEN', "ENERGEN VANILA BOX 5 X 32 GR"],
            [ '8992826111089', 2, 'FILMA', "FILMA M/GORENG NON KOLESTEROL POUCH 2LT"],
            [ '8991102100434', 3, 'FORMULA', "FORMULA PG AKSI PUTIH 200GR"],
            [ '8991102023238', 3, 'FORMULA', "FORMULA TOOTH BRUSH ZAP HELM MEDIUM"]

        ];

        
        foreach($raws as $raw) {
            $harga_beli = rand(300, 50000);
            $diskon = rand(1, 50);
            $harga_jual = $harga_beli + (($harga_beli * ($diskon + 10) / 100));

            $seed[] = [
                        'business_id' => 2,
                        'nama' => $raw[3],
                        'uid' => $raw[0],
                        'harga_beli' => $harga_beli,
                        'harga_jual' => $harga_jual,
                        'category_id' => $raw[1],
                        'supplier_id' => rand(1, 19),
                        'merek' => $raw[2],
                        'stok' => rand(300, 1000),
                        'diskon' => $diskon,
                        'created_at' => now(),
                        'updated_at' => now(),
                      ];
        }

        DB::table('products')->insert($seed);
    }
}
