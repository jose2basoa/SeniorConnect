<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DadosClinico extends Model
{
    use HasFactory;

    protected $table = 'dados_clinicos';

    protected $fillable = [
        'idoso_id',
        'cartao_sus',
        'plano_saude',
        'numero_plano',
        'tipo_sanguineo',
        'alergias',
        'doencas_cronicas',
        'restricoes',
    ];

    public function idoso()
    {
        return $this->belongsTo(Idoso::class);
    }
}