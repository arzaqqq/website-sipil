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
            $table->string('nama_mahasiswa');
            $table->float('nim');
            $table->integer('target');
            $table->integer('hadir');
            $table->float('absen');
            $table->float('tugas');
            $table->float('uts');
            $table->float('uas');
            $table->float('total_nilai');
            $table->string('huruf_mutu');
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