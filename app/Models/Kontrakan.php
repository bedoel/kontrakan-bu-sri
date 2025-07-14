<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kontrakan extends Model
{
    protected $fillable = ['nama', 'slug', 'harga', 'deskripsi', 'status', 'admin_id'];

    public function foto_kontrakans()
    {
        return $this->hasMany(FotoKontrakan::class);
    }

    public function sewaAktif()
    {
        return $this->hasOne(Sewa::class)
            ->where('status', 'aktif');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
