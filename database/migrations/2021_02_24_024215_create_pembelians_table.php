<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembeliansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelians', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi');
            $table->foreignId('business_id')->constrained('businesses')->onDelete('cascade');
            $table->foreignId('staff_id')->nullable()->constrained('users')->onDelete('SET NULL');
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->onDelete('SET NULL');
            $table->decimal('total_price', 25, 2)->default(0);
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
        Schema::dropIfExists('pembelians');
    }
}
