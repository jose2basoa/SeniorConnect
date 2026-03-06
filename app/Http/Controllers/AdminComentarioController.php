<?php

namespace App\Http\Controllers;

use App\Models\Comentario;

class AdminComentarioController extends Controller
{
    private function checkAdmin(): void
    {
        abort_unless(auth()->check() && auth()->user()->is_admin, 403, 'Acesso não autorizado.');
    }

    public function index()
    {
        $this->checkAdmin();

        $pendentes = Comentario::with('user')
            ->where('status', 'pendente')
            ->latest()
            ->paginate(10, ['*'], 'pendentes');

        $aprovados = Comentario::with(['user', 'aprovador'])
            ->where('status', 'aprovado')
            ->latest()
            ->paginate(10, ['*'], 'aprovados');

        $rejeitados = Comentario::with('user')
            ->where('status', 'rejeitado')
            ->latest()
            ->paginate(10, ['*'], 'rejeitados');

        return view('admin.comentarios.index', compact('pendentes', 'aprovados', 'rejeitados'));
    }

    public function aprovar(Comentario $comentario)
    {
        $this->checkAdmin();

        $comentario->update([
            'status' => 'aprovado',
            'publicado' => true,
            'aprovado_em' => now(),
            'aprovado_por' => auth()->id(),
        ]);

        return back()->with('success', 'Comentário aprovado com sucesso.');
    }

    public function rejeitar(Comentario $comentario)
    {
        $this->checkAdmin();

        $comentario->update([
            'status' => 'rejeitado',
            'publicado' => false,
            'aprovado_em' => null,
            'aprovado_por' => null,
        ]);

        return back()->with('success', 'Comentário rejeitado com sucesso.');
    }

    public function destroy(Comentario $comentario)
    {
        $this->checkAdmin();

        $comentario->delete();

        return back()->with('success', 'Comentário excluído com sucesso.');
    }
}