<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->id('id_order');
            
            $table->dateTime('tanggal_order');
            $table->integer('total_harga');
            $table->string('tipe_pesanan'); // Contoh: Dine-in, Delivery
            $table->string('status_pesanan'); // Contoh: Pending, Selesai
            
            // Definisi Foreign Key Columns
            $table->unsignedBigInteger('id_cust');
            $table->unsignedBigInteger('id_kurir')->nullable(); 
            // id_kurir nullable karena kalau makan di tempat (Dine-in) tidak butuh kurir.

            // Constraint / Hubungan Antar Tabel
            $table->foreign('id_cust')
                  ->references('id_cust')->on('customer')
                  ->onDelete('cascade'); // Hapus order jika customer dihapus

            $table->foreign('id_kurir')
                  ->references('id_kurir')->on('kurir')
                  ->onDelete('set null'); // Jika kurir dihapus, data order tetap ada tapi kurir jadi null
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order');
    }
};