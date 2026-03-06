<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $fillable = [
        'idoso_id',
        'tipo',
        'descricao',
        'resolvido',
    ];

    protected $casts = [
        'resolvido' => 'boolean',
    ];

    public function idoso()
    {
        return $this->belongsTo(\App\Models\Idoso::class);
    }
}