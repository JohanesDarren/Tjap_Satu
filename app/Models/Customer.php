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
        'is_admin',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'id_cust');
    }
}
