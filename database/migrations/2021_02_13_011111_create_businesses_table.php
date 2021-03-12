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
            $table->string('nama_bisnis', 50)->default('Outlet 1');
            $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('SET NULL');
            $table->foreignId('pimpinan_id')->nullable()->constrained('users')->onDelete('SET NULL');
            $table->string('alamat_bisnis', 100)->nullable();            
            $table->string('telepon')->nullable();            
            $table->string('logo_bisnis')->nullable();            
            $table->tinyInteger('diskon_member')->nullable();
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
