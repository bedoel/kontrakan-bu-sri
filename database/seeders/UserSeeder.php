<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Budi Penyewa',
            'email' => 'user@example.com',
            'nomor_hp' => '081234567890',
            'poto_profil' => null,
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('123123123'),
        ]);
        User::create([
            'name' => 'Budi Penyewa2',
            'email' => 'user2@example.com',
            'nomor_hp' => '081234567898',
            'poto_profil' => null,
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('123123123'),
        ]);
    }
}
