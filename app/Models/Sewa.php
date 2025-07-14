<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sewa extends Model
{
    protected $fillable = [
        'user_id',
        'kontrakan_id',
        'slug',
        'tanggal_mulai',
        'tanggal_akhir',
        'lama_sewa_bulan',
        'status',
        'diskon',
        'denda',
        'admin_id',
    ];

    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_akhir' => 'datetime',
    ];

    public function transaksi()
    {
        return $this->hasOne(Transaksi::class);
    }

    public function kontrakan()
    {
        return $this->belongsTo(Kontrakan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeKadaluarsaLebih7Hari($query)
    {
        return $query->where('status', 'aktif')
            ->whereDate('tanggal_akhir', '<=', now()->subDays(7));
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
