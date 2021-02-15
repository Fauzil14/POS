<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('UID', 13)->unique();
            $table->string('merek');
            $table->foreignId('category_id')->constrained('categories');
            $table->string('nama');
            $table->decimal('stok');
            $table->decimal('harga_beli', 8, 2);
            $table->decimal('harga_jual', 8, 2);
            $table->decimal('diskon', 4, 2);
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
        Schema::dropIfExists('products');
    }
}
