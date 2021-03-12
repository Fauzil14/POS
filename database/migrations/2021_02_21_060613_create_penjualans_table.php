<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi');
            $table->foreignId('business_id')->constrained('businesses')->onDelete('cascade');
            $table->foreignId('kasir_id')->nullable()->constrained('users')->onDelete('SET NULL');
            $table->foreignId('member_id')->nullable()->constrained('members')->onDelete('SET NULL');
            $table->decimal('total_price', 15, 2)->default(0);
            $table->enum('jenis_pembayaran', ['tunai', 'debit']);
            $table->decimal('dibayar', 15, 2)->default(0);
            $table->decimal('kembalian', 15, 2)->default(0);
            $table->enum('status', ['unfinished', 'finished']);
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
        Schema::dropIfExists('penjualans');
    }
}
