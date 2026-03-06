<?php

namespace App\Http\Controllers;

use App\Models\Idoso;
use App\Models\Evento;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    private function buscarIdosoPermitido(int $idosoId): Idoso
    {
        $user = auth()->user();

        $idoso = Idoso::with('users')->findOrFail($idosoId);

        $temPermissao = $user->is_admin || $idoso->users->contains('id', $user->id);

        abort_unless($temPermissao, 403, 'Você não tem permissão para acessar esta pessoa.');

        return $idoso;
    }

    public function index(Idoso $idoso)
    {
        $idoso = $this->buscarIdosoPermitido($idoso->id);

        return view('eventos.index', [
            'idoso' => $idoso,
            'eventos' => $idoso->eventos()->latest()->get(),
        ]);
    }

    public function create(Idoso $idoso)
    {
        $idoso = $this->buscarIdosoPermitido($idoso->id);

        return view('eventos.create', compact('idoso'));
    }

    public function store(Request $request, Idoso $idoso)
    {
        $idoso = $this->buscarIdosoPermitido($idoso->id);

        $dados = $request->validate([
            'tipo' => 'required|in:queda,medicacao,sintoma,rotina,consulta,comportamento,outro',
            'descricao' => 'required|string|max:1000',
            'resolvido' => 'nullable|boolean',
        ]);

        $dados['resolvido'] = $request->boolean('resolvido');

        $idoso->eventos()->create($dados);

        return redirect()
            ->route('eventos.index', $idoso->id)
            ->with('success', 'Evento cadastrado com sucesso.');
    }

    public function edit(Idoso $idoso, Evento $evento)
    {
        $idoso = $this->buscarIdosoPermitido($idoso->id);

        abort_unless($evento->idoso_id === $idoso->id, 404);

        return view('eventos.edit', compact('idoso', 'evento'));
    }

    public function update(Request $request, Idoso $idoso, Evento $evento)
    {
        $idoso = $this->buscarIdosoPermitido($idoso->id);

        abort_unless($evento->idoso_id === $idoso->id, 404);

        $dados = $request->validate([
            'tipo' => 'required|string|max:100',
            'descricao' => 'required|string|max:1000',
            'resolvido' => 'nullable|boolean',
        ]);

        $dados['resolvido'] = $request->boolean('resolvido');

        $evento->update($dados);

        return redirect()
            ->route('eventos.index', $idoso->id)
            ->with('success', 'Evento atualizado com sucesso.');
    }

    public function destroy(Idoso $idoso, Evento $evento)
    {
        $idoso = $this->buscarIdosoPermitido($idoso->id);

        abort_unless($evento->idoso_id === $idoso->id, 404);

        $evento->delete();

        return redirect()
            ->route('eventos.index', $idoso->id)
            ->with('success', 'Evento removido com sucesso.');
    }

    public function toggleResolvido(Idoso $idoso, Evento $evento)
    {
        $idoso = $this->buscarIdosoPermitido($idoso->id);

        abort_unless($evento->idoso_id === $idoso->id, 404);

        $evento->update([
            'resolvido' => !$evento->resolvido
        ]);

        return back()->with('success', 'Status do evento atualizado.');
    }
}