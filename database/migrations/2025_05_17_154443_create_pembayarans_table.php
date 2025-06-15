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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            // Foreign key ke tabel pemesanan
            $table->foreignId('pemesanan_id')->constrained()->onDelete('cascade');

            $table->string('metode'); // transfer, ewallet, cod
            $table->string('status')->default('pending'); // pending, verified, rejected
            $table->string('bukti_pembayaran')->nullable(); // path file bukti pembayaran jika ada
            $table->decimal('jumlah', 15, 2); // jumlah nominal pembayaran

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
