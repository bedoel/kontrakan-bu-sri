<?php

namespace App\Console\Commands;

use App\Models\Sewa;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\SewaKadaluarsaNotification;

class TandaiSewaKadaluarsa extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sewa:tandai-kadaluarsa';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menandai sewa yang lewat 7 hari dari jatuh tempo sebagai kadaluarsa';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sewas = Sewa::kadaluarsaLebih7Hari()->with(['user', 'kontrakan'])->get();
        $total = 0;

        foreach ($sewas as $sewa) {
            // Kirim email
            if ($sewa->user && $sewa->user->email) {
                Mail::to($sewa->user->email)->send(new SewaKadaluarsaNotification($sewa));
            }

            // Update status ke kadaluarsa
            $sewa->update(['status' => 'kadaluarsa']);
            $total++;
        }

        $this->info("Total sewa kadaluarsa yang ditandai dan dikirim email: $total");
    }
}
