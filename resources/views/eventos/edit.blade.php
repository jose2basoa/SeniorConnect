@extends('layouts.app')

@section('content')
@php
    use Carbon\Carbon;

    $tipos = [
        'queda' => ['label' => 'Queda', 'icon' => 'bi-person-fill-exclamation'],
        'medicacao' => ['label' => 'Medicação', 'icon' => 'bi-capsule-pill'],
        'sintoma' => ['label' => 'Sintoma', 'icon' => 'bi-heart-pulse'],
        'consulta' => ['label' => 'Consulta', 'icon' => 'bi-hospital'],
        'comportamento' => ['label' => 'Comportamento', 'icon' => 'bi-person-lines-fill'],
        'rotina' => ['label' => 'Rotina', 'icon' => 'bi-calendar-check'],
        'outro' => ['label' => 'Outro', 'icon' => 'bi-journal-text'],
    ];

    $dataRegistro = $evento->created_at ? Carbon::parse($evento->created_at)->format('d/m/Y H:i') : '—';
    $dataAtualizacao = $evento->updated_at ? Carbon::parse($evento->updated_at)->format('d/m/Y H:i') : '—';
@endphp

<div class="container py-5">

    <div class="mb-4">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-4 p-lg-5">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                    <div>
                        <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill bg-secondary-subtle text-secondary-emphasis border mb-3">
                            <i class="bi bi-pencil-square"></i>
                            <span class="fw-semibold small">Atualização de registro</span>
                        </div>

                        <h2 class="fw-bold mb-2">Editar evento</h2>
                        <p class="text-muted mb-0" style="max-width: 760px;">
                            Atualize as informações do registro vinculado a
                            <span class="fw-semibold text-dark">{{ $idoso->nome }}</span>,
                            mantendo o histórico sempre correto e fácil de consultar.
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
                        <h5 class="fw-bold mb-1">Editar informações do evento</h5>
                        <small class="text-muted">Faça os ajustes necessários e salve as alterações.</small>
                    </div>

                    <form action="{{ route('eventos.update', ['idoso' => $idoso->id, 'evento' => $evento->id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="tipo" class="form-label fw-semibold">Categoria do evento</label>
                            <select name="tipo" id="tipo" class="form-select form-select-lg rounded-3 @error('tipo') is-invalid @enderror" required>
                                <option value="">Selecione uma categoria</option>
                                @foreach($tipos as $valor => $config)
                                    <option value="{{ $valor }}" {{ old('tipo', $evento->tipo) === $valor ? 'selected' : '' }}>
                                        {{ $config['label'] }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tipo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="descricao" class="form-label fw-semibold">Descrição detalhada</label>
                            <textarea
                                name="descricao"
                                id="descricao"
                                rows="8"
                                class="form-control rounded-3 @error('descricao') is-invalid @enderror"
                                placeholder="Descreva de forma clara o que aconteceu e as providências adotadas."
                                required
                            >{{ old('descricao', $evento->descricao) }}</textarea>
                            @error('descricao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Mantenha o registro objetivo e útil para consultas futuras.
                            </div>
                        </div>

                        <div class="border rounded-4 p-3 p-md-4 bg-light-subtle mb-4">
                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                                <div>
                                    <div class="fw-semibold mb-1">Status do evento</div>
                                    <div class="text-muted small">
                                        Atualize o status para refletir a situação atual do registro.
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
                                        {{ old('resolvido', $evento->resolvido) ? 'checked' : '' }}
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
                                <i class="bi bi-check2-circle me-1"></i> Salvar alterações
                            </button>
                        </div>
                    </form>

                    <div class="border-top mt-4 pt-4">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                            <div>
                                <div class="fw-semibold text-danger mb-1">Zona de exclusão</div>
                                <small class="text-muted">
                                    Exclua este registro apenas se tiver certeza. Esta ação não poderá ser desfeita.
                                </small>
                            </div>

                            <form action="{{ route('eventos.destroy', ['idoso' => $idoso->id, 'evento' => $evento->id]) }}"
                                  method="POST"
                                  class="m-0"
                                  onsubmit="return confirm('Deseja excluir este evento?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger rounded-3">
                                    <i class="bi bi-trash me-1"></i> Excluir evento
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">Detalhes do registro</h6>

                    <div class="d-flex flex-column gap-3 small">
                        <div>
                            <span class="text-muted d-block">Código do evento</span>
                            <span class="fw-semibold">#{{ $evento->id }}</span>
                        </div>

                        <div>
                            <span class="text-muted d-block">Status atual</span>
                            @if($evento->resolvido)
                                <span class="badge text-bg-success rounded-pill px-3 py-2">Resolvido</span>
                            @else
                                <span class="badge text-bg-warning rounded-pill px-3 py-2">Pendente</span>
                            @endif
                        </div>

                        <div>
                            <span class="text-muted d-block">Pessoa acompanhada</span>
                            <span class="fw-semibold">{{ $idoso->nome }}</span>
                        </div>

                        <div>
                            <span class="text-muted d-block">Criado em</span>
                            <span class="fw-semibold">{{ $dataRegistro }}</span>
                        </div>

                        <div>
                            <span class="text-muted d-block">Última atualização</span>
                            <span class="fw-semibold">{{ $dataAtualizacao }}</span>
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
                    <h6 class="fw-bold mb-3">Orientação</h6>
                    <div class="small text-muted">
                        <p class="mb-2">Atualize a descrição sempre que houver nova informação.</p>
                        <p class="mb-2">Use o status resolvido apenas quando o caso estiver concluído.</p>
                        <p class="mb-0">Mantenha o histórico limpo, claro e útil para acompanhamento.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection