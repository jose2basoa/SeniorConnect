<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Idoso extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome',
        'data_nascimento',
        'sexo',
        'cpf',
        'telefone',
        'observacoes',
        'status_online',
        'ultima_atividade',
    ];

    protected function casts(): array
    {
        return [
            'data_nascimento' => 'date',
            'status_online' => 'boolean',
            'ultima_atividade' => 'datetime',
        ];
    }

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
        return $this->hasMany(ContatoEmergencia::class)->orderBy('prioridade');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'idoso_user')->withTimestamps();
    }

    public function medicamentos()
    {
        return $this->hasMany(Medicamento::class);
    }

    public function eventos()
    {
        return $this->hasMany(Evento::class);
    }

    public function localizacoes()
    {
        return $this->hasMany(Localizacao::class);
    }

    public function ultimaLocalizacao()
    {
        return $this->hasOne(Localizacao::class)->latestOfMany('capturado_em');
    }
}