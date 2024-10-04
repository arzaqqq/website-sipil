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

    public function user(): BelongsTo
    {
        return $this->belongsTo(user::class);
    }
}