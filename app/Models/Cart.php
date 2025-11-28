<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'carts';

    // Definisikan Primary Key karena bukan 'id'
    protected $primaryKey = 'id_cart';

    // Kolom yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'id_cust',
    ];

    // Relasi: Keranjang milik satu Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_cust', 'id_cust');
    }

    // Relasi: Keranjang punya banyak Item
    public function items()
    {
        return $this->hasMany(CartItem::class, 'id_cart', 'id_cart');
    }
}