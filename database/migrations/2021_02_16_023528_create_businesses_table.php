<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bisnis', 50);
            $table->foreignId('pimpinan_id')->constrained('users')->onDelete('cascade');
            $table->string('alamat_bisnis', 100);            
            $table->string('telepon');            
            $table->string('logo_bisnis');            
            $table->decimal('diskon_member', 4, 2);
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
        Schema::dropIfExists('businesses');
    }
}
