<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KontrakKuliah extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function matakuliah(): BelongsTo
    {
        return $this->belongsTo(MataKuliah::class,'id_mk');
    }
}