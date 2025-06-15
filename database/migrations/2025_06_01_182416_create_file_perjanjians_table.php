<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('file_perjanjians', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id'); // atau 'pemesanan_id' jika terkait pesanan
        $table->string('file_path');
        $table->timestamps();

        // Foreign key (opsional, sesuaikan dengan project kamu)
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_perjanjians');
    }
};
