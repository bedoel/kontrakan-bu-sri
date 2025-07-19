<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'nomor_hp',
        'poto_profil',
        'role',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function kontrakans()
    {
        return $this->hasMany(Kontrakan::class);
    }

    public function sewas()
    {
        return $this->hasMany(Sewa::class);
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function pengaduans()
    {
        return $this->hasMany(Pengaduan::class);
    }

    public function balasan_pengaduans()
    {
        return $this->hasMany(BalasanPengaduan::class);
    }
}
