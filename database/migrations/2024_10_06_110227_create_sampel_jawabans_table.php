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
        Schema::create('sampel_jawabans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('matakuliah_id')->constrained('matakuliahs')->onDelete('cascade');
            $table->string('sampel_quiz');
            $table->string('sampel_latihan');
            $table->string('sampel_UTS');
            $table->string('sampel_UAS');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sampel_jawabans');
    }
};