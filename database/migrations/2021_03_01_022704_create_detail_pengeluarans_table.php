<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPengeluaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_pengeluarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengeluaran_id')->constrained('pengeluarans')->onDelete('cascade');
            $table->foreignId('pegawai_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('beban_id')->constrained('bebans')->onDelete('cascade');
            $table->text('deskripsi')->nullable();
            $table->decimal('subtotal_pengeluaran', 15, 2);
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
        Schema::dropIfExists('detail_pengeluarans');
    }
}
