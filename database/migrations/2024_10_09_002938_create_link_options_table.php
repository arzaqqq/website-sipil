<?php

use App\Models\LinkOption;
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
        Schema::create('link_options', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->string('label');
            $table->string('value')->nullable();
            $table->string('type');
            $table->timestamps();
        });

        LinkOption::create([
            'key' => '_portal',
            'label' => 'Portal Akademik',
            'value' => 'http://portal.unimal.ac.id/',
            'type' => 'text',
        ]);

        LinkOption::create([
            'key' => '_elearning',
            'label' => 'E-learning',
            'value' => 'http://e-learning.unimal.ac.id/',
            'type' => 'text',
        ]);

        LinkOption::create([
            'key' => '_sister',
            'label' => 'Sister',
            'value' => 'http://sister.unimal.ac.id/',
            'type' => 'text',
        ]);

        LinkOption::create([
            'key' => '_simpeg',
            'label' => 'Simpeg',
            'value' => 'http://simpeg.unimal.ac.id/',
            'type' => 'text',
        ]);

        LinkOption::create([
            'key' => '_lppm',
            'label' => 'LPPM',
            'value' => 'http://lppm.unimal.ac.id/',
            'type' => 'text',
        ]);

        LinkOption::create([
            'key' => '_lp3m',
            'label' => 'LP3M',
            'value' => 'http://lp3m.unimal.ac.id/',
            'type' => 'text',
        ]);

        LinkOption::create([
            'key' => '_repo',
            'label' => 'Repository',
            'value' => 'https://repository.unimal.ac.id/',
            'type' => 'text',
        ]);

        LinkOption::create([
            'key' => '_perpus',
            'label' => 'Perpustakaan',
            'value' => 'https://perpustakaan.unimal.ac.id/',
            'type' => 'text',
        ]);

        LinkOption::create([
            'key' => '_open',
            'label' => 'Open Journal',
            'value' => 'https://openjournal.unimal.ac.id/',
            'type' => 'text',
        ]);

        LinkOption::create([
            'key' => '_conference',
            'label' => 'Conference',
            'value' => 'https://ocs.unimal.ac.id/',
            'type' => 'text',
        ]);

        LinkOption::create([
            'key' => '_proceedings',
            'label' => 'Proceedings',
            'value' => 'https://proceedings.unimal.ac.id/',
            'type' => 'text',
        ]);

        LinkOption::create([
            'key' => '_rama',
            'label' => 'Repository Mahasiswa',
            'value' => 'https://repository-mahasiswa.unimal.ac.id/',
            'type' => 'text',
        ]);

        LinkOption::create([
            'key' => '_x',
            'label' => 'X',
            'value' => 'https://x.com/umalikussaleh',
            'type' => 'text',
        ]);

        LinkOption::create([
            'key' => '_youtube',
            'label' => 'Youtube',
            'value' => 'https://www.youtube.com/c/unimaltv',
            'type' => 'text',
        ]);

        LinkOption::create([
            'key' => '_facebook',
            'label' => 'Facebook',
            'value' => 'https://web.facebook.com/portal.unimal/?locale=ms_MY&_rdc=1&_rdr',
            'type' => 'text',
        ]);

        LinkOption::create([
            'key' => '_instagram',
            'label' => 'Instagram',
            'value' => 'https://www.instagram.com/univ.malikussaleh/',
            'type' => 'text',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('link_options');
    }
};
