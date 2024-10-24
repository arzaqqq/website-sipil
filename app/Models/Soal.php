<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;

    protected $guarded = []; // Include other fillable attributes

    protected $casts = [
        'quiz' => 'array', // Cast quiz as an array
        'latihan' => 'array', // Cast latihan as an array
    ];
    
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function mataKuliah()
    {
        return $this->belongsTo(Matakuliah::class ,'matakuliah_id'); 
    }
}