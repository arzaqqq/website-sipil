<?php

use App\Models\setting;
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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->string('label');
            $table->longText('value')->nullable();
            $table->string('type');
            $table->timestamps();
        });

        setting::create([
            'key' => '_site_name',
            'label' => 'Judul',
            'value' => 'Profil Lulusan',
            'type' => 'text',
        ]);

        setting::create([
            'key' => '_nama_website',
            'label' => 'Nama Web',
            'value' => 'SEP - SIPIL UNIMAL',
            'type' => 'text',
        ]);

        setting::create([
            'key' => '_subjudul1',
            'label' => 'Sub Judul',
            'value' => 'Sejarah Prodi',
            'type' => 'text',
        ]);

        setting::create([
            'key' => '_subjudul2',
            'label' => 'Sub Judul2',
            'value' => 'Profil Lulusan',
            'type' => 'text',
        ]);

        setting::create([
            'key' => '_narasi1',
            'label' => 'Narasi1',
            'value' => 'lorem ipsum',
            'type' => 'longtext',
        ]);

        setting::create([
            'key' => '_narasi2',
            'label' => 'Narasi2',
            'value' => 'lorem ipsum dolor',
            'type' => 'longtext',
        ]);

        setting::create([
            'key' => '_hp',
            'label' => 'No Hp',
            'value' => '085414413',
            'type' => 'text',
        ]);

        setting::create([
            'key' => '_email',
            'label' => 'Email',
            'value' => 'teknik@gmail.com',
            'type' => 'text',
        ]);

        setting::create([
            'key' => '_alamat',
            'label' => 'alamat',
            'value' => 'Muara dua',
            'type' => 'longtext',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
