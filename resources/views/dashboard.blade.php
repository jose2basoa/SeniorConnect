@extends('layouts.app')

@section('content')

<div class="container py-5">

    <!-- Cabeçalho -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-0">Painel de Monitoramento</h3>
            <small class="text-muted">
                {{ \Carbon\Carbon::now()->format('d/m/Y') }}
            </small>
        </div>

        <div class="d-flex align-items-center gap-2">

            @if($idoso)

                <span class="badge bg-danger fs-6">
                    {{ $alertas }} Alertas Ativos
                </span>

                <a href="{{ route('idosos.gerenciar') }}" class="btn btn-outline-primary btn-sm">
                    Gerenciar Idoso
                </a>

            @else

                <a href="{{ route('idosos.cadastrar') }}" class="btn btn-primary btn-sm">
                    Cadastrar Idoso
                </a>

            @endif

        </div>
    </div>

    @if(!$idoso)

        <div class="alert alert-warning text-center">
            <h5 class="mb-3">Nenhum idoso cadastrado ainda</h5>
            <p class="text-muted">
                Para começar o monitoramento, cadastre um idoso.
            </p>
        </div>

    @else

    <!-- Cards Resumo -->
    <div class="row mb-4">

        <!-- Status -->
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 rounded-4 text-center p-3">
                <h6 class="text-muted">Status do Idoso</h6>
                <h5 class="{{ $idoso->status_online ? 'text-success' : 'text-danger' }}">
                    {{ $idoso->status_online ? 'Online' : 'Offline' }}
                </h5>
                <small>
                    Última atividade:
                    {{ $idoso->ultima_atividade
                        ? \Carbon\Carbon::parse($idoso->ultima_atividade)->format('H:i')
                        : 'Sem registro' }}
                </small>
            </div>
        </div>

        <!-- Alertas -->
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 rounded-4 text-center p-3">
                <h6 class="text-muted">Alertas Ativos</h6>
                <h5 class="text-danger">{{ $alertas }}</h5>
            </div>
        </div>

        <!-- Localização -->
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 rounded-4 text-center p-3">
                <h6 class="text-muted">Última Localização</h6>
                <h6>
                    {{ $ultimaLocalizacao->endereco ?? 'Sem localização' }}
                </h6>
                <small>
                    {{ $ultimaLocalizacao
                        ? $ultimaLocalizacao->created_at->format('H:i')
                        : '' }}
                </small>
            </div>
        </div>

        <!-- Medicamento -->
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 rounded-4 text-center p-3">
                <h6 class="text-muted">Próximo Medicamento</h6>
                <h6>
                    {{ $proximoMedicamento->nome ?? 'Nenhum' }}
                </h6>
                <small>
                    {{ $proximoMedicamento->horario ?? '' }}
                </small>
            </div>
        </div>

    </div>

    <!-- Botões de Emergência -->
    <div class="card shadow border-0 rounded-4 mb-4">
        <div class="card-header bg-danger text-white rounded-top-4">
            Ações Rápidas de Emergência
        </div>
        <div class="card-body text-center">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <a href="tel:192" class="btn btn-danger w-100">
                        🚑 SAMU (192)
                    </a>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="tel:190" class="btn btn-dark w-100">
                        🚔 Polícia (190)
                    </a>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="tel:193" class="btn btn-warning w-100">
                        🚒 Bombeiros (193)
                    </a>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="#" class="btn btn-primary w-100">
                        📞 Ligar para Idoso
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Últimos Eventos -->
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-primary text-white rounded-top-4">
            Últimos Eventos
        </div>
        <div class="card-body">

            @if($ultimosEventos->isEmpty())
                <p class="text-muted mb-0">Nenhum evento registrado.</p>
            @else
                <ul class="list-group list-group-flush">
                    @foreach($ultimosEventos as $evento)
                        <li class="list-group-item
                            {{ $evento->gravidade == 'alta' ? 'text-danger' : '' }}">

                            {{ ucfirst($evento->tipo) }} -
                            {{ $evento->descricao }}
                            <small class="text-muted">
                                ({{ $evento->created_at->format('H:i') }})
                            </small>

                        </li>
                    @endforeach
                </ul>
            @endif

        </div>
    </div>

    @endif

</div>

@endsection
