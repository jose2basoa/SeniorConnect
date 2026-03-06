<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $fillable = [
        'idoso_id',
        'tipo',
        'nivel',
        'origem',
        'descricao',
        'resolvido',
        'resolvido_em',
        'data_evento',
    ];

    protected function casts(): array
    {
        return [
            'resolvido' => 'boolean',
            'resolvido_em' => 'datetime',
            'data_evento' => 'datetime',
        ];
    }

    public function idoso()
    {
        return $this->belongsTo(Idoso::class);
    }
}