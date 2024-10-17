<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Columns\Summarizers\Average;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hasil extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function persen()
    {
        return $this->hasMany(Persen::class);
    }

    
    public function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class, 'matakuliah_id');
    }

    // Relasi dengan model Kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function evalausi()
    {
        return $this->belongsTo(Evaluasi::class);
    }

    public function avarage()
    {
        return $this->belongsTo(Average::class);
    }
    public static function countMahasiswaPerMatakuliah()
    {
        return self::select('matakuliah_id')
                    ->selectRaw('COUNT(nama_mahasiswa) as jumlah_mahasiswa')
                    ->groupBy('matakuliah_id')
                    ->get();
    }

    public static function calculateAverageScoresByMatakuliah()
    {
        return self::selectRaw('
                matakuliah_id,
                AVG(absen) as avg_absen,
                AVG(tugas) as avg_tugas,
                AVG(uts) as avg_uts,
                AVG(uas) as avg_uas
            ')
            ->groupBy('matakuliah_id')
            ->with('matakuliah') // Mengambil data mata kuliah terkait
            ->get();
    }
   
    
}