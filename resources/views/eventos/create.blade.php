@extends('layouts.app')

@section('content')
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Novo evento</h3>
            <small class="text-muted">
                Referente a: <span class="fw-semibold">{{ $idoso->nome }}</span>
            </small>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('eventos.index', $idoso->id) }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Voltar aos eventos
            </a>

            <a href="{{ route('dashboard', ['idoso' => $idoso->id]) }}" class="btn btn-primary">
                <i class="bi bi-speedometer2 me-1"></i> Ir ao painel
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-4">
            <div class="fw-semibold mb-2">
                <i class="bi bi-exclamation-triangle me-1"></i>
                Não foi possível cadastrar o evento
            </div>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-1">
                        <i class="bi bi-journal-medical me-2 text-primary"></i>
                        Cadastro de evento
                    </h5>
                    <small class="text-muted">
                        Registre ocorrências importantes para acompanhamento do idoso.
                    </small>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('eventos.store', $idoso->id) }}" method="POST" class="row g-3">
                        @csrf

                        <div class="col-md-6">
                            <label for="tipo" class="form-label fw-semibold">Tipo do evento</label>
                            <select
                                name="tipo"
                                id="tipo"
                                class="form-select @error('tipo') is-invalid @enderror"
                                required
                            >
                                <option value="">Selecione</option>
                                <option value="queda" {{ old('tipo') === 'queda' ? 'selected' : '' }}>Queda</option>
                                <option value="medicacao" {{ old('tipo') === 'medicacao' ? 'selected' : '' }}>Medicação</option>
                                <option value="sintoma" {{ old('tipo') === 'sintoma' ? 'selected' : '' }}>Sintoma</option>
                                <option value="rotina" {{ old('tipo') === 'rotina' ? 'selected' : '' }}>Rotina</option>
                                <option value="consulta" {{ old('tipo') === 'consulta' ? 'selected' : '' }}>Consulta</option>
                                <option value="comportamento" {{ old('tipo') === 'comportamento' ? 'selected' : '' }}>Comportamento</option>
                                <option value="outro" {{ old('tipo') === 'outro' ? 'selected' : '' }}>Outro</option>
                            </select>
                            @error('tipo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="nivel" class="form-label fw-semibold">Nível de atenção</label>
                            <select
                                name="nivel"
                                id="nivel"
                                class="form-select @error('nivel') is-invalid @enderror"
                                required
                            >
                                <option value="">Selecione</option>
                                <option value="baixo" {{ old('nivel') === 'baixo' ? 'selected' : '' }}>Baixo</option>
                                <option value="medio" {{ old('nivel') === 'medio' ? 'selected' : '' }}>Médio</option>
                                <option value="alto" {{ old('nivel') === 'alto' ? 'selected' : '' }}>Alto</option>
                                <option value="critico" {{ old('nivel') === 'critico' ? 'selected' : '' }}>Crítico</option>
                            </select>
                            @error('nivel')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="origem" class="form-label fw-semibold">Origem</label>
                            <select
                                name="origem"
                                id="origem"
                                class="form-select @error('origem') is-invalid @enderror"
                            >
                                <option value="">Manual (padrão)</option>
                                <option value="manual" {{ old('origem') === 'manual' ? 'selected' : '' }}>Manual</option>
                                <option value="sistema" {{ old('origem') === 'sistema' ? 'selected' : '' }}>Sistema</option>
                                <option value="app" {{ old('origem') === 'app' ? 'selected' : '' }}>Aplicativo</option>
                            </select>
                            @error('origem')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="data_evento" class="form-label fw-semibold">Data e hora do evento</label>
                            <input
                                type="datetime-local"
                                name="data_evento"
                                id="data_evento"
                                class="form-control @error('data_evento') is-invalid @enderror"
                                value="{{ old('data_evento', now()->format('Y-m-d\TH:i')) }}"
                            >
                            @error('data_evento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="descricao" class="form-label fw-semibold">Descrição</label>
                            <textarea
                                name="descricao"
                                id="descricao"
                                rows="5"
                                class="form-control @error('descricao') is-invalid @enderror"
                                placeholder="Descreva o ocorrido com clareza..."
                                required
                            >{{ old('descricao') }}</textarea>
                            @error('descricao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    role="switch"
                                    id="resolvido"
                                    name="resolvido"
                                    value="1"
                                    {{ old('resolvido') ? 'checked' : '' }}
                                >
                                <label class="form-check-label fw-semibold" for="resolvido">
                                    Marcar como resolvido
                                </label>
                            </div>
                            <small class="text-muted d-block mt-1">
                                Ative esta opção caso o evento já tenha sido tratado no momento do cadastro.
                            </small>
                        </div>

                        <div class="col-12 pt-2">
                            <div class="d-flex flex-wrap gap-2">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-check-circle me-1"></i> Salvar evento
                                </button>

                                <a href="{{ route('eventos.index', $idoso->id) }}" class="btn btn-outline-secondary">
                                    Cancelar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-info-circle me-2 text-primary"></i>
                        Resumo do cadastro
                    </h5>

                    <div class="border rounded-4 p-3 mb-3 bg-light-subtle">
                        <div class="small text-muted">Pessoa acompanhada</div>
                        <div class="fw-semibold">{{ $idoso->nome }}</div>
                    </div>

                    <div class="border rounded-4 p-3 mb-3">
                        <div class="small text-muted">Tipos aceitos</div>
                        <div class="mt-2 d-flex flex-wrap gap-2">
                            <span class="badge text-bg-light border">Queda</span>
                            <span class="badge text-bg-light border">Medicação</span>
                            <span class="badge text-bg-light border">Sintoma</span>
                            <span class="badge text-bg-light border">Rotina</span>
                            <span class="badge text-bg-light border">Consulta</span>
                            <span class="badge text-bg-light border">Comportamento</span>
                            <span class="badge text-bg-light border">Outro</span>
                        </div>
                    </div>

                    <div class="border rounded-4 p-3">
                        <div class="small text-muted mb-2">Orientação</div>
                        <small class="text-muted">
                            Registre eventos relevantes com descrição objetiva, pois eles compõem o histórico de acompanhamento do idoso.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
