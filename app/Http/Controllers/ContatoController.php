<?php

namespace App\Http\Controllers;

use App\Models\Idoso;

class ContatoController extends Controller
{
    public function index(Idoso $idoso)
    {
        // só permite se o idoso estiver vinculado ao usuário logado (pivot)
        abort_unless(
            auth()->user()->idosos()->where('idosos.id', $idoso->id)->exists(),
            403
        );

        $tutores = $idoso->users()
            ->select('users.id', 'users.name', 'users.telefone', 'users.email')
            ->orderBy('users.name')
            ->get();

        $contatosEmergencia = $idoso->contatosEmergencia()
            ->orderBy('prioridade')
            ->get();

        return view('contatos.index', compact('idoso', 'tutores', 'contatosEmergencia'));
    }
}
