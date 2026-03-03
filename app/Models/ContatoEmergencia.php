<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContatoEmergencia extends Model
{
    protected $fillable = [
        'idoso_id',
        'nome',
        'telefone',
        'parentesco',
        'prioridade'
    ];

    public function idoso()
    {
        return $this->belongsTo(Idoso::class);
    }
}
