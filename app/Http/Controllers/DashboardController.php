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

        $idosos = $user->idosos;

        $idoso = $idosos
            ->where('id', $request->idoso)
            ->first() ?? $idosos->first();

        if (!$idoso) {
            return view('dashboard', [
                'idosos' => collect(),
                'idoso' => null
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

        $ultimosEventos = Evento::where('idoso_id', $idoso->id)
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'idosos',
            'idoso',
            'alertas',
            'ultimaLocalizacao',
            'proximoMedicamento',
            'ultimosEventos'
        ));
    }
}
