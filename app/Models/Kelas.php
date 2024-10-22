<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $guarded =[]; 

    public function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class, 'matakuliah_id');
    }

    public function soals()
    {
        return $this->hasMany(Soal::class);
    }

    public function persen()
    {
        return $this->hasMany(Persen::class);
    }

    public function rublik()
    {
        return $this->belongsTo(Rubrik::class);
    }

    public function filehasil()
    {
        return $this->hasMany(FileHasil::class);
    } 
}