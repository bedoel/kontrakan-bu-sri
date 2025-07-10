<?php

namespace Database\Seeders;

use App\Models\Kontrakan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KontrakanSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 21; $i++) {
            $nama = "Kontrakan Blok $i";

            // Harga dibulatkan ke 50 ribuan
            $harga = round(rand(500000, 1200000) / 50000) * 50000;

            // Deskripsi lebih lengkap
            $deskripsi = "Kontrakan Blok $i merupakan unit hunian nyaman yang cocok untuk keluarga kecil maupun individu. "
                . "Dilengkapi dengan kamar tidur, kamar mandi, dapur, dan ruang tamu. Lokasi strategis dekat fasilitas umum "
                . "seperti pasar, sekolah, dan transportasi umum.";

            Kontrakan::create([
                'nama' => $nama,
                'slug' => Str::slug($nama) . '-' . $i,
                'harga' => $harga,
                'deskripsi' => $deskripsi,
                'status' => 'tersedia',
            ]);
        }
    }
}
