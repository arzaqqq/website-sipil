<?php

namespace App\Observers;

use Log;
use App\Models\Hasil;
use App\Models\Avarage;

class HasilObserver
{
    /**
     * Handle the Hasil "created" event.
     */
    public function created(Hasil $hasil): void
    {
        //
    }

    /**
     * Handle the Hasil "updated" event.
     */
    public function updated(Hasil $hasil): void
    {
        //
    }

    /**
     * Handle the Hasil "deleted" event.
     */
    public function deleted(Hasil $hasil): void
    {
        //
    }

    /**
     * Handle the Hasil "restored" event.
     */
    public function restored(Hasil $hasil): void
    {
        //
    }

    /**
     * Handle the Hasil "force deleted" event.
     */
    public function forceDeleted(Hasil $hasil): void
    {
        //
    }

    public function saved(Hasil $hasil)
{
    

    // Hitung rata-rata berdasarkan matakuliah_id
    $averageData = Hasil::where('matakuliah_id', $hasil->matakuliah_id)
        ->selectRaw('AVG(absen) as average_absen')
        ->selectRaw('AVG(tugas) as average_tugas')
        ->selectRaw('AVG(uts) as average_uts')
        ->selectRaw('AVG(uas) as average_uas')
        ->selectRaw('AVG(total_nilai) as average_total_nilai')
        ->first();

    // Perbarui atau buat data baru di tabel averages
    Avarage::updateOrCreate(
        ['matakuliah_id' => $hasil->matakuliah_id],
        [
            'hasil_id' => $hasil->id,
            'average_absen' => $averageData->average_absen,
            'average_tugas' => $averageData->average_tugas,
            'average_uts' => $averageData->average_uts,
            'average_uas' => $averageData->average_uas,
            'average_total_nilai' => $averageData->average_total_nilai,
        ]
    );
}
}