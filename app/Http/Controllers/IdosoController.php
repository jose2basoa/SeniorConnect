<?php

namespace App\Http\Controllers;

use App\Models\Idoso;
use App\Models\Endereco;
use App\Models\DadosClinico;
use App\Models\ContatoEmergencia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IdosoController extends Controller
{

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

        $idoso = Idoso::updateOrCreate(
            ['id' => $idoso->id ?? null],
            [
                'user_id' => auth()->id(),
                'nome' => $request->nome,
                'data_nascimento' => $request->data_nascimento,
                'sexo' => $request->sexo,
                'cpf' => $request->cpf,
                'telefone' => $request->telefone,
                'observacoes' => $request->observacoes,
            ]
        );

        return redirect()->route('idosos.create.step2', $idoso->id);
    }

    /* =========================
        STEP 2 - ENDEREÇO
    ==========================*/

    public function createStep2(Idoso $idoso)
    {
        $endereco = $idoso->endereco;
        return view('idosos.steps.step2', compact('idoso', 'endereco'));
    }

    public function storeStep2(Request $request, Idoso $idoso)
    {
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
        $dadosClinico = $idoso->dadosClinico;
        return view('idosos.steps.step3', compact('idoso', 'dadosClinico'));
    }

    public function storeStep3(Request $request, Idoso $idoso)
    {
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
        $contatos = $idoso->contatosEmergencia;

        return view('idosos.steps.step4', compact('idoso', 'contatos'));
    }

    public function storeStep4(Request $request, Idoso $idoso)
    {
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
            ->with('success', 'Idoso cadastrado com sucesso!');
    }

    /* =========================
        REMOVER CONTATO
    ==========================*/

    public function removerContato(Idoso $idoso, ContatoEmergencia $contato)
    {
        // Verifica se o contato pertence ao idoso
        if ($contato->idoso_id != $idoso->id) {
            abort(403);
        }

        // Impede remover se for o único contato
        if ($idoso->contatosEmergencia()->count() <= 1) {
            return back()->with('error', 'É obrigatório manter pelo menos um contato.');
        }

        $contato->delete();

        return back()->with('success', 'Contato removido com sucesso.');
    }
}
