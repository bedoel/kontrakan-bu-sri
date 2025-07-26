<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $fillable = [
        'user_id',
        'slug',
        'pesan',
        'status',
        'gambar',
        'admin_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function balasan()
    {
        return $this->hasMany(BalasanPengaduan::class);
    }

    public function status_diubah_oleh()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
