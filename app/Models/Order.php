<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $table = 'order';
    protected $primaryKey = 'id_order';
    
    protected $fillable = [
        'tanggal_order',
        'total_harga',
        'tipe_pesanan',
        'status_pesanan',
        'id_cust',
        'id_kurir',
        'catatan',
        'subtotal_produk',
        'ongkir',
        'biaya_layanan',
    ];

    protected $casts = [
        'tanggal_order' => 'datetime',
        'total_harga' => 'integer',
        'subtotal_produk' => 'integer',
        'ongkir' => 'integer',
        'biaya_layanan' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi ke Customer
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'id_cust');
    }
    // Relasi ke Kurir
    public function kurir() {
        return $this->belongsTo(Kurir::class, 'id_kurir');
    }
    // Relasi ke Detail
    public function detailOrders(): HasMany
    {
        return $this->hasMany(DetailOrder::class, 'id_order');
    }
    // Relasi ke Payment
    public function payment() {
        return $this->hasOne(Payment::class, 'id_order');
    }

    public function canBeCancelled(): bool
    {
        return in_array(strtolower($this->status_pesanan), ['pending', 'proses']);
    }
}