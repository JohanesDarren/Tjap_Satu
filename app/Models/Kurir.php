<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kurir extends Model
{
    protected $table = 'kurir';
    protected $primaryKey = 'id_kurir';
    protected $fillable = ['nama_kurir', 'plat_nomor', 'no_telp'];
    
    public function orders() {
        return $this->hasMany(Order::class, 'id_kurir');
    }
}