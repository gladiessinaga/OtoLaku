<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pemesanans', function (Blueprint $table) {
            if (!Schema::hasColumn('pemesanans', 'tanggal_sewa_terakhir')) {
                $table->date('tanggal_sewa_terakhir')->nullable()->after('tanggal_sewa');
            }
            if (!Schema::hasColumn('pemesanans', 'status_pengembalian')) {
                $table->enum('status_pengembalian', ['Belum Dikembalikan', 'Sudah Dikembalikan'])
                    ->default('Belum Dikembalikan');
            }
            if (!Schema::hasColumn('pemesanans', 'kondisi_bbm_kembali')) {
                $table->enum('kondisi_bbm_kembali', ['Penuh', 'Setengah', 'Hampir Habis'])->nullable();
            }
            if (!Schema::hasColumn('pemesanans', 'denda_bbm')) {
                $table->integer('denda_bbm')->default(0);
            }
        });
    }

    public function down()
    {
        Schema::table('pemesanans', function (Blueprint $table) {
            if (Schema::hasColumn('pemesanans', 'tanggal_sewa_terakhir')) {
                $table->dropColumn('tanggal_sewa_terakhir');
            }
            if (Schema::hasColumn('pemesanans', 'status_pengembalian')) {
                $table->dropColumn('status_pengembalian');
            }
            if (Schema::hasColumn('pemesanans', 'kondisi_bbm_kembali')) {
                $table->dropColumn('kondisi_bbm_kembali');
            }
            if (Schema::hasColumn('pemesanans', 'denda_bbm')) {
                $table->dropColumn('denda_bbm');
            }
        });
    }
};
