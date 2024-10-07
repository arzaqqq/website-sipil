<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Matakuliah extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function booted()
    {
        static::creating(function ($mataKuliah) {
            // Set user_id secara otomatis
            $mataKuliah->user_id = Auth::id();
        });
    }

    // protected $fillable = ['user_id', 'nama_mk', 'file_rps'];

    public function materis()
    {
        return $this->hasMany(Materi::class);
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }

    public function soal()
    {
        return $this->hasMany(Soal::class);
    } 

    public function rubrik()
    {
        return $this->hasMany(Rubrik::class);
    }  
}