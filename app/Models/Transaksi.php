<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'invoice_number',
        'sewa_id',
        'metode',
        'total_bayar',
        'denda',
        'diskon',
        'bukti_transfer',
        'status',
        'catatan',
        'pesan',
        'admin_id',
    ];


    public function sewa()
    {
        return $this->belongsTo(Sewa::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
