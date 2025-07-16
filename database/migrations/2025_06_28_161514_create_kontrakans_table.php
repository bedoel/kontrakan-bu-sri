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
        Schema::create('kontrakans', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 150);
            $table->string('slug', 100)->unique();
            $table->unsignedInteger('harga');
            $table->text('deskripsi', 500)->nullable();
            $table->enum('status', ['tersedia', 'disewa'])->default('tersedia');
            $table->foreignId('admin_id')
                ->nullable()
                ->constrained('admins')
                ->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kontrakans');
    }
};
