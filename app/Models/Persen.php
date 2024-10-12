<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persen extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class);
    }
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function hasil()
    {
        return $this->hasMany(Hasil::class);
    }
}