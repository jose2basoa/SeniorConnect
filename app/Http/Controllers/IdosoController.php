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
        $userId = Auth::id();
        if (!$userId) {
            abort(401);
        }

        // Verifica se o idoso está vinculado ao usuário logado pela pivô
        $vinculado = $idoso->users()
            ->where('users.id', $userId)
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
            'sexo' => 'nullable|string',
            'cpf' => 'nullable|string',
            'telefone' => 'nullable|string',
            'observacoes' => 'nullable|string'
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
            if (!$userId) {
                abort(401);
            }

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

        // OBS: isso exige que no model Idoso exista o relacionamento dadosClinico()
        $dadosClinico = $idoso->dadosClinico;

        return view('idosos.steps.step3', compact('idoso', 'dadosClinico'));
    }

    public function storeStep3(Request $request, Idoso $idoso)
    {
        $this->ensureVinculo($idoso);

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
            'contatos.*.parentesco' => 'nullable|string'
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

        if ($contato->idoso_id != $idoso->id) {
            abort(403);
        }

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
        $user = Auth::user();

        // segurança: se não estiver logado
        if (!$user) {
            abort(401);
        }

        // "ensina" o Intelephense que $user é o seu model de verdade
        /** @var User $user */
        $idosos = $user->idosos()->get();

        return view('idosos.gerenciar', compact('idosos'));
    }

    public function vincularForm()
    {
        return view('idosos.vincular');
    }

    public function vincular(Request $request)
    {
        $request->validate([
            'cpf' => 'required',
            'data_nascimento' => 'required|date'
        ]);

        $idoso = Idoso::where('cpf', $request->cpf)
            ->where('data_nascimento', $request->data_nascimento)
            ->first();

        if (!$idoso) {
            return back()->with('erro', 'Cadastro não encontrado.');
        }

        $userId = Auth::id();
        if (!$userId) {
            abort(401);
        }

        $idoso->users()->syncWithoutDetaching([$userId]);

        return redirect()
            ->route('dashboard')
            ->with('sucesso', 'Vínculo realizado com sucesso!');
    }

    public function desvincular($idosoId)
    {
        $idoso = Idoso::findOrFail($idosoId);

        $this->ensureVinculo($idoso);

        $userId = Auth::id();
        if (!$userId) {
            abort(401);
        }

        $idoso->users()->detach($userId);

        return redirect()
            ->route('idosos.gerenciar')
            ->with('success', 'Vínculo removido com sucesso.');
    }

    public function escolherCadastro()
    {
        return view('idosos.escolher-cadastro');
    }
}
