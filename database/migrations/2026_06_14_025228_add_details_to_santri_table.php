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
        Schema::table('santri', function (Blueprint $table) {
            $table->string('nis')->unique()->after('id')->nullable();
            $table->string('jenis_kelamin')->after('nama')->nullable();
            $table->string('tempat_lahir')->after('jenis_kelamin')->nullable();
            $table->date('tanggal_lahir')->after('tempat_lahir')->nullable();
            $table->string('kelas_muhadhoroh')->after('kelas')->nullable(); // 'kelas' yang sudah ada kita anggap kelas formal
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('santri', function (Blueprint $table) {
            //
        });
    }
};
