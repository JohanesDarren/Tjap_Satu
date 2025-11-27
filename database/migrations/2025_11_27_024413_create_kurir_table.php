<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kurir', function (Blueprint $table) {
            $table->id('id_kurir');
            
            $table->string('nama_kurir');
            $table->string('plat_nomor');
            $table->string('no_telp');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kurir');
    }
};