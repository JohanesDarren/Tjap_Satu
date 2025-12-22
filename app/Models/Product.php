<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $table = 'product';
    protected $primaryKey = 'id_product';
    
    protected $fillable = [
        'nama_produk',
        'deskripsi',
        'harga',
        'stok',
        'gambar',
        'jenis',
        'proses',
    ];

    protected $casts = [
        'harga' => 'integer',
        'stok' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function detailOrders(): HasMany
    {
        return $this->hasMany(DetailOrder::class, 'id_product');
    }

    public function hasStock(int $quantity = 1): bool
    {
        return $this->stok >= $quantity;
    }
}