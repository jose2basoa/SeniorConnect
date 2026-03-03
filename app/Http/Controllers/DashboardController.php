<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Idoso;
use App\Models\Evento;
use App\Models\Medicamento;
use App\Models\Localizacao;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $idoso = $user->idosos()->first();

        if (!$idoso) {
            return view('dashboard', [
                'idoso' => null,
                'alertas' => 0,
                'ultimaLocalizacao' => null,
                'proximoMedicamento' => null,
                'ultimosEventos' => collect()
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
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'idoso',
            'alertas',
            'ultimaLocalizacao',
            'proximoMedicamento',
            'ultimosEventos'
        ));
    }
}