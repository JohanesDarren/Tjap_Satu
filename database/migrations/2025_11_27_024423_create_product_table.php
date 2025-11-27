<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id('id_product');
            
            $table->string('nama_produk');
            $table->text('deskripsi'); // Saya perbaiki typo 'deskrips' di ERD
            $table->integer('harga');
            $table->integer('stok');
            $table->string('gambar')->nullable(); // Gambar boleh kosong
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product');
    }
};