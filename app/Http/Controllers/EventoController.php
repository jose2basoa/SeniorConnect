<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Idoso;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    private function buscarIdosoPermitido(int $idosoId): Idoso
    {
        $user = auth()->user();
        abort_unless($user, 401);

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
            'eventos' => $idoso->eventos()->latest('data_evento')->latest()->get(),
        ]);
    }

    public function create($idosoId)
    {
        $idoso = $this->buscarIdosoPermitido((int) $idosoId);

        return view('eventos.create', compact('idoso'));
    }

    public function store(Request $request, Idoso $idoso)
    {
        $idoso = $this->buscarIdosoPermitido($idoso->id);

        $dados = $request->validate([
            'tipo' => ['required', 'in:queda,medicacao,sintoma,rotina,consulta,comportamento,outro'],
            'nivel' => ['required', 'in:baixo,medio,alto,critico'],
            'origem' => ['nullable', 'in:manual,sistema,app'],
            'descricao' => ['required', 'string', 'max:1000'],
            'resolvido' => ['nullable', 'boolean'],
            'data_evento' => ['nullable', 'date'],
        ]);

        $dados['origem'] = $dados['origem'] ?? 'manual';
        $dados['resolvido'] = $request->boolean('resolvido');
        $dados['resolvido_em'] = $dados['resolvido'] ? now() : null;
        $dados['data_evento'] = $dados['data_evento'] ?? now();

        $idoso->eventos()->create($dados);

        return redirect()
            ->route('eventos.index', $idoso->id)
            ->with('success', 'Evento cadastrado com sucesso.');
    }

    public function edit(Idoso $idoso, Evento $evento)
    {
        $idoso = $this->buscarIdosoPermitido($idoso->id);

        abort_unless((int) $evento->idoso_id === (int) $idoso->id, 404);

        return view('eventos.edit', compact('idoso', 'evento'));
    }

    public function update(Request $request, Idoso $idoso, Evento $evento)
    {
        $idoso = $this->buscarIdosoPermitido($idoso->id);

        abort_unless((int) $evento->idoso_id === (int) $idoso->id, 404);

        $dados = $request->validate([
            'tipo' => ['required', 'in:queda,medicacao,sintoma,rotina,consulta,comportamento,outro'],
            'nivel' => ['required', 'in:baixo,medio,alto,critico'],
            'origem' => ['nullable', 'in:manual,sistema,app'],
            'descricao' => ['required', 'string', 'max:1000'],
            'resolvido' => ['nullable', 'boolean'],
            'data_evento' => ['nullable', 'date'],
        ]);

        $resolvido = $request->boolean('resolvido');

        $dados['origem'] = $dados['origem'] ?? 'manual';
        $dados['resolvido'] = $resolvido;
        $dados['resolvido_em'] = $resolvido ? ($evento->resolvido_em ?? now()) : null;
        $dados['data_evento'] = $dados['data_evento'] ?? $evento->data_evento ?? now();

        $evento->update($dados);

        return redirect()
            ->route('eventos.index', $idoso->id)
            ->with('success', 'Evento atualizado com sucesso.');
    }

    public function destroy(Idoso $idoso, Evento $evento)
    {
        $idoso = $this->buscarIdosoPermitido($idoso->id);

        abort_unless((int) $evento->idoso_id === (int) $idoso->id, 404);

        $evento->delete();

        return redirect()
            ->route('eventos.index', $idoso->id)
            ->with('success', 'Evento removido com sucesso.');
    }

    public function toggleResolvido(Idoso $idoso, Evento $evento)
    {
        $idoso = $this->buscarIdosoPermitido($idoso->id);

        abort_unless((int) $evento->idoso_id === (int) $idoso->id, 404);

        $novoStatus = !$evento->resolvido;

        $evento->update([
            'resolvido' => $novoStatus,
            'resolvido_em' => $novoStatus ? now() : null,
        ]);

        return back()->with('success', 'Status do evento atualizado.');
    }
}
