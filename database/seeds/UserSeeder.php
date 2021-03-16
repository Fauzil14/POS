<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pegawai_seeds = [
                    [
                        'name'              => 'fauzil',
                        'email'             => 'fauzil@gmail.com',
                        'email_verified_at' => now(),
                        'password'          => 'password',
                        'umur'              => 23,
                        'alamat'            => 'payakumbuh',
                    ],
                    [
                        'name'              => 'rais',
                        'email'             => 'rais@gmail.com',
                        'email_verified_at' => now(),
                        'password'          => 'password',
                        'umur'              => 18,
                        'alamat'            => 'yogyakarta',
                    ],
                    [
                        'name'              => 'pimpinan',
                        'email'             => 'pimpinan@gmail.com',
                        'email_verified_at' => now(),
                        'password'          => 'password',
                        'umur'              => 40,
                        'alamat'            => 'Jakarta',
                    ],
                    [
                        'name'              => 'kasir',
                        'email'             => 'kasir@gmail.com',
                        'email_verified_at' => now(),
                        'password'          => 'password',
                        'umur'              => 20,
                        'alamat'            => 'DIY',
                    ],
                    [
                        'name'              => 'kasir 2',
                        'email'             => 'kasir2@gmail.com',
                        'email_verified_at' => now(),
                        'password'          => 'password',
                        'umur'              => 22,
                        'alamat'            => 'DIY',
                    ],
                    [
                        'name'              => 'staff',
                        'email'             => 'staff@gmail.com',
                        'email_verified_at' => now(),
                        'password'          => 'password',
                        'umur'              => 30,
                        'alamat'            => 'DI Yogyakarta',
                    ],
                    [
                        'name'              => 'staff 2',
                        'email'             => 'staff2@gmail.com',
                        'email_verified_at' => now(),
                        'password'          => 'password',
                        'umur'              => 29,
                        'alamat'            => 'DI Yogyakarta',
                    ],
                    
                 ];

        // 1 = admin 
        // 2 = pimpinan 
        // 3 = kasir 
        // 4 = staff
                 
        $roles = ['admin', 'admin', 'pimpinan', 'kasir', 'kasir', 'staff', 'staff'];

        $user = new User;
        foreach($pegawai_seeds as $key => $value) {
            $user->create($value)->assignRole($roles[$key], 2);
        }

        $seeds = [
            [
                'name'              => 'pengusaha',
                'email'             => 'pengusaha@gmail.com',
                'email_verified_at' => now(),
                'password'          => 'password',
                'umur'              => 30,
                'alamat'            => 'payakumbuh',
            ],
            [
                'name'              => 'pengusaha1',
                'email'             => 'pengusaha1@gmail.com',
                'email_verified_at' => now(),
                'password'          => 'password',
                'umur'              => 26,
                'alamat'            => 'payakumbuh',
            ],
        ];

        foreach($seeds as $seed) {
            $user->create($seed);
        }


    }
}
