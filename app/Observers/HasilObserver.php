<?php
namespace App\Observers;

use App\Models\Hasil;
use App\Models\Average;
use Illuminate\Support\Facades\Log;

class HasilObserver
{
    /**
     * Menangani event ketika Hasil "created".
     */
    public function created(Hasil $hasil): void
    {
        $this->saved($hasil);
    }

    /**
     * Menangani event ketika Hasil "updated".
     */
    public function updated(Hasil $hasil): void
    {
        $this->saved($hasil);
    }

    /**
     * Logika untuk menyimpan atau memperbarui rata-rata pada tabel averages.
     */
    public function saved(Hasil $hasil): void
    {

        
        // Pastikan ada data Hasil yang sesuai dengan matakuliah_id ini
        if (Hasil::where('matakuliah_id', $hasil->matakuliah_id)->exists()) {
            // Hitung rata-rata berdasarkan matakuliah_id
            $averageData = Hasil::where('matakuliah_id', $hasil->matakuliah_id)
                ->selectRaw('
                    AVG(absen) as average_absen,
                    AVG(tugas) as average_tugas,
                    AVG(uts) as average_uts,
                    AVG(uas) as average_uas,
                    AVG(total_nilai) as average_total_nilai
                ')
                ->first();

            // Log untuk memeriksa data rata-rata
            Log::info('Rata-rata dihitung untuk matakuliah_id: ' . $hasil->matakuliah_id, [
                'average_absen' => $averageData->average_absen,
                'average_tugas' => $averageData->average_tugas,
                'average_uts' => $averageData->average_uts,
                'average_uas' => $averageData->average_uas,
                'average_total_nilai' => $averageData->average_total_nilai,
            ]);

            // Perbarui atau buat data baru di tabel averages
            Average::updateOrCreate(
                ['matakuliah_id' => $hasil->matakuliah_id],
                [
                    'jumlah_mahasiswa' => Hasil::where('matakuliah_id', $hasil->matakuliah_id)->count(),
                    'average_absen' => $averageData->average_absen,
                    'average_tugas' => $averageData->average_tugas,
                    'average_uts' => $averageData->average_uts,
                    'average_uas' => $averageData->average_uas,
                    'average_total_nilai' => $averageData->average_total_nilai,
                ]
            );
        } else {
            // Hapus data di tabel averages jika tidak ada hasil yang terkait
            Average::where('matakuliah_id', $hasil->matakuliah_id)->delete();
        }
    }
}