<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermintaanPindahKontrakan extends Model
{
    protected $fillable = [
        'user_id',
        'sewa_id',
        'kontrakan_lama_id',
        'kontrakan_baru_id',
        'alasan',
        'status',
        'catatan',
        'admin_id',
        'slug',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sewa()
    {
        return $this->belongsTo(Sewa::class);
    }

    public function kontrakanLama()
    {
        return $this->belongsTo(Kontrakan::class, 'kontrakan_lama_id');
    }

    public function kontrakanBaru()
    {
        return $this->belongsTo(Kontrakan::class, 'kontrakan_baru_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
