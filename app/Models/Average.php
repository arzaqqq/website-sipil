<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Average extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class, 'matakuliah_id');
    }

    public function hasil()
    {
        return $this->hasMany(Hasil::class, 'matakuliah_id', 'matakuliah_id');
    }

    public function evaluasi()
    {
        return $this->hasMany(Evaluasi::class,);
    }
}