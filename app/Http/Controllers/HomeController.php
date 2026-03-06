<?php

namespace App\Http\Controllers;

use App\Models\Comentario;

class HomeController extends Controller
{
    public function index()
    {
        $comentarios = Comentario::aprovados()
            ->latest()
            ->take(6)
            ->get();

        return view('public.index', compact('comentarios'));
    }
}