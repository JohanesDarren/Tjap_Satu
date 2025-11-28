<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $table = 'cart_items';
    protected $primaryKey = 'id_item';

    protected $fillable = [
        'id_cart',
        'id_product',
        'jumlah',
        'catatan',
    ];

    // Relasi: Item milik satu Keranjang
    public function cart()
    {
        return $this->belongsTo(Cart::class, 'id_cart', 'id_cart');
    }

    // Relasi: Item adalah satu Produk
    // Ini penting agar nanti bisa panggil $item->product->nama_produk
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }
}