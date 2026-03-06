<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Idoso;
use App\Models\Evento;
use App\Models\Medicamento;
use App\Models\Localizacao;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // No dashboard, sempre mostrar apenas idosos vinculados ao usuário,
        // inclusive se ele for admin.
        $idosos = $user->idosos()
            ->orderBy('nome')
            ->get();

        $idoso = null;

        // Se veio um idoso pela URL, valida se ele está entre os vinculados
        if ($request->filled('idoso')) {
            $idoso = $idosos->firstWhere('id', (int) $request->idoso);

            abort_unless($idoso, 403, 'Você não tem permissão para acessar esta pessoa.');
        }

        // Se não veio nenhum idoso na URL, pega o primeiro vinculado
        if (!$idoso) {
            $idoso = $idosos->first();
        }

        // Se não houver nenhum idoso vinculado, exibe dashboard vazio
        if (!$idoso) {
            return view('dashboard', [
                'idoso' => null,
                'idosos' => collect(),
                'idosoSelecionado' => null,
                'alertas' => 0,
                'ultimaLocalizacao' => null,
                'proximoMedicamento' => null,
                'ultimosEventos' => collect(),
            ]);
        }

        $alertas = Evento::where('idoso_id', $idoso->id)
            ->where('resolvido', false)
            ->count();

        $ultimaLocalizacao = Localizacao::where('idoso_id', $idoso->id)
            ->latest()
            ->first();

        $proximoMedicamento = Medicamento::where('idoso_id', $idoso->id)
            ->where('tomado', false)
            ->orderBy('horario')
            ->first();

        if (!$proximoMedicamento) {
            $proximoMedicamento = Medicamento::where('idoso_id', $idoso->id)
                ->orderByDesc('horario')
                ->first();
        }

        $ultimosEventos = Evento::where('idoso_id', $idoso->id)
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard', [
            'idoso' => $idoso,
            'idosos' => $idosos,
            'idosoSelecionado' => $idoso,
            'alertas' => $alertas,
            'ultimaLocalizacao' => $ultimaLocalizacao,
            'proximoMedicamento' => $proximoMedicamento,
            'ultimosEventos' => $ultimosEventos,
        ]);
    }
}