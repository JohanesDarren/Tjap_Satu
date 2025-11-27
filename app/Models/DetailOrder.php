<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailOrder extends Model
{
    protected $table = 'detail_order';
    protected $primaryKey = 'id_detail';
    protected $fillable = ['jumlah', 'subtotal', 'id_order', 'id_product'];

    public function order() {
        return $this->belongsTo(Order::class, 'id_order');
    }
    public function product() {
        return $this->belongsTo(Product::class, 'id_product');
    }
}
