<?php

namespace App\Http\Controllers;

use App\Models\Idoso;

class MedicamentoController extends Controller
{
    public function index(Idoso $idoso)
    {
        abort_unless(auth()->user()->idosos()->where('idosos.id', $idoso->id)->exists(), 403);

        // Se você já tiver Model Medicamento, pode buscar aqui
        // $medicamentos = $idoso->medicamentos()->orderBy('horario')->get();

        return view('medicamentos.index', compact('idoso'));
    }
}
