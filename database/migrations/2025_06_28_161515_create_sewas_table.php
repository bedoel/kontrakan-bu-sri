<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sewas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('kontrakan_id')->nullable()->constrained('kontrakans')->nullOnDelete();
            $table->string('slug', 100)->unique();
            $table->date('tanggal_mulai');
            $table->date('tanggal_akhir');
            $table->unsignedTinyInteger('lama_sewa_bulan')->nullable();
            $table->enum('status', [
                'menunggu_pembayaran',
                'menunggu_konfirmasi',
                'aktif',
                'selesai',
                'ditolak',
                'kadaluarsa',
                'batal'
            ])->default('menunggu_pembayaran');
            $table->unsignedInteger('denda')->default(0);
            $table->unsignedInteger('diskon')->default(0);
            $table->foreignId('admin_id')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sewas');
    }
};
