<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
    protected $primaryKey = 'id_product';
    protected $fillable = ['nama_produk', 'deskripsi', 'harga', 'stok', 'gambar', 'jenis', 'proses'];
    // hapus/ubah $timestamps agar konsisten dengan migrasi
    public $timestamps = true; // <-- ubah jadi true

    public function detailOrders() {
        return $this->hasMany(DetailOrder::class, 'id_product');
    }
}