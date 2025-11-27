<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';
    protected $primaryKey = 'id_cust';
    protected $fillable = ['nama_lengkap', 'alamat', 'email', 'no_telp', 'password'];

    public function orders() {
        return $this->hasMany(Order::class, 'id_cust');
    }
}