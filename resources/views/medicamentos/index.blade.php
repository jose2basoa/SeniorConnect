@extends('layouts.app')

@section('content')
@php
    $medicamentos = $medicamentos ?? collect();

    $busca = request('busca');
    $status = request('status');
    $frequenciaFiltro = request('frequencia');

    $frequenciasDisponiveis = $medicamentos
        ->pluck('frequencia')
        ->filter()
        ->unique()
        ->sort()
        ->values();

    $medicamentosFiltrados = $medicamentos->filter(function ($medicamento) use ($busca, $status, $frequenciaFiltro) {
        $matchBusca = true;
        $matchStatus = true;
        $matchFrequencia = true;

        if ($busca) {
            $texto = mb_strtolower(
                ($medicamento->nome ?? '') . ' ' .
                ($medicamento->dosagem ?? '') . ' ' .
                ($medicamento->observacoes ?? '')
            );

            $matchBusca = str_contains($texto, mb_strtolower($busca));
        }

        if ($status === 'tomado') {
            $matchStatus = (bool) $medicamento->tomado === true;
        } elseif ($status === 'pendente') {
            $matchStatus = (bool) $medicamento->tomado === false;
        }

        if ($frequenciaFiltro) {
            $matchFrequencia = ($medicamento->frequencia ?? null) === $frequenciaFiltro;
        }

        return $matchBusca && $matchStatus && $matchFrequencia;
    })->values();

    $total = $medicamentos->count();
    $tomados = $medicamentos->where('tomado', true)->count();
    $pendentes = $medicamentos->where('tomado', false)->count();
@endphp

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Medicamentos</h2>
            <p class="text-muted mb-0">
                Acompanhamento medicamentoso de <span class="fw-semibold">{{ $idoso->nome }}</span>.
            </p>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('dashboard', ['idoso' => $idoso->id]) }}" class="btn btn-outline-secondary rounded-3 px-4">
                <i class="bi bi-arrow-left me-1"></i> Voltar ao painel
            </a>

            <a href="{{ route('medicamentos.create', $idoso->id) }}" class="btn btn-primary rounded-3 px-4">
                <i class="bi bi-plus-circle me-1"></i> Novo medicamento
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-4">
            <i class="bi bi-exclamation-triangle me-1"></i> {{ session('error') }}
        </div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border shadow-sm rounded-4 h-100 bg-white">
                <div class="card-body p-4">
                    <div class="text-muted small mb-1">Total de medicamentos</div>
                    <div class="fw-bold fs-3">{{ $total }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border shadow-sm rounded-4 h-100 bg-white">
                <div class="card-body p-4">
                    <div class="text-muted small mb-1">Marcados como tomados</div>
                    <div class="fw-bold fs-3 text-success">{{ $tomados }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border shadow-sm rounded-4 h-100 bg-white">
                <div class="card-body p-4">
                    <div class="text-muted small mb-1">Pendentes</div>
                    <div class="fw-bold fs-3 text-warning">{{ $pendentes }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border shadow-sm rounded-4 mb-4 bg-white">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <div>
                    <h5 class="fw-bold mb-1">Filtrar medicamentos</h5>
                    <small class="text-muted">Busque por nome, filtre por status ou frequência.</small>
                </div>
            </div>

            <form method="GET" action="{{ route('medicamentos.index', $idoso->id) }}">
                <div class="row g-3 align-items-end">
                    <div class="col-lg-5">
                        <label for="busca" class="form-label fw-bold">Buscar</label>
                        <input
                            type="text"
                            id="busca"
                            name="busca"
                            class="form-control rounded-3"
                            value="{{ request('busca') }}"
                            placeholder="Ex: Losartana, 50mg..."
                        >
                    </div>

                    <div class="col-md-3 col-lg-2">
                        <label for="status" class="form-label fw-bold">Status</label>
                        <select name="status" id="status" class="form-select rounded-3">
                            <option value="">Todos</option>
                            <option value="tomado" {{ request('status') === 'tomado' ? 'selected' : '' }}>Tomado</option>
                            <option value="pendente" {{ request('status') === 'pendente' ? 'selected' : '' }}>Pendente</option>
                        </select>
                    </div>

                    <div class="col-md-4 col-lg-3">
                        <label for="frequencia" class="form-label fw-bold">Frequência</label>
                        <select name="frequencia" id="frequencia" class="form-select rounded-3">
                            <option value="">Todas</option>
                            @foreach($frequenciasDisponiveis as $frequencia)
                                <option value="{{ $frequencia }}" {{ request('frequencia') === $frequencia ? 'selected' : '' }}>
                                    {{ $frequencia }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary rounded-3 px-4 w-100">
                            <i class="bi bi-funnel me-1"></i> Filtrar
                        </button>
                    </div>
                </div>

                @if(request()->filled('busca') || request()->filled('status') || request()->filled('frequencia'))
                    <div class="mt-3">
                        <a href="{{ route('medicamentos.index', $idoso->id) }}" class="btn btn-light border rounded-3 px-4">
                            <i class="bi bi-x-circle me-1"></i> Limpar filtros
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <div class="card border shadow-sm rounded-4 bg-white">
        <div class="card-body p-4 p-lg-5">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                <div>
                    <h4 class="fw-bold mb-1">Lista de medicamentos</h4>
                    <p class="text-muted mb-0">
                        Visualize horários, frequência, observações e status de uso.
                    </p>
                </div>

                <span class="badge bg-light text-dark border rounded-3 px-3 py-2">
                    {{ $medicamentosFiltrados->count() }} resultado(s)
                </span>
            </div>

            @if($medicamentos->isEmpty())
                <div class="alert alert-light border rounded-4 mb-0">
                    <div class="d-flex align-items-start gap-3">
                        <div class="fs-2 text-primary">
                            <i class="bi bi-capsule-pill"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Nenhum medicamento cadastrado</h5>
                            <p class="text-muted mb-3">
                                Ainda não há medicamentos registrados para <strong>{{ $idoso->nome }}</strong>.
                            </p>

                            <a href="{{ route('medicamentos.create', $idoso->id) }}" class="btn btn-primary rounded-3 px-4">
                                <i class="bi bi-plus-circle me-1"></i> Cadastrar primeiro medicamento
                            </a>
                        </div>
                    </div>
                </div>
            @elseif($medicamentosFiltrados->isEmpty())
                <div class="alert alert-light border rounded-4 mb-0">
                    <div class="d-flex align-items-start gap-3">
                        <div class="fs-2 text-secondary">
                            <i class="bi bi-search"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Nenhum resultado encontrado</h5>
                            <p class="text-muted mb-0">
                                Tente ajustar os filtros para localizar os medicamentos desejados.
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <div class="row g-4">
                    @foreach($medicamentosFiltrados as $medicamento)
                        @php
                            $nome = data_get($medicamento, 'nome', 'Medicamento sem nome');
                            $dosagem = data_get($medicamento, 'dosagem');
                            $horario = data_get($medicamento, 'horario');
                            $frequencia = data_get($medicamento, 'frequencia');
                            $observacoes = data_get($medicamento, 'observacoes');
                            $tomado = (bool) data_get($medicamento, 'tomado', false);
                        @endphp

                        <div class="col-md-6 col-xl-4">
                            <div class="card border shadow rounded-4 h-100 bg-white">
                                <div class="card-body p-4 d-flex flex-column">

                                    <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                                        <div class="me-2">
                                            <h5 class="fw-bold mb-1 d-flex align-items-center gap-2">
                                                <i class="bi bi-capsule-pill text-primary"></i>
                                                <span>{{ $nome }}</span>
                                            </h5>

                                            @if($dosagem)
                                                <div class="text-muted small">
                                                    <span class="fw-bold text-dark">Dosagem:</span> {{ $dosagem }}
                                                </div>
                                            @endif
                                        </div>

                                        @if($tomado)
                                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-3 px-3 py-2">
                                                Tomado
                                            </span>
                                        @else
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-3 px-3 py-2">
                                                Pendente
                                            </span>
                                        @endif
                                    </div>

                                    <div class="bg-light-subtle border rounded-4 p-3 mb-3">
                                        <div class="row g-3 small">
                                            <div class="col-6">
                                                <div class="text-muted mb-1">Horário</div>
                                                <div class="fw-bold">
                                                    {{ $horario ? \Carbon\Carbon::parse($horario)->format('H:i') : '—' }}
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="text-muted mb-1">Frequência</div>
                                                <div class="fw-bold">
                                                    {{ $frequencia ?: 'Não informada' }}
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="text-muted mb-1">Cadastro</div>
                                                <div class="fw-bold">
                                                    {{ optional($medicamento->created_at)->format('d/m/Y \à\s H:i') ?? '—' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4 flex-grow-1">
                                        <div class="fw-bold mb-2">Observações</div>
                                        <div class="text-muted small bg-light-subtle border rounded-4 p-3">
                                            {{ $observacoes ?: 'Nenhuma observação cadastrada.' }}
                                        </div>
                                    </div>

                                    <div class="d-grid gap-2 mt-auto">
                                        <form action="{{ route('medicamentos.toggleTomado', [$idoso->id, $medicamento->id]) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn {{ $tomado ? 'btn-outline-success' : 'btn-success' }} rounded-3">
                                                <i class="bi bi-check2-circle me-1"></i>
                                                {{ $tomado ? 'Desmarcar como tomado' : 'Marcar como tomado' }}
                                            </button>
                                        </form>

                                        <div class="d-flex gap-2">
                                            <a href="{{ route('medicamentos.edit', [$idoso->id, $medicamento->id]) }}" class="btn btn-outline-secondary rounded-3 w-100">
                                                <i class="bi bi-pencil-square me-1"></i> Editar
                                            </a>

                                            <form action="{{ route('medicamentos.destroy', [$idoso->id, $medicamento->id]) }}" method="POST" class="w-100" onsubmit="return confirm('Deseja remover este medicamento?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger rounded-3 w-100">
                                                    <i class="bi bi-trash me-1"></i> Excluir
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection