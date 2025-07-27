<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Sewa;
use App\Models\Transaksi;
use App\Models\Kontrakan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserSewaTransaksiSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $user = User::create([
                'name' => "User $i",
                'email' => "user$i@example.com",
                'nomor_hp' => '0812345678' . $i,
                'password' => Hash::make('password'),
            ]);

            if (rand(1, 100) <= 80) {
                $kontrakan = Kontrakan::where('status', 'tersedia')->inRandomOrder()->first();

                if ($kontrakan) {
                    $lamaBulan = rand(1, 6);
                    $tanggalMulai = Carbon::now()->subDays(rand(0, 10));
                    $tanggalAkhir = $tanggalMulai->copy()->addMonths($lamaBulan);

                    // Diskon berdasarkan lama sewa
                    $diskonPerBulan = match (true) {
                        $lamaBulan >= 6 => 50000,
                        $lamaBulan >= 3 => 25000,
                        default => 0,
                    };

                    $totalDiskon = $diskonPerBulan * $lamaBulan;
                    $hargaTotal = $kontrakan->harga * $lamaBulan;
                    $totalBayar = $hargaTotal - $totalDiskon;

                    // Ubah status kontrakan jadi disewa
                    $kontrakan->update(['status' => 'disewa']);

                    // RANDOM status sewa
                    $statusSewa = collect(['aktif', 'menunggu_konfirmasi'])->random();

                    $sewa = Sewa::create([
                        'user_id' => $user->id,
                        'kontrakan_id' => $kontrakan->id,
                        'slug' => Str::slug("sewa-{$kontrakan->id}-" . now()),
                        'tanggal_mulai' => $tanggalMulai,
                        'tanggal_akhir' => $tanggalAkhir,
                        'lama_sewa_bulan' => $lamaBulan,
                        'status' => $statusSewa,
                        'diskon' => $totalDiskon,
                        'denda' => 0,
                        'admin_id' => 1,
                    ]);

                    // RANDOM status transaksi
                    $statusTransaksi = collect(['disetujui', 'menunggu_konfirmasi'])->random();

                    Transaksi::create([
                        'invoice_number' => 'INV-' . strtoupper(Str::random(8)),
                        'sewa_id' => $sewa->id,
                        'metode' => 'cash',
                        'total_bayar' => $totalBayar,
                        'diskon' => $totalDiskon,
                        'denda' => 0,
                        'status' => $statusTransaksi,
                        'catatan' => "Diskon Rp" . number_format($diskonPerBulan, 0, ',', '.') . "/bulan",
                        'admin_id' => 1,
                    ]);
                }
            }
        }
    }
}
