<?php

use App\Models\Survey;
use App\Models\SurveyQuestion;
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
        Schema::create('survey_questions', function (Blueprint $table) {
            $table->id();
            $table->string('key')->default('_pertanyaan');
            $table->string('label');
            $table->longText('value')->nullable();
            $table->string('type')->default('longtext');
            $table->timestamps();
        });

        SurveyQuestion::create([
            'key' => '_pertanyaan',
            'label' => 'Pertanyaan 1',
            'value' => 'Apakah materi disampaikan dengan baik?',
            'type' => 'longtext',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_questions');
    }
};
