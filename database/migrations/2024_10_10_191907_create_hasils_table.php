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
        Schema::create('hasils', function (Blueprint $table) {
            $table->id();
            $table->foreignId('matakuliah_id')->constrained('matakuliahs');
            $table->foreignId('kelas_id')->constrained('kelas');
            $table->foreignId('persen_id')->constrained('persens');
            $table->string('nama_mahasiswa')->nullable();
            $table->float('nim')->nullable();
            $table->float('absen')->nullable();
            $table->float('tugas')->nullable();
            $table->float('uts')->nullable();
            $table->float('uas')->nullable();
            $table->float('total_nilai')->nullable();
            $table->string('huruf_mutu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasils');
    }
};