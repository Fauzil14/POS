<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeuanganBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keuangan_businesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained('businesses');
            $table->bigInteger('pemasukan')->default(0);
            $table->bigInteger('pengeluaran')->default(0);
            $table->bigInteger('saldo')->default(10000000);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keuangan_businesses');
    }
}
