<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'idoso_id',
        'nome',
        'horario',
        'tomado'
    ];

    public function idoso()
    {
        return $this->belongsTo(Idoso::class);
    }
}
