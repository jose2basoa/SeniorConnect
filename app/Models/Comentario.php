<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comentario extends Model
{
    use HasFactory;

    protected $table = 'comentarios';

    protected $fillable = [
        'user_id',
        'nome_publico',
        'cargo',
        'comentario',
        'status',
        'publicado',
        'aprovado_em',
        'aprovado_por',
    ];

    protected $casts = [
        'publicado' => 'boolean',
        'aprovado_em' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function aprovador()
    {
        return $this->belongsTo(User::class, 'aprovado_por');
    }

    public function scopePendentes($query)
    {
        return $query->where('status', 'pendente');
    }

    public function scopeAprovados($query)
    {
        return $query->where('status', 'aprovado')
                     ->where('publicado', true);
    }

    public function scopeRejeitados($query)
    {
        return $query->where('status', 'rejeitado');
    }
}