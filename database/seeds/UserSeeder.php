<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeds = [
                    [
                        'name'              => 'fauzil',
                        'email'             => 'fauzil@gmail.com',
                        'email_verified_at' => now(),
                        'password'          => Hash::make('password'),
                        'umur'              => 23,
                        'alamat'            => 'payakumbuh',
                    ],
                    [
                        'name'              => 'rais',
                        'email'             => 'rais@gmail.com',
                        'email_verified_at' => now(),
                        'password'          => Hash::make('password'),
                        'umur'              => 18,
                        'alamat'            => 'yogyakarta',
                    ],
                    [
                        'name'              => 'pimpinan',
                        'email'             => 'pimpinan@gmail.com',
                        'email_verified_at' => now(),
                        'password'          => Hash::make('password'),
                        'umur'              => 40,
                        'alamat'            => 'Jakarta',
                    ],
                    [
                        'name'              => 'kasir',
                        'email'             => 'kasir@gmail.com',
                        'email_verified_at' => now(),
                        'password'          => Hash::make('password'),
                        'umur'              => 20,
                        'alamat'            => 'DIY',
                    ],
                    [
                        'name'              => 'staff',
                        'email'             => 'staff@gmail.com',
                        'email_verified_at' => now(),
                        'password'          => Hash::make('password'),
                        'umur'              => 30,
                        'alamat'            => 'DI Yogyakarta',
                    ],
                 ];

        // 1 = admin 
        // 2 = pimpinan 
        // 3 = kasir 
        // 4 = staff
                 
        $roles = [1, 1, 2, 3, 4];

        $user = new User;
        foreach($seeds as $key => $value) {
            $user->create($value)->assignRole($roles[$key]);
        }

    }
}
