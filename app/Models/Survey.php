<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ratings()
    {
        return $this->hasMany(SurveyRating::class);
    }

    // public function questions()
    // {
    //     return $this->belongsToMany(SurveyQuestion::class, 'survey_ratings');
    // }
}
