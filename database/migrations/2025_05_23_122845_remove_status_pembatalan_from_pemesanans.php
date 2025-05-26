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
        $sm = Schema::getConnection()->getDoctrineSchemaManager();
    $columns = collect($sm->listTableColumns('pemesanans'))->keys()->toArray();

    if (in_array('status_pembatalan', $columns)) {
        Schema::table('pemesanans', function (Blueprint $table) {
            // $table->dropColumn('status_pembatalan');
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemesanans', function (Blueprint $table) {
        $table->string('status_pembatalan')->nullable();
    });
    }
};
