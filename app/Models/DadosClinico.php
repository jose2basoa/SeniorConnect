<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DadosClinico extends Model
{
    protected $fillable = [
    'idoso_id',
    'cartao_sus',
    'plano_saude',
    'numero_plano',
    'tipo_sanguineo',
    'alergias',
    'doencas_cronicas',
    'restricoes'
    ];

    public function idoso()
    {
        return $this->belongsTo(Idoso::class);
    }
}
