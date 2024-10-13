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
        Schema::create('evaluasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('matakuliah_id')->constrained('matakuliahs')->onDelete('cascade');
            // $table->foreignId('avarage_id')->constrained('avarages')->onDelete('cascade');
            $table->string('mg');
            $table->string('cpl');
            $table->string('cpmk');
            $table->string('sub_cpmk');
            $table->string('indikator');
            $table->string('soal');
            $table->float('bobot');
            $table->float('average_mahasiswa_angka');
            $table->float('average_mahasiswa_persen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluasis');
    }
};