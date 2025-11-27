<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';
    protected $primaryKey = 'id_payment';
    protected $fillable = ['metode_bayar', 'tanggal_bayar', 'status_bayar', 'id_order'];

    public function order() {
        return $this->belongsTo(Order::class, 'id_order');
    }
}
