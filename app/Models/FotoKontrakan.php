<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoKontrakan extends Model
{
    protected $fillable = ['kontrakan_id', 'path'];

    public function kontrakan()
    {
        return $this->belongsTo(Kontrakan::class);
    }
}
