@extends('layouts.app')

@section('content')
@php
    $tipos = [
        'queda' => ['label' => 'Queda', 'icon' => 'bi-person-fill-exclamation'],
        'medicacao' => ['label' => 'Medicação', 'icon' => 'bi-capsule-pill'],
        'sintoma' => ['label' => 'Sintoma', 'icon' => 'bi-heart-pulse'],
        'consulta' => ['label' => 'Consulta', 'icon' => 'bi-hospital'],
        'comportamento' => ['label' => 'Comportamento', 'icon' => 'bi-person-lines-fill'],
        'rotina' => ['label' => 'Rotina', 'icon' => 'bi-calendar-check'],
        'outro' => ['label' => 'Outro', 'icon' => 'bi-journal-text'],
    ];

    $niveis = [
        'baixo' => ['label' => 'Baixo', 'class' => 'success'],
        'medio' => ['label' => 'Médio', 'class' => 'secondary'],
        'alto' => ['label' => 'Alto', 'class' => 'warning'],
        'critico' => ['label' => 'Crítico', 'class' => 'danger'],
    ];

    $origens = [
        'manual' => 'Registro manual',
        'sistema' => 'Sistema',
        'app' => 'Aplicativo',
    ];
@endphp

<div class="container py-5">

    <div class="mb-4">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-4 p-lg-5">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                    <div>
                        <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill bg-primary-subtle text-primary-emphasis border mb-3">
                            <i class="bi bi-plus-circle"></i>
                            <span class="fw-semibold small">Novo registro</span>
                        </div>

                        <h2 class="fw-bold mb-2">Cadastrar evento</h2>
                        <p class="text-muted mb-0" style="max-width: 760px;">
                            Registre uma nova ocorrência relacionada a
                            <span class="fw-semibold text-dark">{{ $idoso->nome }}</span>,
                            mantendo o histórico atualizado e facilitando o acompanhamento.
                        </p>
                    </div>

                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('eventos.index', ['idoso' => $idoso->id]) }}" class="btn btn-outline-secondary rounded-3 px-3">
                            <i class="bi bi-arrow-left me-1"></i> Voltar para eventos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger border-0 rounded-4 shadow-sm">
            <div class="fw-semibold mb-2">
                <i class="bi bi-exclamation-triangle me-1"></i> Revise os dados informados
            </div>
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-lg-4">
                    <div class="mb-4">
                        <h5 class="fw-bold mb-1">Informações do evento</h5>
                        <small class="text-muted">Preencha os dados principais do registro.</small>
                    </div>

                    <form action="{{ route('eventos.store', ['idoso' => $idoso->id]) }}" method="POST">
                        @csrf

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="tipo" class="form-label fw-semibold">Categoria do evento</label>
                                <select name="tipo" id="tipo" class="form-select rounded-3 @error('tipo') is-invalid @enderror" required>
                                    <option value="">Selecione uma categoria</option>
                                    @foreach($tipos as $valor => $config)
                                        <option value="{{ $valor }}" {{ old('tipo') === $valor ? 'selected' : '' }}>
                                            {{ $config['label'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tipo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="nivel" class="form-label fw-semibold">Nível de atenção</label>
                                <select name="nivel" id="nivel" class="form-select rounded-3 @error('nivel') is-invalid @enderror" required>
                                    @foreach($niveis as $valor => $config)
                                        <option value="{{ $valor }}" {{ old('nivel', 'medio') === $valor ? 'selected' : '' }}>
                                            {{ $config['label'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('nivel')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="origem" class="form-label fw-semibold">Origem do registro</label>
                                <select name="origem" id="origem" class="form-select rounded-3 @error('origem') is-invalid @enderror">
                                    @foreach($origens as $valor => $label)
                                        <option value="{{ $valor }}" {{ old('origem', 'manual') === $valor ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('origem')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="data_evento" class="form-label fw-semibold">Data e hora do ocorrido</label>
                                <input
                                    type="datetime-local"
                                    name="data_evento"
                                    id="data_evento"
                                    value="{{ old('data_evento', now()->format('Y-m-d\TH:i')) }}"
                                    class="form-control rounded-3 @error('data_evento') is-invalid @enderror"
                                >
                                @error('data_evento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Use o horário real da ocorrência, quando souber.</div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="descricao" class="form-label fw-semibold">Descrição detalhada</label>
                            <textarea
                                name="descricao"
                                id="descricao"
                                rows="8"
                                class="form-control rounded-3 @error('descricao') is-invalid @enderror"
                                placeholder="Descreva o que aconteceu, quando ocorreu, como a situação foi identificada e quais providências foram tomadas."
                                required
                            >{{ old('descricao') }}</textarea>
                            @error('descricao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Uma boa descrição ajuda no acompanhamento e no entendimento do histórico.
                            </div>
                        </div>

                        <div class="border rounded-4 p-3 p-md-4 bg-light-subtle mb-4">
                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                                <div>
                                    <div class="fw-semibold mb-1">Status inicial do registro</div>
                                    <div class="text-muted small">
                                        Marque como resolvido apenas se a ocorrência já estiver concluída.
                                    </div>
                                </div>

                                <div class="form-check form-switch fs-6">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        role="switch"
                                        id="resolvido"
                                        name="resolvido"
                                        value="1"
                                        {{ old('resolvido') ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label fw-semibold ms-2" for="resolvido">
                                        Evento resolvido
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 flex-wrap pt-2">
                            <a href="{{ route('eventos.index', ['idoso' => $idoso->id]) }}" class="btn btn-outline-secondary rounded-3 px-4">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary rounded-3 px-4">
                                <i class="bi bi-check2-circle me-1"></i> Salvar evento
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">Pessoa acompanhada</h6>

                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-light border d-flex align-items-center justify-content-center shadow-sm"
                             style="width: 60px; height: 60px;">
                            <i class="bi bi-person fs-4 text-secondary"></i>
                        </div>
                        <div>
                            <div class="fw-semibold">{{ $idoso->nome }}</div>
                            <div class="text-muted small">Cadastro #{{ $idoso->id }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">Categorias disponíveis</h6>

                    <div class="d-flex flex-column gap-2">
                        @foreach($tipos as $config)
                            <div class="d-flex align-items-center gap-2 text-muted small">
                                <i class="bi {{ $config['icon'] }}"></i>
                                <span>{{ $config['label'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">Boas práticas de registro</h6>

                    <div class="small text-muted">
                        <p class="mb-2">Descreva a situação com clareza e objetividade.</p>
                        <p class="mb-2">Defina o nível de atenção de forma realista.</p>
                        <p class="mb-2">Informe a data do ocorrido sempre que possível.</p>
                        <p class="mb-0">Registros bem feitos tornam o histórico muito mais útil.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection