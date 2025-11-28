<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            // Primary Key Custom
            $table->id('id_item');
            
            // Foreign Keys
            $table->unsignedBigInteger('id_cart');
            $table->unsignedBigInteger('id_product');
            
            // Data Transaksi Sementara
            $table->integer('jumlah')->default(1);
            $table->string('catatan')->nullable(); // Misal: "Jangan pakai gula"
            
            $table->timestamps();

            // Relasi ke Tabel Carts
            $table->foreign('id_cart')
                  ->references('id_cart')
                  ->on('carts')
                  ->onDelete('cascade');

            // Relasi ke Tabel Products
            $table->foreign('id_product')
                  ->references('id_product')
                  ->on('product')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cart_items');
    }
};