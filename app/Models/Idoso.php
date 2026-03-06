<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Idoso extends Model
{
    protected $fillable = [
        'nome',
        'data_nascimento',
        'sexo',
        'cpf',
        'telefone',
        'observacoes',
        'status_online',
        'ultima_atividade'
    ];

    public function endereco()
    {
        return $this->hasOne(Endereco::class);
    }

    public function dadosClinico()
    {
        return $this->hasOne(DadosClinico::class);
    }

    public function contatosEmergencia()
    {
        return $this->hasMany(\App\Models\ContatoEmergencia::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'idoso_user')->withTimestamps();
    }
}
