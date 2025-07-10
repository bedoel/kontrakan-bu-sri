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
        'email_verified_at',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}
