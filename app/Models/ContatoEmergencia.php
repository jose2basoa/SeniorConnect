<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContatoEmergencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'idoso_id',
        'nome',
        'telefone',
        'parentesco',
        'prioridade',
    ];

    protected function casts(): array
    {
        return [
            'prioridade' => 'integer',
        ];
    }

    public function idoso()
    {
        return $this->belongsTo(Idoso::class);
    }
}