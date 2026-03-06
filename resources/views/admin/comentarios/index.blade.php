@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Moderação de comentários</h3>
            <small class="text-muted">
                Aprove, rejeite ou exclua comentários enviados pelos usuários da plataforma.
            </small>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <span class="badge bg-warning-subtle text-warning-emphasis border px-3 py-2 rounded-pill">
                Pendentes: {{ $pendentes->total() }}
            </span>
            <span class="badge bg-success-subtle text-success-emphasis border px-3 py-2 rounded-pill">
                Aprovados: {{ $aprovados->total() }}
            </span>
            <span class="badge bg-danger-subtle text-danger-emphasis border px-3 py-2 rounded-pill">
                Rejeitados: {{ $rejeitados->total() }}
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-4 shadow-sm border-0">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Comentários pendentes</h5>
                <small class="text-muted">Aguardando validação</small>
            </div>

            @forelse($pendentes as $comentario)
                <div class="border rounded-4 p-3 p-lg-4 mb-3">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2 flex-wrap mb-2">
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

                            <p class="mb-3 text-dark">
                                {{ $comentario->comentario }}
                            </p>

                            <small class="text-muted">
                                Enviado em {{ $comentario->created_at->format('d/m/Y \à\s H:i') }}
                            </small>
                        </div>

                        <div class="d-flex flex-column gap-2">
                            <form action="{{ route('admin.comentarios.aprovar', $comentario) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success btn-sm w-100">
                                    <i class="bi bi-check-circle me-1"></i> Aprovar
                                </button>
                            </form>

                            <form action="{{ route('admin.comentarios.rejeitar', $comentario) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-warning btn-sm w-100">
                                    <i class="bi bi-x-circle me-1"></i> Rejeitar
                                </button>
                            </form>

                            <form action="{{ route('admin.comentarios.destroy', $comentario) }}" method="POST"
                                  onsubmit="return confirm('Deseja realmente excluir este comentário?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm w-100">
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
                        Quando novos comentários forem enviados, eles aparecerão aqui para validação.
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

    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Comentários aprovados</h5>
                <small class="text-muted">Visíveis ao público</small>
            </div>

            @forelse($aprovados as $comentario)
                <div class="border rounded-4 p-3 p-lg-4 mb-3 bg-light">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2 flex-wrap mb-2">
                                <span class="fw-bold">{{ $comentario->nome_publico }}</span>

                                @if($comentario->cargo)
                                    <span class="badge text-bg-light border">{{ $comentario->cargo }}</span>
                                @endif

                                <span class="badge bg-success-subtle text-success-emphasis border">
                                    Aprovado
                                </span>
                            </div>

                            <div class="text-muted small mb-2">
                                <strong>Usuário:</strong> {{ $comentario->user->name ?? 'Não identificado' }}
                            </div>

                            <p class="mb-3">{{ $comentario->comentario }}</p>

                            <small class="text-muted">
                                Aprovado em
                                {{ optional($comentario->aprovado_em)->format('d/m/Y \à\s H:i') ?? '—' }}
                                @if($comentario->aprovador)
                                    por {{ $comentario->aprovador->name }}
                                @endif
                            </small>
                        </div>

                        <div class="d-flex flex-column gap-2">
                            <form action="{{ route('admin.comentarios.rejeitar', $comentario) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-warning btn-sm w-100">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i> Rejeitar
                                </button>
                            </form>

                            <form action="{{ route('admin.comentarios.destroy', $comentario) }}" method="POST"
                                  onsubmit="return confirm('Deseja realmente excluir este comentário?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                    <i class="bi bi-trash me-1"></i> Excluir
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-muted">Nenhum comentário aprovado até o momento.</div>
            @endforelse

            @if($aprovados->hasPages())
                <div class="mt-3">
                    {{ $aprovados->links() }}
                </div>
            @endif
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Comentários rejeitados</h5>
                <small class="text-muted">Não publicados</small>
            </div>

            @forelse($rejeitados as $comentario)
                <div class="border rounded-4 p-3 p-lg-4 mb-3">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2 flex-wrap mb-2">
                                <span class="fw-bold">{{ $comentario->nome_publico }}</span>

                                @if($comentario->cargo)
                                    <span class="badge text-bg-light border">{{ $comentario->cargo }}</span>
                                @endif

                                <span class="badge bg-danger-subtle text-danger-emphasis border">
                                    Rejeitado
                                </span>
                            </div>

                            <div class="text-muted small mb-2">
                                <strong>Usuário:</strong> {{ $comentario->user->name ?? 'Não identificado' }}
                            </div>

                            <p class="mb-3">{{ $comentario->comentario }}</p>

                            <small class="text-muted">
                                Criado em {{ $comentario->created_at->format('d/m/Y \à\s H:i') }}
                            </small>
                        </div>

                        <div class="d-flex flex-column gap-2">
                            <form action="{{ route('admin.comentarios.aprovar', $comentario) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success btn-sm w-100">
                                    <i class="bi bi-check-circle me-1"></i> Aprovar
                                </button>
                            </form>

                            <form action="{{ route('admin.comentarios.destroy', $comentario) }}" method="POST"
                                  onsubmit="return confirm('Deseja realmente excluir este comentário?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                    <i class="bi bi-trash me-1"></i> Excluir
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-muted">Nenhum comentário rejeitado.</div>
            @endforelse

            @if($rejeitados->hasPages())
                <div class="mt-3">
                    {{ $rejeitados->links() }}
                </div>
            @endif
        </div>
    </div>

</div>
@endsection