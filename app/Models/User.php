<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'sobrenome',
        'cpf',
        'telefone',
        'data_nascimento',
        'cep',
        'logradouro',
        'numero',
        'bairro',
        'cidade',
        'estado',
        'complemento',
        'email',
        'password',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'data_nascimento' => 'date',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    public function idosos()
    {
        return $this->belongsToMany(Idoso::class, 'idoso_user')->withTimestamps();
    }

    public function getNomeCompletoAttribute(): string
    {
        return trim(($this->name ?? '') . ' ' . ($this->sobrenome ?? ''));
    }
}