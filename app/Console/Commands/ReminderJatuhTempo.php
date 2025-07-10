<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sewa;
use Illuminate\Support\Facades\Mail;
use App\Mail\PengingatJatuhTempo;
use Carbon\Carbon;

class ReminderJatuhTempo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:jatuh-tempo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();
        $reminderDates = [$today, $today->copy()->addDays(7)];

        $sewas = Sewa::whereIn('tanggal_akhir', $reminderDates)
            ->where('status', 'aktif')
            ->with('user', 'kontrakan')
            ->get();

        foreach ($sewas as $sewa) {
            Mail::to($sewa->user->email)->send(new PengingatJatuhTempo($sewa));
            \Log::info("Email pengingat dikirim ke: " . $sewa->user->email);
        }
    }
}
