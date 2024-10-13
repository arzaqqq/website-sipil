<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avarage extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function evaluasi()
    {
        return $this->belongsTo(Evaluasi::class);
    }

    public function matakuliah()
{
    return $this->belongsTo(Matakuliah::class, 'matakuliah_id');
}
}