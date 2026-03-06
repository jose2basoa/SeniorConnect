@extends('layouts.app')

@section('content')
@php
    use Carbon\Carbon;
    use Illuminate\Support\Str;

    $eventos = $eventos ?? collect();

    $totalEventos = $eventos->count();
    $totalResolvidos = $eventos->where('resolvido', true)->count();
    $totalPendentes = $eventos->where('resolvido', false)->count();

    $percentualResolvidos = $totalEventos > 0 ? round(($totalResolvidos / $totalEventos) * 100) : 0;

    $tiposMap = [
        'queda' => [
            'label' => 'Queda',
            'icon' => 'bi-person-fill-exclamation',
            'badge' => 'text-danger bg-danger-subtle border-danger-subtle',
            'soft' => 'bg-danger-subtle text-danger-emphasis',
        ],
        'medicacao' => [
            'label' => 'Medicação',
            'icon' => 'bi-capsule-pill',
            'badge' => 'text-primary bg-primary-subtle border-primary-subtle',
            'soft' => 'bg-primary-subtle text-primary-emphasis',
        ],
        'sintoma' => [
            'label' => 'Sintoma',
            'icon' => 'bi-heart-pulse',
            'badge' => 'text-warning bg-warning-subtle border-warning-subtle',
            'soft' => 'bg-warning-subtle text-warning-emphasis',
        ],
        'consulta' => [
            'label' => 'Consulta',
            'icon' => 'bi-hospital',
            'badge' => 'text-info bg-info-subtle border-info-subtle',
            'soft' => 'bg-info-subtle text-info-emphasis',
        ],
        'comportamento' => [
            'label' => 'Comportamento',
            'icon' => 'bi-person-lines-fill',
            'badge' => 'text-secondary bg-secondary-subtle border-secondary-subtle',
            'soft' => 'bg-secondary-subtle text-secondary-emphasis',
        ],
        'rotina' => [
            'label' => 'Rotina',
            'icon' => 'bi-calendar-check',
            'badge' => 'text-success bg-success-subtle border-success-subtle',
            'soft' => 'bg-success-subtle text-success-emphasis',
        ],
        'outro' => [
            'label' => 'Outro',
            'icon' => 'bi-journal-text',
            'badge' => 'text-dark bg-light border',
            'soft' => 'bg-light text-dark',
        ],
    ];

    $tiposResumo = $eventos
        ->groupBy(fn($evento) => strtolower((string) data_get($evento, 'tipo', 'outro')))
        ->sortByDesc(fn($grupo) => $grupo->count());

    $ultimosPendentes = $eventos
        ->where('resolvido', false)
        ->sortByDesc(fn($evento) => data_get($evento, 'data_evento') ?: data_get($evento, 'created_at'))
        ->take(3);
@endphp

<div class="container py-5">

    <div class="mb-4">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-4 p-lg-5">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                    <div>
                        <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill bg-warning-subtle text-warning-emphasis border mb-3">
                            <i class="bi bi-megaphone"></i>
                            <span class="fw-semibold small">Eventos e ocorrências</span>
                        </div>

                        <h2 class="fw-bold mb-2">Registro de eventos</h2>

                        <p class="text-muted mb-0" style="max-width: 760px;">
                            Acompanhe ocorrências, intercorrências e situações importantes relacionadas a
                            <span class="fw-semibold text-dark">{{ $idoso->nome }}</span>,
                            com histórico completo, status de resolução e acesso rápido às principais ações.
                        </p>
                    </div>

                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('dashboard', ['idoso' => $idoso->id]) }}" class="btn btn-outline-secondary rounded-3 px-3">
                            <i class="bi bi-arrow-left me-1"></i> Voltar ao painel
                        </a>

                        <a href="{{ route('eventos.create', ['idoso' => $idoso->id]) }}" class="btn btn-primary rounded-3 px-3">
                            <i class="bi bi-plus-circle me-1"></i> Novo evento
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 rounded-4 shadow-sm d-flex align-items-center gap-2">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 rounded-4 shadow-sm d-flex align-items-center gap-2">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <small class="text-muted d-block">Total de registros</small>
                            <h3 class="fw-bold mb-0">{{ $totalEventos }}</h3>
                        </div>
                        <div class="rounded-3 bg-light d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-journal-text fs-5 text-primary"></i>
                        </div>
                    </div>
                    <div class="text-muted small">
                        Todos os eventos cadastrados para acompanhamento.
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <small class="text-muted d-block">Resolvidos</small>
                            <h3 class="fw-bold mb-0 text-success">{{ $totalResolvidos }}</h3>
                        </div>
                        <div class="rounded-3 bg-success-subtle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-check-circle fs-5 text-success"></i>
                        </div>
                    </div>
                    <div class="text-muted small">
                        Ocorrências concluídas ou tratadas.
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <small class="text-muted d-block">Pendentes</small>
                            <h3 class="fw-bold mb-0 text-warning">{{ $totalPendentes }}</h3>
                        </div>
                        <div class="rounded-3 bg-warning-subtle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-clock-history fs-5 text-warning"></i>
                        </div>
                    </div>
                    <div class="text-muted small">
                        Eventos que ainda exigem atenção.
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <small class="text-muted d-block mb-2">Taxa de resolução</small>
                    <div class="d-flex align-items-end gap-2 mb-3">
                        <h3 class="fw-bold mb-0">{{ $percentualResolvidos }}%</h3>
                        <span class="text-muted small mb-1">dos registros</span>
                    </div>
                    <div class="progress rounded-pill" style="height: 10px;">
                        <div class="progress-bar" role="progressbar" style="width: {{ $percentualResolvidos }}%" aria-valuenow="{{ $percentualResolvidos }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($eventos->isNotEmpty())
        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <h5 class="fw-bold mb-1">Resumo por categoria</h5>
                            <small class="text-muted">Distribuição dos registros por tipo de ocorrência.</small>
                        </div>

                        <div class="row g-3">
                            @foreach($tiposResumo as $tipoKey => $grupo)
                                @php
                                    $config = $tiposMap[$tipoKey] ?? $tiposMap['outro'];
                                @endphp
                                <div class="col-md-6">
                                    <div class="border rounded-4 p-3 h-100">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="rounded-3 d-flex align-items-center justify-content-center {{ $config['soft'] }}"
                                                     style="width: 42px; height: 42px;">
                                                    <i class="bi {{ $config['icon'] }}"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-semibold">{{ $config['label'] }}</div>
                                                    <small class="text-muted">{{ $grupo->count() }} registro(s)</small>
                                                </div>
                                            </div>

                                            <span class="badge rounded-pill {{ $config['badge'] }}">
                                                {{ $grupo->count() }}
                                            </span>
                                        </div>

                                        <div class="progress rounded-pill" style="height: 8px;">
                                            <div class="progress-bar"
                                                 role="progressbar"
                                                 style="width: {{ $totalEventos > 0 ? round(($grupo->count() / $totalEventos) * 100) : 0 }}%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <h5 class="fw-bold mb-1">Pendências recentes</h5>
                            <small class="text-muted">Itens que merecem atenção prioritária.</small>
                        </div>

                        @if($ultimosPendentes->isEmpty())
                            <div class="alert alert-light border rounded-4 mb-0 text-muted">
                                Nenhuma pendência em aberto no momento.
                            </div>
                        @else
                            <div class="d-flex flex-column gap-3">
                                @foreach($ultimosPendentes as $evento)
                                    @php
                                        $tipoKey = strtolower((string) data_get($evento, 'tipo', 'outro'));
                                        $config = $tiposMap[$tipoKey] ?? $tiposMap['outro'];

                                        $dataBruta = data_get($evento, 'data_evento') ?: data_get($evento, 'created_at');
                                        $dataFormatada = $dataBruta ? Carbon::parse($dataBruta)->format('d/m/Y H:i') : '—';
                                    @endphp

                                    <div class="border rounded-4 p-3">
                                        <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                                            <span class="badge rounded-pill {{ $config['badge'] }}">
                                                <i class="bi {{ $config['icon'] }} me-1"></i>{{ $config['label'] }}
                                            </span>
                                            <small class="text-muted">{{ $dataFormatada }}</small>
                                        </div>

                                        <div class="fw-semibold mb-1">{{ Str::limit($evento->descricao, 70) }}</div>
                                        <small class="text-muted">Registro #{{ $evento->id }}</small>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div id="historico-eventos" class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4 p-lg-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <div>
                    <h5 class="fw-bold mb-1">Histórico de eventos</h5>
                    <small class="text-muted">Consulte, edite, resolva ou exclua cada registro individualmente.</small>
                </div>

                @if($eventos->isNotEmpty())
                    <span class="badge bg-light text-dark border rounded-pill px-3 py-2">
                        {{ $totalEventos }} registro(s)
                    </span>
                @endif
            </div>

            @if($eventos->isEmpty())
                <div class="border rounded-4 p-4 p-lg-5 text-center bg-light-subtle">
                    <div class="mb-3">
                        <div class="mx-auto rounded-circle bg-white shadow-sm d-flex align-items-center justify-content-center"
                             style="width: 72px; height: 72px;">
                            <i class="bi bi-journal-text fs-2 text-primary"></i>
                        </div>
                    </div>

                    <h5 class="fw-bold mb-2">Nenhum evento registrado</h5>
                    <p class="text-muted mb-4">
                        Ainda não existem ocorrências cadastradas para <strong>{{ $idoso->nome }}</strong>.
                        Comece registrando o primeiro evento para manter o acompanhamento organizado.
                    </p>

                    <a href="{{ route('eventos.create', ['idoso' => $idoso->id]) }}" class="btn btn-primary rounded-3 px-4">
                        <i class="bi bi-plus-circle me-1"></i> Registrar primeiro evento
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="rounded-start-4 border-0 ps-3">Categoria</th>
                                <th class="border-0">Descrição</th>
                                <th class="border-0">Data</th>
                                <th class="border-0">Status</th>
                                <th class="rounded-end-4 border-0 text-end pe-3">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($eventos as $evento)
                                @php
                                    $tipoKey = strtolower((string) data_get($evento, 'tipo', 'outro'));
                                    $config = $tiposMap[$tipoKey] ?? $tiposMap['outro'];

                                    $descricao = data_get($evento, 'descricao') ?: 'Sem descrição complementar.';
                                    $resolvido = (bool) data_get($evento, 'resolvido', false);

                                    $dataBruta = data_get($evento, 'data_evento') ?: data_get($evento, 'created_at');
                                    $dataFormatada = $dataBruta ? Carbon::parse($dataBruta)->format('d/m/Y H:i') : '—';
                                @endphp

                                <tr>
                                    <td class="ps-3" style="min-width: 180px;">
                                        <span class="badge rounded-pill px-3 py-2 border {{ $config['badge'] }}">
                                            <i class="bi {{ $config['icon'] }} me-1"></i>
                                            {{ $config['label'] }}
                                        </span>
                                    </td>

                                    <td style="min-width: 340px;">
                                        <div class="fw-semibold mb-1">{{ Str::limit($descricao, 95) }}</div>
                                        <div class="text-muted small">Registro #{{ $evento->id }}</div>
                                    </td>

                                    <td class="text-muted small" style="min-width: 140px;">
                                        {{ $dataFormatada }}
                                    </td>

                                    <td style="min-width: 150px;">
                                        @if($resolvido)
                                            <span class="badge text-bg-success rounded-pill px-3 py-2">
                                                <i class="bi bi-check-circle me-1"></i> Resolvido
                                            </span>
                                        @else
                                            <span class="badge text-bg-warning rounded-pill px-3 py-2">
                                                <i class="bi bi-clock-history me-1"></i> Pendente
                                            </span>
                                        @endif
                                    </td>

                                    <td class="text-end pe-3" style="min-width: 270px;">
                                        <div class="d-flex justify-content-end gap-2 flex-wrap">
                                            <a href="{{ route('eventos.edit', ['idoso' => $idoso->id, 'evento' => $evento->id]) }}"
                                               class="btn btn-outline-secondary btn-sm rounded-3">
                                                <i class="bi bi-pencil-square me-1"></i> Editar
                                            </a>

                                            <form action="{{ route('eventos.toggleResolvido', ['idoso' => $idoso->id, 'evento' => $evento->id]) }}"
                                                  method="POST" class="m-0">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="btn btn-outline-{{ $resolvido ? 'warning' : 'success' }} btn-sm rounded-3">
                                                    <i class="bi bi-arrow-repeat me-1"></i>
                                                    {{ $resolvido ? 'Reabrir' : 'Resolver' }}
                                                </button>
                                            </form>

                                            <form action="{{ route('eventos.destroy', ['idoso' => $idoso->id, 'evento' => $evento->id]) }}"
                                                  method="POST"
                                                  class="m-0"
                                                  onsubmit="return confirm('Deseja excluir este evento?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm rounded-3">
                                                    <i class="bi bi-trash me-1"></i> Excluir
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection