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
        Schema::create('absensi_ngaji', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id');
            $table->date('tanggal');
            $table->string('sesi'); // subuh / maghrib
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi_ngajis');
    }
};
