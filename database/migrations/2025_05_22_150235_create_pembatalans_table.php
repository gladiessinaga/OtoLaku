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
        Schema::create('pembatalans', function (Blueprint $table) {
            $table->id();
        $table->foreignId('pemesanan_id')->constrained()->onDelete('cascade');
        $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
        $table->string('alasan');
        $table->text('alasan_lain')->nullable();
        $table->timestamp('tanggal_pengajuan')->useCurrent();
        $table->timestamp('tanggal_respon')->nullable();
        $table->timestamps();
        });

        Schema::table('pembatalans', function (Blueprint $table) {
    $table->enum('refund_status', ['belum', 'sudah'])->default('belum');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembatalans');
    }
};
