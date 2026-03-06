<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Idoso;
use App\Models\Endereco;
use App\Models\DadosClinico;
use App\Models\ContatoEmergencia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IdosoController extends Controller
{
    /* =========================
        HELPERS
    ==========================*/

    private function ensureVinculo(Idoso $idoso): void
    {
        $user = Auth::user();
        if (!$user) {
            abort(401);
        }

        // Admin pode acessar qualquer idoso (recomendado)
        if (!empty($user->is_admin) && $user->is_admin) {
            return;
        }

        // Verifica se o idoso está vinculado ao usuário logado pela pivô
        $vinculado = $idoso->users()
            ->where('users.id', $user->id)
            ->exists();

        if (!$vinculado) {
            abort(403);
        }
    }

    /* =========================
        STEP 1 - DADOS PESSOAIS
    ==========================*/

    public function createStep1(Idoso $idoso = null)
    {
        return view('idosos.steps.step1', compact('idoso'));
    }

    public function storeStep1(Request $request, Idoso $idoso = null)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'sexo' => 'nullable|string|max:30',
            'cpf' => 'nullable|string|max:14',
            'telefone' => 'nullable|string|max:30',
            'observacoes' => 'nullable|string|max:2000'
        ], [
            'nome.required' => 'Informe o nome.',
            'data_nascimento.required' => 'Informe a data de nascimento.',
            'data_nascimento.date' => 'Informe uma data válida.',
        ]);

        if ($idoso && $idoso->exists) {
            $this->ensureVinculo($idoso);

            $idoso->update([
                'nome' => $request->nome,
                'data_nascimento' => $request->data_nascimento,
                'sexo' => $request->sexo,
                'cpf' => $request->cpf,
                'telefone' => $request->telefone,
                'observacoes' => $request->observacoes,
            ]);
        } else {
            $idoso = Idoso::create([
                'nome' => $request->nome,
                'data_nascimento' => $request->data_nascimento,
                'sexo' => $request->sexo,
                'cpf' => $request->cpf,
                'telefone' => $request->telefone,
                'observacoes' => $request->observacoes,
            ]);

            // vincula na pivô (idoso_user)
            $userId = Auth::id();
            if (!$userId) abort(401);

            $idoso->users()->syncWithoutDetaching([$userId]);
        }

        return redirect()->route('idosos.create.step2', $idoso->id);
    }

    /* =========================
        STEP 2 - ENDEREÇO
    ==========================*/

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
            'cep' => 'nullable|string|max:10',
            'rua' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:20',
            'complemento' => 'nullable|string|max:255',
            'bairro' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:255',
            'estado' => 'nullable|string|max:2',
        ]);

        Endereco::updateOrCreate(
            ['idoso_id' => $idoso->id],
            [
                'cep' => $request->cep,
                'rua' => $request->rua,
                'numero' => $request->numero,
                'complemento' => $request->complemento,
                'bairro' => $request->bairro,
                'cidade' => $request->cidade,
                'estado' => $request->estado,
            ]
        );

        return redirect()->route('idosos.create.step3', $idoso->id);
    }

    /* =========================
        STEP 3 - DADOS CLÍNICOS
    ==========================*/

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
            'cartao_sus' => 'nullable|string|max:30',
            'plano_saude' => 'nullable|string|max:255',
            'numero_plano' => 'nullable|string|max:50',
            'tipo_sanguineo' => 'nullable|string|max:10',
            'alergias' => 'nullable|string|max:2000',
            'doencas_cronicas' => 'nullable|string|max:2000',
            'restricoes' => 'nullable|string|max:2000',
        ]);

        DadosClinico::updateOrCreate(
            ['idoso_id' => $idoso->id],
            [
                'cartao_sus' => $request->cartao_sus,
                'plano_saude' => $request->plano_saude,
                'numero_plano' => $request->numero_plano,
                'tipo_sanguineo' => $request->tipo_sanguineo,
                'alergias' => $request->alergias,
                'doencas_cronicas' => $request->doencas_cronicas,
                'restricoes' => $request->restricoes,
            ]
        );

        return redirect()->route('idosos.create.step4', $idoso->id);
    }

    /* =========================
        STEP 4 - CONTATOS
    ==========================*/

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
            'contatos' => 'required|array|min:1',
            'contatos.*.nome' => 'required|string|max:255',
            'contatos.*.telefone' => 'required|string|max:20',
            'contatos.*.parentesco' => 'nullable|string|max:255'
        ]);

        $idoso->contatosEmergencia()->delete();

        foreach ($request->contatos as $index => $contato) {
            ContatoEmergencia::create([
                'idoso_id' => $idoso->id,
                'nome' => $contato['nome'],
                'telefone' => $contato['telefone'],
                'parentesco' => $contato['parentesco'] ?? null,
                'prioridade' => $index + 1
            ]);
        }

        return redirect()->route('dashboard')
            ->with('success', 'Cadastro finalizado com sucesso!');
    }

    /* =========================
        REMOVER CONTATO
    ==========================*/

    public function removerContato(Idoso $idoso, ContatoEmergencia $contato)
    {
        $this->ensureVinculo($idoso);

        if ($contato->idoso_id != $idoso->id) abort(403);

        if ($idoso->contatosEmergencia()->count() <= 1) {
            return back()->with('error', 'É obrigatório manter pelo menos um contato.');
        }

        $contato->delete();

        return back()->with('success', 'Contato removido com sucesso.');
    }

    /* =========================
        GERENCIAR / VINCULAR / DESVINCULAR
    ==========================*/

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
            'cpf' => 'required|string',
            'data_nascimento' => 'required|date'
        ]);

        $idoso = Idoso::where('cpf', $request->cpf)
            ->where('data_nascimento', $request->data_nascimento)
            ->first();

        if (!$idoso) {
            return back()->with('erro', 'Cadastro não encontrado.');
        }

        $userId = Auth::id();
        if (!$userId) abort(401);

        $idoso->users()->syncWithoutDetaching([$userId]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Vínculo realizado com sucesso!');
    }

    public function desvincular(Idoso $idoso)
    {
        $this->ensureVinculo($idoso);

        $user = Auth::user();
        if (!$user) abort(401);

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

    /* =========================
        PERFIL / EDITAR DADOS (NOVO)
    ==========================*/

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

    /* =========================
        UPDATE SEPARADO POR STEP
    ==========================*/

    public function updateStep1(Request $request, Idoso $idoso)
    {
        $this->ensureVinculo($idoso);

        $request->validate([
            'nome' => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'sexo' => 'nullable|string|max:30',
            'cpf' => 'nullable|string|max:14',
            'telefone' => 'nullable|string|max:30',
            'observacoes' => 'nullable|string|max:2000',
        ], [
            'nome.required' => 'Informe o nome.',
            'data_nascimento.required' => 'Informe a data de nascimento.',
        ]);

        $idoso->update($request->only([
            'nome', 'data_nascimento', 'sexo', 'cpf', 'telefone', 'observacoes'
        ]));

        return back()->with('success_step1', 'Dados pessoais atualizados!');
    }

    public function updateStep2(Request $request, Idoso $idoso)
    {
        $this->ensureVinculo($idoso);

        $request->validate([
            'cep' => 'nullable|string|max:10',
            'rua' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:20',
            'complemento' => 'nullable|string|max:255',
            'bairro' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:255',
            'estado' => 'nullable|string|max:2',
        ]);

        Endereco::updateOrCreate(
            ['idoso_id' => $idoso->id],
            $request->only(['cep','rua','numero','complemento','bairro','cidade','estado'])
        );

        return back()->with('success_step2', 'Endereço atualizado!');
    }

    public function updateStep3(Request $request, Idoso $idoso)
    {
        $this->ensureVinculo($idoso);

        $request->validate([
            'cartao_sus' => 'nullable|string|max:30',
            'plano_saude' => 'nullable|string|max:255',
            'numero_plano' => 'nullable|string|max:50',
            'tipo_sanguineo' => 'nullable|string|max:10',
            'alergias' => 'nullable|string|max:2000',
            'doencas_cronicas' => 'nullable|string|max:2000',
            'restricoes' => 'nullable|string|max:2000',
        ]);

        DadosClinico::updateOrCreate(
            ['idoso_id' => $idoso->id],
            $request->only([
                'cartao_sus','plano_saude','numero_plano','tipo_sanguineo',
                'alergias','doencas_cronicas','restricoes'
            ])
        );

        return back()->with('success_step3', 'Dados clínicos atualizados!');
    }

    public function updateStep4(Request $request, Idoso $idoso)
    {
        $this->ensureVinculo($idoso);

        $request->validate([
            'contatos' => 'required|array|min:1',
            'contatos.*.nome' => 'required|string|max:255',
            'contatos.*.telefone' => 'required|string|max:20',
            'contatos.*.parentesco' => 'nullable|string|max:255',
        ], [
            'contatos.required' => 'Adicione pelo menos 1 contato.',
            'contatos.*.nome.required' => 'Nome do contato é obrigatório.',
            'contatos.*.telefone.required' => 'Telefone do contato é obrigatório.',
        ]);

        $idoso->contatosEmergencia()->delete();

        foreach ($request->contatos as $index => $c) {
            ContatoEmergencia::create([
                'idoso_id' => $idoso->id,
                'nome' => $c['nome'],
                'telefone' => $c['telefone'],
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
            'nome' => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'sexo' => 'nullable|string|max:30',
            'cpf' => 'nullable|string|max:14',
            'telefone' => 'nullable|string|max:30',
            'observacoes' => 'nullable|string|max:2000',
        ], [
            'nome.required' => 'Informe o nome.',
            'data_nascimento.required' => 'Informe a data de nascimento.',
            'data_nascimento.date' => 'Informe uma data válida.',
        ]);

        $idoso->update([
            'nome' => $request->nome,
            'data_nascimento' => $request->data_nascimento,
            'sexo' => $request->sexo,
            'cpf' => $request->cpf,
            'telefone' => $request->telefone,
            'observacoes' => $request->observacoes,
        ]);

        return redirect()
            ->route('idosos.show', $idoso->id)
            ->with('success', 'Perfil atualizado com sucesso!');
    }

    public function vincularAdmin(Idoso $idoso)
    {
        $user = auth()->user();

        // evita duplicar vínculo
        if (!$idoso->users()->where('users.id', $user->id)->exists()) {
            $idoso->users()->attach($user->id);
        }

        return back()->with('success', 'Vínculo realizado com sucesso.');
    }

}
