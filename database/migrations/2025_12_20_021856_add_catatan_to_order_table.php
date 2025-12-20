<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('order', function (Blueprint $table) {
            $table->text('catatan')->nullable()->after('promo_discount');
            $table->decimal('subtotal_produk', 10, 2)->default(0)->after('catatan');
            $table->decimal('ongkir', 10, 2)->default(0)->after('subtotal_produk');
            $table->decimal('biaya_layanan', 10, 2)->default(0)->after('ongkir');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order', function (Blueprint $table) {
            $table->dropColumn(['catatan', 'subtotal_produk', 'ongkir', 'biaya_layanan']);
        });
    }
};
