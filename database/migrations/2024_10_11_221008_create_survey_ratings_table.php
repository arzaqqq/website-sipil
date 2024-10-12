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
        Schema::create('survey_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id')->constrained('surveys')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('survey_questions')->onDelete('cascade');
            $table->integer('rating');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_ratings');
    }
};
