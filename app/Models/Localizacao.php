<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localizacao extends Model
{
    use HasFactory;

    protected $table = 'localizacoes';

    protected $fillable = [
        'idoso_id',
        'latitude',
        'longitude',
        'endereco',
        'precisao',
        'capturado_em',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'precisao' => 'decimal:2',
            'capturado_em' => 'datetime',
        ];
    }

    public function idoso()
    {
        return $this->belongsTo(Idoso::class);
    }
}