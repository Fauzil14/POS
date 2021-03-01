<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBebansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bebans', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_beban');
            $table->timestamps();
        });

        DB::insert("INSERT INTO bebans(jenis_beban) VALUES 
                    ('Beban Gaji Karyawan'),
                    ('Beban Listrik'),
                    ('Beban Air'),
                    ('Beban Penyewaan Gedung'),
                    ('Beban Angkut Penjualan'),
                    ('Harga Pokok Penjualan'),
                    ('Beban Lain-Lain')
                  ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bebans');
    }
}
