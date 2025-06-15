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
        Schema::create('pengembalians', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pemesanan_id')->constrained()->onDelete('cascade');
        $table->text('catatan')->nullable(); // misalnya kondisi mobil atau catatan tambahan
        $table->enum('status_pengembalian', ['menunggu_verifikasi', 'diterima', 'ditolak'])->default('menunggu_verifikasi');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalians');
    }
};
