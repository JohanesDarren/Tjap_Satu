<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            // Primary Key Custom
            $table->id('id_cart'); 
            
            // Foreign Key ke tabel Customer
            // Menggunakan 'id_cust' sesuai ERD lama kamu
            $table->unsignedBigInteger('id_cust')->unique(); 
            
            $table->timestamps();

            // Definisi Foreign Key
            // Jika customer dihapus, keranjangnya ikut terhapus (Cascade)
            $table->foreign('id_cust')
                  ->references('id_cust')
                  ->on('customer')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('carts');
    }
};