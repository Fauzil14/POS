<?php

use App\Models\Member;
use App\Helpers\CodeGenerator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemberSeeder extends Seeder
{
    // use CodeGenerator;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $raws = [
            [
                'nama'         => 'Hartana Pangestu',
                'no_telephone' => '069332032283',   
                'saldo'        => rand(50000, 2000000)
            ],
            [
                'nama'         => 'Saadat Wibisono',
                'no_telephone' => '08317380297',   
                'saldo'        => rand(50000, 2000000)
            ],
            [
                'nama'         => 'Enteng Cakrabuana Wahyudin',
                'no_telephone' => '055446912624',   
                'saldo'        => rand(50000, 2000000)
            ],
            [
                'nama'         => 'Paiman Darimin Simanjuntak',
                'no_telephone' => '(+62)4569267493',   
                'saldo'        => rand(50000, 2000000)
            ],
            [
                'nama'         => 'Mujur Rajata',
                'no_telephone' => '07521192821',   
                'saldo'        => rand(50000, 2000000)
            ],
        ];

        $member = new Member;
        foreach($raws as $raw) {
            $member->create($raw);
        }

    }
}
