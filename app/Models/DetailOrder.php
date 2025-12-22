<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailOrder extends Model
{
    protected $table = 'detail_order';
    protected $primaryKey = 'id_detail';
    
    protected $fillable = [
        'jumlah',
        'subtotal',
        'id_order',
        'id_product',
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'subtotal' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'id_order');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'id_product');
    }
}
