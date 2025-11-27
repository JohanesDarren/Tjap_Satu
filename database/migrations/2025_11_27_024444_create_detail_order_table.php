<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('detail_order', function (Blueprint $table) {
            $table->id('id_detail');
            
            $table->integer('jumlah');
            $table->integer('subtotal');
            
            // Foreign Key Columns
            $table->unsignedBigInteger('id_order');
            $table->unsignedBigInteger('id_product');

            // Constraint
            $table->foreign('id_order')
                  ->references('id_order')->on('order')
                  ->onDelete('cascade'); // Hapus detail jika order induk dihapus

            $table->foreign('id_product')
                  ->references('id_product')->on('product')
                  ->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_order');
    }
};