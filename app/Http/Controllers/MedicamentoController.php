<?php

namespace App\Http\Controllers;

use App\Models\Idoso;
use App\Models\Medicamento;
use Illuminate\Http\Request;

class MedicamentoController extends Controller
{
    private function validarAcesso(Idoso $idoso): void
    {
        $user = auth()->user();

        $idoso->loadMissing('users');

        $temPermissao = $user->is_admin || $idoso->users->contains('id', $user->id);

        abort_unless($temPermissao, 403, 'Você não tem permissão para acessar esta pessoa.');
    }

    private function validarMedicamentoDoIdoso(Idoso $idoso, Medicamento $medicamento): void
    {
        abort_unless(
            (int) $medicamento->idoso_id === (int) $idoso->id,
            404,
            'Medicamento não encontrado para esta pessoa.'
        );
    }

    public function index(Idoso $idoso)
    {
        $this->validarAcesso($idoso);

        $medicamentos = $idoso->medicamentos()
            ->orderBy('horario')
            ->get();

        return view('medicamentos.index', compact('idoso', 'medicamentos'));
    }

    public function create(Idoso $idoso)
    {
        $this->validarAcesso($idoso);

        return view('medicamentos.create', compact('idoso'));
    }

    public function store(Request $request, Idoso $idoso)
    {
        $this->validarAcesso($idoso);

        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'dosagem' => ['nullable', 'string', 'max:255'],
            'horario' => ['required', 'date_format:H:i'],
            'frequencia' => ['nullable', 'string', 'max:255'],
            'observacoes' => ['nullable', 'string'],
            'data_inicio' => ['nullable', 'date'],
            'data_fim' => ['nullable', 'date', 'after_or_equal:data_inicio'],
            'ativo' => ['nullable', 'boolean'],
            'tomado' => ['nullable', 'boolean'],
        ]);

        $dados['idoso_id'] = $idoso->id;
        $dados['ativo'] = $request->boolean('ativo', true);
        $dados['tomado'] = $request->boolean('tomado');

        Medicamento::create($dados);

        return redirect()
            ->route('medicamentos.index', $idoso->id)
            ->with('success', 'Medicamento cadastrado com sucesso.');
    }

    public function edit(Idoso $idoso, Medicamento $medicamento)
    {
        $this->validarAcesso($idoso);
        $this->validarMedicamentoDoIdoso($idoso, $medicamento);

        return view('medicamentos.edit', compact('idoso', 'medicamento'));
    }

    public function update(Request $request, Idoso $idoso, Medicamento $medicamento)
    {
        $this->validarAcesso($idoso);
        $this->validarMedicamentoDoIdoso($idoso, $medicamento);

        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'dosagem' => ['nullable', 'string', 'max:255'],
            'horario' => ['required', 'date_format:H:i'],
            'frequencia' => ['nullable', 'string', 'max:255'],
            'observacoes' => ['nullable', 'string'],
            'data_inicio' => ['nullable', 'date'],
            'data_fim' => ['nullable', 'date', 'after_or_equal:data_inicio'],
            'ativo' => ['nullable', 'boolean'],
            'tomado' => ['nullable', 'boolean'],
        ]);

        $dados['ativo'] = $request->boolean('ativo');
        $dados['tomado'] = $request->boolean('tomado');

        $medicamento->update($dados);

        return redirect()
            ->route('medicamentos.index', $idoso->id)
            ->with('success', 'Medicamento atualizado com sucesso.');
    }

    public function destroy(Idoso $idoso, Medicamento $medicamento)
    {
        $this->validarAcesso($idoso);
        $this->validarMedicamentoDoIdoso($idoso, $medicamento);

        $medicamento->delete();

        return redirect()
            ->route('medicamentos.index', $idoso->id)
            ->with('success', 'Medicamento removido com sucesso.');
    }

    public function toggleTomado(Idoso $idoso, Medicamento $medicamento)
    {
        $this->validarAcesso($idoso);
        $this->validarMedicamentoDoIdoso($idoso, $medicamento);

        $medicamento->update([
            'tomado' => !$medicamento->tomado,
        ]);

        return back()->with('success', 'Status do medicamento atualizado com sucesso.');
    }
}