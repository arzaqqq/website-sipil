<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    protected $fillable = ['matakuliah_id', 'pertemuan', 'judul_materi', 'file_materi'];

    public function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class,);
    }
}