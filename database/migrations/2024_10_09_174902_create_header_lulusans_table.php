<?php

use App\Models\HeaderLulusan;
use GuzzleHttp\Psr7\Header;
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
        Schema::create('header_lulusans', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->string('label');
            $table->string('value');
            $table->string('type');
            $table->timestamps();
        });

        HeaderLulusan::create([
            'key' => '_nama',
            'label' => 'Nama Profil',
            'value' => 'Profil Lulusan (PL)',
            'type' => 'text',
        ]);

        HeaderLulusan::create([
            'key' => '_deskripsi',
            'label' => 'Nama Deskripsi',
            'value' => 'Deskripsi Profil Lulusan',
            'type' => 'text',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('header_lulusans');
    }
};
