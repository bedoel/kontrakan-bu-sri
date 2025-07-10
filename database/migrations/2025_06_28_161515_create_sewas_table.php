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
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kontrakan_id')->constrained()->onDelete('cascade');
            $table->string('slug')->unique();
            $table->date('tanggal_mulai');
            $table->date('tanggal_akhir');
            $table->enum('status', ['menunggu_pembayaran', 'menunggu_konfirmasi', 'aktif', 'selesai', 'ditolak', 'kadaluarsa', 'batal'])->default('menunggu_pembayaran');
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
        Schema::dropIfExists('sewas');
    }
};
