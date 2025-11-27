<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('customer', function (Blueprint $table) {
            // PK Custom sesuai ERD
            $table->id('id_cust'); 
            
            $table->string('nama_lengkap');
            $table->text('alamat');
            $table->string('email')->unique(); // Email harus unik
            $table->string('no_telp');
            $table->string('password');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customer');
    }
};