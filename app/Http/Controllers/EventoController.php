<?php

namespace App\Http\Controllers;

use App\Models\Idoso;

class EventoController extends Controller
{
    public function index(Idoso $idoso)
    {
        abort_unless(auth()->user()->idosos()->where('idosos.id', $idoso->id)->exists(), 403);

        // Se você já tiver Model Evento, pode buscar aqui
        // $eventos = $idoso->eventos()->latest()->paginate(20);

        return view('eventos.index', compact('idoso'));
    }
}
