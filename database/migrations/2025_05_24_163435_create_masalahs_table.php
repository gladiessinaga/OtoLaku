<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('masalahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('deskripsi');
            $table->string('foto')->nullable();
            $table->timestamps();   
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('masalahs');
    }
};
