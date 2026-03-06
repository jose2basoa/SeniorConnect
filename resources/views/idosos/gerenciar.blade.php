@extends('layouts.app')

@section('content')
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Gerenciar pessoas acompanhadas</h3>
            <small class="text-muted">Acesse o perfil, edite dados e gerencie vínculos.</small>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('idosos.cadastrar') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i> Cadastrar
            </a>
            <a href="{{ route('idosos.vincular') }}" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-link-45deg me-1"></i> Vincular existente
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('erro'))
        <div class="alert alert-danger">{{ session('erro') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @php
        $user = auth()->user();
        $isAdmin = $user && !empty($user->is_admin);
    @endphp

    @if($idosos->isEmpty())
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-5 text-center">
                <div class="display-6 mb-2">👤</div>
                <h4 class="fw-bold mb-2">Nenhuma pessoa vinculada</h4>
                <p class="text-muted mb-0">
                    Cadastre uma pessoa acompanhada ou vincule um cadastro já existente.
                </p>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach($idosos as $idoso)

                @php
                    // Se for admin, você já traz with('users') no controller, então isso é "de graça"
                    $temVinculo = $isAdmin
                        ? ($idoso->users?->contains('id', $user->id) ?? false)
                        : true; // usuário comum: só vê vinculados mesmo
                @endphp

                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm border-0 rounded-4 h-100">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h5 class="fw-bold mb-1">{{ $idoso->nome }}</h5>
                                    <div class="text-muted small">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        {{ \Carbon\Carbon::parse($idoso->data_nascimento)->format('d/m/Y') }}
                                    </div>
                                </div>
                                <span class="badge bg-light text-dark border">
                                    <i class="bi bi-person-vcard me-1"></i> Perfil
                                </span>
                            </div>

                            <div class="text-muted small mb-3">
                                <div><i class="bi bi-card-text me-1"></i> CPF: {{ $idoso->cpf ?? '—' }}</div>
                                <div><i class="bi bi-telephone me-1"></i> Telefone: {{ $idoso->telefone ?? '—' }}</div>
                            </div>

                            <div class="d-flex gap-2 flex-wrap">

                                {{-- Sempre aparece --}}
                                <a href="{{ route('idosos.show', $idoso->id) }}" class="btn btn-outline-primary btn-sm">
                                    Ver perfil
                                </a>

                                @if($isAdmin && !$temVinculo)
                                    {{-- Admin sem vínculo: só vê vínculos e pode vincular --}}

                                    <a href="{{ route('admin.idosos') }}" class="btn btn-outline-secondary btn-sm">
                                        <i class="bi bi-people me-1"></i> Vínculos
                                    </a>

                                    <form method="POST" action="{{ route('idosos.vincular.admin', $idoso->id) }}" class="m-0">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="bi bi-link-45deg me-1"></i> Vincular
                                        </button>
                                    </form>

                                @else
                                    {{-- Vinculado (admin ou usuário comum): pode editar e desvincular --}}

                                    <a href="{{ route('idosos.edit', $idoso->id) }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-pencil-square me-1"></i> Editar
                                    </a>

                                    <form method="POST" action="{{ route('idosos.desvincular', $idoso->id) }}" class="m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm"
                                                onclick="return confirm('Deseja remover o vínculo com esta pessoa?');">
                                            <i class="bi bi-x-circle me-1"></i> Desvincular
                                        </button>
                                    </form>
                                @endif

                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
