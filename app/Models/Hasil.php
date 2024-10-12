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

    public function average()
    {
        return $this->belongsTo(Average::class);
    }
    
}