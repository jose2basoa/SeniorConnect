<?php

namespace App\Http\Controllers;

use App\Models\Idoso;
use App\Models\Endereco;
use App\Models\DadosClinico;
use App\Models\ContatoEmergencia;
use Illuminate\Http\Request;

class IdosoController extends Controller
{

    /* =========================
        STEP 1 - DADOS PESSOAIS
    ==========================*/

    public function createStep1()
    {
        return view('idosos.steps.step1');
    }

    public function storeStep1(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'sexo' => 'nullable|string',
            'cpf' => 'nullable|string',
            'telefone' => 'nullable|string',
            'observacoes' => 'nullable|string'
        ]);

        $idoso = Idoso::create([
            'user_id' => auth()->id(),
            'nome' => $request->nome,
            'data_nascimento' => $request->data_nascimento,
            'sexo' => $request->sexo,
            'cpf' => $request->cpf,
            'telefone' => $request->telefone,
            'observacoes' => $request->observacoes,
        ]);

        return redirect()->route('idosos.create.step2', $idoso->id);
    }

    /* =========================
        STEP 2 - ENDEREÇO
    ==========================*/

    public function createStep2(Idoso $idoso)
    {
        return view('idosos.steps.step2', compact('idoso'));
    }

    public function storeStep2(Request $request, Idoso $idoso)
    {
        Endereco::create([
            'idoso_id' => $idoso->id,
            'cep' => $request->cep,
            'rua' => $request->rua,
            'numero' => $request->numero,
            'complemento' => $request->complemento,
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
            'estado' => $request->estado,
        ]);

        return redirect()->route('idosos.create.step3', $idoso->id);
    }

    /* =========================
        STEP 3 - DADOS CLÍNICOS
    ==========================*/

    public function createStep3(Idoso $idoso)
    {
        return view('idosos.steps.step3', compact('idoso'));
    }

    public function storeStep3(Request $request, Idoso $idoso)
    {
        DadosClinico::create([
            'idoso_id' => $idoso->id,
            'cartao_sus' => $request->cartao_sus,
            'plano_saude' => $request->plano_saude,
            'numero_plano' => $request->numero_plano,
            'tipo_sanguineo' => $request->tipo_sanguineo,
            'alergias' => $request->alergias,
            'doencas_cronicas' => $request->doencas_cronicas,
            'restricoes' => $request->restricoes,
        ]);

        return redirect()->route('idosos.create.step4', $idoso->id);
    }

    /* =========================
        STEP 4 - CONTATO EMERGÊNCIA
    ==========================*/

    public function createStep4(Idoso $idoso)
    {
        return view('idosos.steps.step4', compact('idoso'));
    }

    public function storeStep4(Request $request, Idoso $idoso)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'telefone' => 'required|string|max:20',
            'parentesco' => 'nullable|string'
        ]);

        ContatoEmergencia::create([
            'idoso_id' => $idoso->id,
            'nome' => $request->nome,
            'telefone' => $request->telefone,
            'parentesco' => $request->parentesco,
            'prioridade' => 1,
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Idoso cadastrado com sucesso!');
    }

}