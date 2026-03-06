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
        'data_inicio',
        'data_fim',
        'ativo',
        'tomado',
    ];

    protected function casts(): array
    {
        return [
            'horario' => 'datetime:H:i',
            'data_inicio' => 'date',
            'data_fim' => 'date',
            'ativo' => 'boolean',
            'tomado' => 'boolean',
        ];
    }

    public function idoso()
    {
        return $this->belongsTo(Idoso::class);
    }
}