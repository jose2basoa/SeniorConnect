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
        'dosagem',
        'horario',
        'frequencia',
        'observacoes',
        'tomado',
    ];

    protected function casts(): array
    {
        return [
            'tomado' => 'boolean',
        ];
    }

    public function idoso()
    {
        return $this->belongsTo(Idoso::class);
    }
}