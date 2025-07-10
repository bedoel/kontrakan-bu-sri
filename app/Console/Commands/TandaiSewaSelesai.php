<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sewa;

class TandaiSewaSelesai extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sewa:tandai-selesai';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tandai sewa sebagai selesai jika sudah lebih dari 7 hari setelah jatuh tempo';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $jumlah = Sewa::kadaluarsaLebih7Hari()->update(['status' => 'selesai']);

        $this->info("Berhasil menandai $jumlah sewa sebagai selesai.");
    }
}
