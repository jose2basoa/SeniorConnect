@extends('layouts.app')

@section('content')

<div class="container py-4 py-md-5">

    <!-- HEADER -->
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Moderação de comentários</h3>
            <small class="text-muted">
                Aprove, rejeite ou exclua comentários enviados pelos usuários da plataforma.
            </small>
        </div>

        <div class="d-grid d-sm-flex gap-2 w-100 w-lg-auto">
            <span class="badge bg-warning-subtle text-warning-emphasis border px-3 py-2 text-center">
                Pendentes: {{ $pendentes->total() }}
            </span>
            <span class="badge bg-success-subtle text-success-emphasis border px-3 py-2 text-center">
                Aprovados: {{ $aprovados->total() }}
            </span>
            <span class="badge bg-danger-subtle text-danger-emphasis border px-3 py-2 text-center">
                Rejeitados: {{ $rejeitados->total() }}
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-4 shadow-sm border-0">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
        </div>
    @endif

    <!-- PENDENTES -->
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body p-3 p-md-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2 mb-3">
                <h5 class="fw-bold mb-0">Comentários pendentes</h5>
                <small class="text-muted">Aguardando validação</small>
            </div>

            @forelse($pendentes as $comentario)
                <div class="border rounded-4 p-3 mb-3">
                    <div class="d-flex flex-column flex-lg-row justify-content-between gap-3">

                        <!-- CONTEÚDO -->
                        <div class="flex-grow-1">
                            <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                <span class="fw-bold">{{ $comentario->nome_publico }}</span>

                                @if($comentario->cargo)
                                    <span class="badge text-bg-light border">{{ $comentario->cargo }}</span>
                                @endif

                                <span class="badge bg-warning-subtle text-warning-emphasis border">
                                    Pendente
                                </span>
                            </div>

                            <div class="text-muted small mb-2">
                                <strong>Usuário:</strong> {{ $comentario->user->name ?? 'Não identificado' }}
                                @if(!empty($comentario->user?->email))
                                    • {{ $comentario->user->email }}
                                @endif
                            </div>

                            <p class="mb-3">{{ $comentario->comentario }}</p>

                            <small class="text-muted">
                                {{ $comentario->created_at->format('d/m/Y H:i') }}
                            </small>
                        </div>

                        <!-- AÇÕES -->
                        <div class="d-grid gap-2 w-100 w-lg-auto" style="min-width: 200px;">
                            <form method="POST" action="{{ route('admin.comentarios.aprovar', $comentario) }}">
                                @csrf @method('PATCH')
                                <button class="btn btn-success btn-sm w-100">
                                    <i class="bi bi-check-circle me-1"></i> Aprovar
                                </button>
                            </form>

                            <form method="POST" action="{{ route('admin.comentarios.rejeitar', $comentario) }}">
                                @csrf @method('PATCH')
                                <button class="btn btn-warning btn-sm w-100">
                                    <i class="bi bi-x-circle me-1"></i> Rejeitar
                                </button>
                            </form>

                            <form method="POST" action="{{ route('admin.comentarios.destroy', $comentario) }}"
                                  onsubmit="return confirm('Excluir comentário?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm w-100">
                                    <i class="bi bi-trash me-1"></i> Excluir
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <div class="fs-1 text-muted mb-3">
                        <i class="bi bi-chat-square-text"></i>
                    </div>
                    <h6 class="fw-bold">Nenhum comentário pendente</h6>
                    <p class="text-muted mb-0">
                        Novos comentários aparecerão aqui.
                    </p>
                </div>
            @endforelse

            @if($pendentes->hasPages())
                <div class="mt-3">
                    {{ $pendentes->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- APROVADOS -->
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body p-3 p-md-4">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <h5 class="fw-bold mb-0">Comentários aprovados</h5>
                <small class="text-muted">Visíveis ao público</small>
            </div>

            @forelse($aprovados as $comentario)
                <div class="border rounded-4 p-3 mb-3 bg-light">
                    <div class="d-flex flex-column flex-lg-row justify-content-between gap-3">

                        <div class="flex-grow-1">
                            <div class="d-flex flex-wrap gap-2 mb-2">
                                <span class="fw-bold">{{ $comentario->nome_publico }}</span>

                                @if($comentario->cargo)
                                    <span class="badge text-bg-light border">{{ $comentario->cargo }}</span>
                                @endif

                                <span class="badge bg-success-subtle text-success-emphasis border">
                                    Aprovado
                                </span>
                            </div>

                            <p class="mb-2">{{ $comentario->comentario }}</p>

                            <small class="text-muted">
                                {{ optional($comentario->aprovado_em)->format('d/m/Y H:i') }}
                            </small>
                        </div>

                        <div class="d-grid gap-2 w-100 w-lg-auto" style="min-width: 200px;">
                            <form method="POST" action="{{ route('admin.comentarios.rejeitar', $comentario) }}">
                                @csrf @method('PATCH')
                                <button class="btn btn-warning btn-sm w-100">
                                    Rejeitar
                                </button>
                            </form>

                            <form method="POST" action="{{ route('admin.comentarios.destroy', $comentario) }}">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm w-100">
                                    Excluir
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            @empty
                <div class="text-muted">Nenhum aprovado.</div>
            @endforelse

            {{ $aprovados->links() }}
        </div>
    </div>

    <!-- REJEITADOS -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-3 p-md-4">

            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <h5 class="fw-bold mb-0">Comentários rejeitados</h5>
                <small class="text-muted">Não publicados</small>
            </div>

            @forelse($rejeitados as $comentario)
                <div class="border rounded-4 p-3 mb-3">
                    <div class="d-flex flex-column flex-lg-row justify-content-between gap-3">

                        <div class="flex-grow-1">
                            <div class="d-flex flex-wrap gap-2 mb-2">
                                <span class="fw-bold">{{ $comentario->nome_publico }}</span>

                                <span class="badge bg-danger-subtle text-danger-emphasis border">
                                    Rejeitado
                                </span>
                            </div>

                            <p class="mb-2">{{ $comentario->comentario }}</p>

                            <small class="text-muted">
                                {{ $comentario->created_at->format('d/m/Y H:i') }}
                            </small>
                        </div>

                        <div class="d-grid gap-2 w-100 w-lg-auto" style="min-width: 200px;">
                            <form method="POST" action="{{ route('admin.comentarios.aprovar', $comentario) }}">
                                @csrf @method('PATCH')
                                <button class="btn btn-success btn-sm w-100">
                                    Aprovar
                                </button>
                            </form>

                            <form method="POST" action="{{ route('admin.comentarios.destroy', $comentario) }}">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm w-100">
                                    Excluir
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            @empty
                <div class="text-muted">Nenhum rejeitado.</div>
            @endforelse

            {{ $rejeitados->links() }}
        </div>
    </div>

</div>
@endsection