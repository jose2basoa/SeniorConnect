<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nome_publico' => ['required', 'string', 'max:100'],
            'cargo' => ['nullable', 'string', 'max:100'],
            'comentario' => ['required', 'string', 'min:10', 'max:1000'],
        ]);

        Comentario::create([
            'user_id' => auth()->id(),
            'nome_publico' => $request->nome_publico,
            'cargo' => $request->cargo,
            'comentario' => $request->comentario,
            'status' => 'pendente',
            'publicado' => false,
            'aprovado_em' => null,
            'aprovado_por' => null,
        ]);

        return back()->with('success', 'Comentário enviado com sucesso e aguardando aprovação.');
    }
}