<?php

namespace App\Http\Controllers;

use App\Models\Idoso;

class ContatoController extends Controller
{
    private function buscarIdosoPermitido(int $idosoId): Idoso
    {
        $user = auth()->user();

        $idoso = Idoso::with(['users', 'contatosEmergencia'])->findOrFail($idosoId);

        $temPermissao = $user->is_admin || $idoso->users->contains('id', $user->id);

        abort_unless($temPermissao, 403, 'Você não tem permissão para acessar esta pessoa.');

        return $idoso;
    }

    public function index(Idoso $idoso)
    {
        $idoso = $this->buscarIdosoPermitido($idoso->id);

        return view('contatos.index', [
            'idoso' => $idoso,
            'tutores' => $idoso->users()->get(),
            'contatosEmergencia' => $idoso->contatosEmergencia()->orderBy('prioridade')->get(),
        ]);
    }
}