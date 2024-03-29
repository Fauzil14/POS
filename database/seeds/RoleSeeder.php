<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 
        DB::table('roles')->insert([
            [ 'role_name' => 'admin' ],
            [ 'role_name' => 'pimpinan' ],
            [ 'role_name' => 'kasir' ],
            [ 'role_name' => 'staff' ],
        ]);   
    }
}
