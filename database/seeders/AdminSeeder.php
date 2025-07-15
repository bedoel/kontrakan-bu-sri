<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'Admin Kontrakan',
            'email' => 'gamefadlur1969@gmail.com',
            'nomor_hp' => '089999999999',
            'poto_profil' => null,
            'role' => 'super_admin',
            'password' => Hash::make('123123123'),
        ]);
    }
}
