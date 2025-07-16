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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number', 20)->unique();
            $table->foreignId('sewa_id')->constrained()->onDelete('cascade');

            $table->enum('metode', ['cash', 'transfer']);
            $table->unsignedInteger('total_bayar');
            $table->unsignedInteger('denda')->default(0);
            $table->unsignedInteger('diskon')->default(0);

            $table->string('bukti_transfer', 255)->nullable();

            $table->enum('status', ['menunggu_konfirmasi', 'disetujui', 'ditolak'])->default('menunggu_konfirmasi');

            $table->text('catatan', 500)->nullable();
            $table->text('pesan', 500)->nullable();

            $table->foreignId('admin_id')->nullable()->constrained('admins')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
