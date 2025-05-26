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
        Schema::table('pembatalans', function (Blueprint $table) {
        $table->string('refund_status')->default('belum')->after('bukti_transfer'); // sesuaikan posisi kolom
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembatalans', function (Blueprint $table) {
        $table->dropColumn('refund_status');
    });
    }
};
