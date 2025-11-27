<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
    protected $primaryKey = 'id_product';
    protected $fillable = ['nama_produk', 'deskripsi', 'harga', 'stok', 'gambar'];
    
    public function detailOrders() {
        return $this->hasMany(DetailOrder::class, 'id_product');
    }
}