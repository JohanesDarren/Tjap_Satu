<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
    protected $primaryKey = 'id_order';
    protected $fillable = ['tanggal_order', 'total_harga', 'tipe_pesanan', 'status_pesanan', 'id_cust', 'id_kurir'];

    // Relasi ke Customer
    public function customer() {
        return $this->belongsTo(Customer::class, 'id_cust');
    }
    // Relasi ke Kurir
    public function kurir() {
        return $this->belongsTo(Kurir::class, 'id_kurir');
    }
    // Relasi ke Detail
    public function detailOrders() {
        return $this->hasMany(DetailOrder::class, 'id_order');
    }
    // Relasi ke Payment
    public function payment() {
        return $this->hasOne(Payment::class, 'id_order');
    }
}