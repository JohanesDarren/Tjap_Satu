<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    protected $table = 'customer';
    protected $primaryKey = 'id_cust';

    use Notifiable;

    protected $fillable = [
        'nama_lengkap',
        'alamat',
        'email',
        'no_telp',
        'password',
        'foto',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'id_cust');
    }
}