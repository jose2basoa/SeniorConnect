<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localizacao extends Model
{
    use HasFactory;

    protected $table = 'localizacoes'; // nome da tabela no banco de dados
    protected $fillable = ['idoso_id', 'latitude', 'longitude']; // campos preenchíveis
}
