<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->id('id_payment');
            
            $table->string('metode_bayar'); // Cash, Transfer, QRIS
            $table->dateTime('tanggal_bayar');
            $table->string('status_bayar'); // Lunas, Belum
            
            // Foreign Key ke Order
            $table->unsignedBigInteger('id_order');
            
            $table->foreign('id_order')
                  ->references('id_order')->on('order')
                  ->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment');
    }
};