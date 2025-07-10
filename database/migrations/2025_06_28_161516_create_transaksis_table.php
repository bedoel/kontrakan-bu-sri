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
            $table->string('invoice_number')->unique();
            $table->foreignId('sewa_id')->constrained()->onDelete('cascade');
            $table->enum('metode', ['cash', 'transfer']);
            $table->integer('total_bayar');
            $table->integer('denda')->default(0);
            $table->integer('diskon')->default(0);
            $table->string('bukti_transfer')->nullable();
            $table->enum('status', ['belum_dibayar', 'menunggu_konfirmasi', 'disetujui', 'ditolak'])->default('belum_dibayar');
            $table->text('catatan')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->foreign('admin_id')->references('id')->on('admins')->nullOnDelete();
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
