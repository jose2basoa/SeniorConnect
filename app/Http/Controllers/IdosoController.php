<?php

namespace App\Http\Controllers;

use App\Models\ContatoEmergencia;
use App\Models\DadosClinico;
use App\Models\Endereco;
use App\Models\Idoso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class IdosoController extends Controller
{
    private function onlyDigits(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $digits = preg_replace('/\D/', '', $value);

        return $digits !== '' ? $digits : null;
    }

    private function ensureVinculo(Idoso $idoso): void
    {
        $user = Auth::user();

        abort_unless($user, 401);

        if ($user->is_admin) {
            return;
        }

        $vinculado = $idoso->users()
            ->where('users.id', $user->id)
            ->exists();

        abort_unless($vinculado, 403);
    }

    public function createStep1(Idoso $idoso = null)
    {
        if ($idoso && $idoso->exists) {
            $this->ensureVinculo($idoso);
        }

        return view('idosos.steps.step1', compact('idoso'));
    }

    public function storeStep1(Request $request, Idoso $idoso = null)
    {
        $idosoId = $idoso?->id;

        $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'data_nascimento' => ['required', 'date'],
            'sexo' => ['nullable', 'string', 'max:20'],
            'cpf' => [
                'required',
                'regex:/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/',
                Rule::unique('idosos', 'cpf')->ignore($idosoId),
            ],
            'telefone' => ['nullable', 'regex:/^\(\d{2}\)\s\d{4,5}\-\d{4}$/'],
            'observacoes' => ['nullable', 'string', 'max:2000'],
        ]);

        $dados = [
            'nome' => $request->nome,
            'data_nascimento' => $request->data_nascimento,
            'sexo' => $request->sexo,
            'cpf' => $this->onlyDigits($request->cpf),
            'telefone' => $this->onlyDigits($request->telefone),
            'observacoes' => $request->observacoes,
        ];

        if ($idoso && $idoso->exists) {
            $this->ensureVinculo($idoso);
            $idoso->update($dados);
        } else {
            $idoso = Idoso::create($dados);

            $userId = Auth::id();
            abort_unless($userId, 401);

            $idoso->users()->syncWithoutDetaching([$userId]);
        }

        return redirect()->route('idosos.create.step2', $idoso->id);
    }

    public function createStep2(Idoso $idoso)
    {
        $this->ensureVinculo($idoso);

        $endereco = $idoso->endereco;

        return view('idosos.steps.step2', compact('idoso', 'endereco'));
    }

    public function storeStep2(Request $request, Idoso $idoso)
    {
        $this->ensureVinculo($idoso);

        $request->validate([
            'cep' => ['nullable', 'regex:/^\d{5}\-\d{3}$/'],
            'logradouro' => ['nullable', 'string', 'max:255'],
            'numero' => ['nullable', 'string', 'max:20'],
            'complemento' => ['nullable', 'string', 'max:255'],
            'bairro' => ['nullable', 'string', 'max:255'],
            'cidade' => ['nullable', 'string', 'max:255'],
            'estado' => ['nullable', 'string', 'size:2'],
        ]);

        Endereco::updateOrCreate(
            ['idoso_id' => $idoso->id],
            [
                'cep' => $this->onlyDigits($request->cep),
                'logradouro' => $request->logradouro,
                'numero' => $request->numero,
                'complemento' => $request->complemento,
                'bairro' => $request->bairro,
                'cidade' => $request->cidade,
                'estado' => $request->estado ? strtoupper($request->estado) : null,
            ]
        );

        return redirect()->route('idosos.create.step3', $idoso->id);
    }

    public function createStep3(Idoso $idoso)
    {
        $this->ensureVinculo($idoso);

        $dadosClinico = $idoso->dadosClinico;

        return view('idosos.steps.step3', compact('idoso', 'dadosClinico'));
    }

    public function storeStep3(Request $request, Idoso $idoso)
    {
        $this->ensureVinculo($idoso);

        $request->validate([
            'cartao_sus' => ['nullable', 'string', 'max:30'],
            'plano_saude' => ['nullable', 'string', 'max:255'],
            'numero_plano' => ['nullable', 'string', 'max:50'],
            'tipo_sanguineo' => ['nullable', 'string', 'max:3'],
            'alergias' => ['nullable', 'string', 'max:2000'],
            'doencas_cronicas' => ['nullable', 'string', 'max:2000'],
            'restricoes' => ['nullable', 'string', 'max:2000'],
        ]);

        DadosClinico::updateOrCreate(
            ['idoso_id' => $idoso->id],
            $request->only([
                'cartao_sus',
                'plano_saude',
                'numero_plano',
                'tipo_sanguineo',
                'alergias',
                'doencas_cronicas',
                'restricoes',
            ])
        );

        return redirect()->route('idosos.create.step4', $idoso->id);
    }

    public function createStep4(Idoso $idoso)
    {
        $this->ensureVinculo($idoso);

        $contatos = $idoso->contatosEmergencia;

        return view('idosos.steps.step4', compact('idoso', 'contatos'));
    }

    public function storeStep4(Request $request, Idoso $idoso)
    {
        $this->ensureVinculo($idoso);

        $request->validate([
            'contatos' => ['required', 'array', 'min:1'],
            'contatos.*.nome' => ['required', 'string', 'max:255'],
            'contatos.*.telefone' => ['required', 'regex:/^\(\d{2}\)\s\d{4,5}\-\d{4}$/'],
            'contatos.*.parentesco' => ['nullable', 'string', 'max:255'],
        ]);

        $idoso->contatosEmergencia()->delete();

        foreach ($request->contatos as $index => $contato) {
            ContatoEmergencia::create([
                'idoso_id' => $idoso->id,
                'nome' => $contato['nome'],
                'telefone' => $this->onlyDigits($contato['telefone']),
                'parentesco' => $contato['parentesco'] ?? null,
                'prioridade' => $index + 1,
            ]);
        }

        return redirect()->route('dashboard')
            ->with('success', 'Cadastro finalizado com sucesso!');
    }

    public function removerContato(Idoso $idoso, ContatoEmergencia $contato)
    {
        $this->ensureVinculo($idoso);

        abort_unless((int) $contato->idoso_id === (int) $idoso->id, 403);

        if ($idoso->contatosEmergencia()->count() <= 1) {
            return back()->with('error', 'É obrigatório manter pelo menos um contato.');
        }

        $contato->delete();

        return back()->with('success', 'Contato removido com sucesso.');
    }

    public function gerenciar()
    {
        $user = auth()->user();

        $idosos = \App\Models\Idoso::with('users')->get();

        if ($user && $user->is_admin) {
            $idosos = $idosos->sortByDesc(function ($idoso) use ($user) {
                return $idoso->users->contains('id', $user->id) ? 1 : 0;
            })->values();
        } else {
            $idosos = $user->idosos()->with('users')->get();
        }

        return view('idosos.gerenciar', compact('idosos'));
    }

    public function vincularForm()
    {
        return view('idosos.vincular');
    }

    public function vincular(Request $request)
    {
        $request->validate([
            'cpf' => ['required', 'regex:/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/'],
            'data_nascimento' => ['required', 'date'],
        ]);

        $idoso = Idoso::where('cpf', $this->onlyDigits($request->cpf))
            ->where('data_nascimento', $request->data_nascimento)
            ->first();

        if (!$idoso) {
            return back()->with('erro', 'Cadastro não encontrado.');
        }

        $userId = Auth::id();
        abort_unless($userId, 401);

        $idoso->users()->syncWithoutDetaching([$userId]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Vínculo realizado com sucesso!');
    }

    public function desvincular(Idoso $idoso)
    {
        $this->ensureVinculo($idoso);

        $user = Auth::user();
        abort_unless($user, 401);

        $temVinculo = $idoso->users()
            ->where('users.id', $user->id)
            ->exists();

        if (!$temVinculo) {
            return back()->with('error', 'Você não possui vínculo com este cadastro.');
        }

        $idoso->users()->detach($user->id);

        return redirect()
            ->route('idosos.gerenciar')
            ->with('success', 'Vínculo removido com sucesso.');
    }

    public function escolherCadastro()
    {
        return view('idosos.escolher-cadastro');
    }

    public function show(Idoso $idoso)
    {
        $this->ensureVinculo($idoso);

        $idoso->load(['endereco', 'dadosClinico', 'contatosEmergencia', 'users']);

        return view('idosos.show', compact('idoso'));
    }

    public function edit(Idoso $idoso)
    {
        $this->ensureVinculo($idoso);

        $idoso->load(['endereco', 'dadosClinico', 'contatosEmergencia', 'users']);

        return view('idosos.edit', compact('idoso'));
    }

    public function updateStep1(Request $request, Idoso $idoso)
    {
        $this->ensureVinculo($idoso);

        $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'data_nascimento' => ['required', 'date'],
            'sexo' => ['nullable', 'string', 'max:20'],
            'cpf' => [
                'required',
                'regex:/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/',
                Rule::unique('idosos', 'cpf')->ignore($idoso->id),
            ],
            'telefone' => ['nullable', 'regex:/^\(\d{2}\)\s\d{4,5}\-\d{4}$/'],
            'observacoes' => ['nullable', 'string', 'max:2000'],
        ]);

        $idoso->update([
            'nome' => $request->nome,
            'data_nascimento' => $request->data_nascimento,
            'sexo' => $request->sexo,
            'cpf' => $this->onlyDigits($request->cpf),
            'telefone' => $this->onlyDigits($request->telefone),
            'observacoes' => $request->observacoes,
        ]);

        return back()->with('success_step1', 'Dados pessoais atualizados!');
    }

    public function updateStep2(Request $request, Idoso $idoso)
    {
        $this->ensureVinculo($idoso);

        $request->validate([
            'cep' => ['nullable', 'regex:/^\d{5}\-\d{3}$/'],
            'logradouro' => ['nullable', 'string', 'max:255'],
            'numero' => ['nullable', 'string', 'max:20'],
            'complemento' => ['nullable', 'string', 'max:255'],
            'bairro' => ['nullable', 'string', 'max:255'],
            'cidade' => ['nullable', 'string', 'max:255'],
            'estado' => ['nullable', 'string', 'size:2'],
        ]);

        Endereco::updateOrCreate(
            ['idoso_id' => $idoso->id],
            [
                'cep' => $this->onlyDigits($request->cep),
                'logradouro' => $request->logradouro,
                'numero' => $request->numero,
                'complemento' => $request->complemento,
                'bairro' => $request->bairro,
                'cidade' => $request->cidade,
                'estado' => $request->estado ? strtoupper($request->estado) : null,
            ]
        );

        return back()->with('success_step2', 'Endereço atualizado!');
    }

    public function updateStep3(Request $request, Idoso $idoso)
    {
        $this->ensureVinculo($idoso);

        $request->validate([
            'cartao_sus' => ['nullable', 'string', 'max:30'],
            'plano_saude' => ['nullable', 'string', 'max:255'],
            'numero_plano' => ['nullable', 'string', 'max:50'],
            'tipo_sanguineo' => ['nullable', 'string', 'max:3'],
            'alergias' => ['nullable', 'string', 'max:2000'],
            'doencas_cronicas' => ['nullable', 'string', 'max:2000'],
            'restricoes' => ['nullable', 'string', 'max:2000'],
        ]);

        DadosClinico::updateOrCreate(
            ['idoso_id' => $idoso->id],
            $request->only([
                'cartao_sus',
                'plano_saude',
                'numero_plano',
                'tipo_sanguineo',
                'alergias',
                'doencas_cronicas',
                'restricoes',
            ])
        );

        return back()->with('success_step3', 'Dados clínicos atualizados!');
    }

    public function updateStep4(Request $request, Idoso $idoso)
    {
        $this->ensureVinculo($idoso);

        $request->validate([
            'contatos' => ['required', 'array', 'min:1'],
            'contatos.*.nome' => ['required', 'string', 'max:255'],
            'contatos.*.telefone' => ['required', 'regex:/^\(\d{2}\)\s\d{4,5}\-\d{4}$/'],
            'contatos.*.parentesco' => ['nullable', 'string', 'max:255'],
        ]);

        $idoso->contatosEmergencia()->delete();

        foreach ($request->contatos as $index => $c) {
            ContatoEmergencia::create([
                'idoso_id' => $idoso->id,
                'nome' => $c['nome'],
                'telefone' => $this->onlyDigits($c['telefone']),
                'parentesco' => $c['parentesco'] ?? null,
                'prioridade' => $index + 1,
            ]);
        }

        return back()->with('success_step4', 'Contatos atualizados!');
    }

    public function update(Request $request, Idoso $idoso)
    {
        $this->ensureVinculo($idoso);

        $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'data_nascimento' => ['required', 'date'],
            'sexo' => ['nullable', 'string', 'max:20'],
            'cpf' => [
                'required',
                'regex:/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/',
                Rule::unique('idosos', 'cpf')->ignore($idoso->id),
            ],
            'telefone' => ['nullable', 'regex:/^\(\d{2}\)\s\d{4,5}\-\d{4}$/'],
            'observacoes' => ['nullable', 'string', 'max:2000'],
        ]);

        $idoso->update([
            'nome' => $request->nome,
            'data_nascimento' => $request->data_nascimento,
            'sexo' => $request->sexo,
            'cpf' => $this->onlyDigits($request->cpf),
            'telefone' => $this->onlyDigits($request->telefone),
            'observacoes' => $request->observacoes,
        ]);

        return redirect()
            ->route('idosos.show', $idoso->id)
            ->with('success', 'Perfil atualizado com sucesso!');
    }

    public function vincularAdmin(Idoso $idoso)
    {
        $user = auth()->user();

        abort_unless($user, 401);
        abort_unless($user->is_admin, 403);

        if (!$idoso->users()->where('users.id', $user->id)->exists()) {
            $idoso->users()->attach($user->id);
        }

        return back()->with('success', 'Vínculo realizado com sucesso.');
    }
}