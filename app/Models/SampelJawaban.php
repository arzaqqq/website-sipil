<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SampelJawaban extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class ,'matakuliah_id'); 
    }
}