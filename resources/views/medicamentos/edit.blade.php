@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Editar medicamento</h2>
            <p class="text-muted mb-0">
                Atualize as informações de <span class="fw-semibold">{{ $medicamento->nome }}</span> para
                <span class="fw-semibold">{{ $idoso->nome }}</span>.
            </p>
        </div>

        <a href="{{ route('medicamentos.index', $idoso->id) }}" class="btn btn-outline-secondary rounded-3 px-4">
            <i class="bi bi-arrow-left me-1"></i> Voltar
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-4">
            <div class="fw-bold mb-1">Não foi possível salvar as alterações.</div>
            <div class="small">Revise os campos destacados e tente novamente.</div>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border shadow-sm rounded-4 bg-white">
                <div class="card-body p-4 p-lg-5">
                    <div class="mb-4">
                        <h4 class="fw-bold mb-1">Dados do medicamento</h4>
                        <p class="text-muted mb-0">
                            Mantenha as informações atualizadas para facilitar o acompanhamento.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('medicamentos.update', [$idoso->id, $medicamento->id]) }}">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <div class="col-md-7">
                                <label for="nome" class="form-label fw-bold">Nome do medicamento *</label>
                                <input
                                    type="text"
                                    id="nome"
                                    name="nome"
                                    class="form-control form-control-lg rounded-3 @error('nome') is-invalid @enderror"
                                    value="{{ old('nome', $medicamento->nome) }}"
                                    placeholder="Ex: Losartana"
                                    required
                                >
                                @error('nome')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-5">
                                <label for="dosagem" class="form-label fw-bold">Dosagem</label>
                                <input
                                    type="text"
                                    id="dosagem"
                                    name="dosagem"
                                    class="form-control form-control-lg rounded-3 @error('dosagem') is-invalid @enderror"
                                    value="{{ old('dosagem', $medicamento->dosagem) }}"
                                    placeholder="Ex: 50 mg"
                                >
                                @error('dosagem')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="horario" class="form-label fw-bold">Horário principal *</label>
                                <input
                                    type="time"
                                    id="horario"
                                    name="horario"
                                    class="form-control form-control-lg rounded-3 @error('horario') is-invalid @enderror"
                                    value="{{ old('horario', \Carbon\Carbon::parse($medicamento->horario)->format('H:i')) }}"
                                    required
                                >
                                @error('horario')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-8">
                                <label for="frequencia" class="form-label fw-bold">Frequência</label>
                                <select
                                    id="frequencia"
                                    name="frequencia"
                                    class="form-select form-select-lg rounded-3 @error('frequencia') is-invalid @enderror"
                                >
                                    <option value="">Selecione a frequência</option>
                                    <option value="1x ao dia" {{ old('frequencia', $medicamento->frequencia) == '1x ao dia' ? 'selected' : '' }}>1x ao dia</option>
                                    <option value="2x ao dia" {{ old('frequencia', $medicamento->frequencia) == '2x ao dia' ? 'selected' : '' }}>2x ao dia</option>
                                    <option value="3x ao dia" {{ old('frequencia', $medicamento->frequencia) == '3x ao dia' ? 'selected' : '' }}>3x ao dia</option>
                                    <option value="4x ao dia" {{ old('frequencia', $medicamento->frequencia) == '4x ao dia' ? 'selected' : '' }}>4x ao dia</option>
                                    <option value="A cada 6 horas" {{ old('frequencia', $medicamento->frequencia) == 'A cada 6 horas' ? 'selected' : '' }}>A cada 6 horas</option>
                                    <option value="A cada 8 horas" {{ old('frequencia', $medicamento->frequencia) == 'A cada 8 horas' ? 'selected' : '' }}>A cada 8 horas</option>
                                    <option value="A cada 12 horas" {{ old('frequencia', $medicamento->frequencia) == 'A cada 12 horas' ? 'selected' : '' }}>A cada 12 horas</option>
                                    <option value="Semanal" {{ old('frequencia', $medicamento->frequencia) == 'Semanal' ? 'selected' : '' }}>Semanal</option>
                                    <option value="Sob demanda" {{ old('frequencia', $medicamento->frequencia) == 'Sob demanda' ? 'selected' : '' }}>Sob demanda</option>
                                </select>
                                @error('frequencia')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="data_inicio" class="form-label fw-bold">Data de início</label>
                                <input
                                    type="date"
                                    id="data_inicio"
                                    name="data_inicio"
                                    class="form-control rounded-3 @error('data_inicio') is-invalid @enderror"
                                    value="{{ old('data_inicio', optional($medicamento->data_inicio)->format('Y-m-d')) }}"
                                >
                                @error('data_inicio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="data_fim" class="form-label fw-bold">Data de término</label>
                                <input
                                    type="date"
                                    id="data_fim"
                                    name="data_fim"
                                    class="form-control rounded-3 @error('data_fim') is-invalid @enderror"
                                    value="{{ old('data_fim', optional($medicamento->data_fim)->format('Y-m-d')) }}"
                                >
                                @error('data_fim')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="observacoes" class="form-label fw-bold">Observações</label>
                                <textarea
                                    id="observacoes"
                                    name="observacoes"
                                    rows="5"
                                    class="form-control rounded-3 @error('observacoes') is-invalid @enderror"
                                    placeholder="Ex: tomar após o café da manhã, evitar jejum, uso contínuo..."
                                >{{ old('observacoes', $medicamento->observacoes) }}</textarea>
                                @error('observacoes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <div class="form-check form-switch bg-light-subtle rounded-4 px-4 py-3 border h-100">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        role="switch"
                                        id="ativo"
                                        name="ativo"
                                        value="1"
                                        {{ old('ativo', $medicamento->ativo) ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label ms-2" for="ativo">
                                        <span class="fw-bold">Medicamento ativo</span>
                                        <span class="d-block text-muted small">
                                            Desative caso o medicamento não faça mais parte da rotina.
                                        </span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check form-switch bg-light-subtle rounded-4 px-4 py-3 border h-100">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        role="switch"
                                        id="tomado"
                                        name="tomado"
                                        value="1"
                                        {{ old('tomado', $medicamento->tomado) ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label ms-2" for="tomado">
                                        <span class="fw-bold">Medicamento marcado como tomado</span>
                                        <span class="d-block text-muted small">
                                            Você pode atualizar esse status sempre que necessário.
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-5">
                            <a href="{{ route('medicamentos.index', $idoso->id) }}" class="btn btn-light rounded-3 px-4">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary rounded-3 px-4">
                                <i class="bi bi-check-circle me-1"></i> Salvar alterações
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border shadow-sm rounded-4 mb-4 bg-white">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Resumo atual</h5>

                    <div class="mb-3">
                        <div class="text-muted small">Medicamento</div>
                        <div class="fw-bold">{{ $medicamento->nome }}</div>
                    </div>

                    <div class="mb-3">
                        <div class="text-muted small">Pessoa acompanhada</div>
                        <div class="fw-bold">{{ $idoso->nome }}</div>
                    </div>

                    <div class="mb-3">
                        <div class="text-muted small">Situação</div>

                        @if($medicamento->ativo)
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-3 px-3 py-2 me-1">
                                Ativo
                            </span>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-3 px-3 py-2 me-1">
                                Inativo
                            </span>
                        @endif

                        @if($medicamento->tomado)
                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-3 px-3 py-2">
                                Tomado
                            </span>
                        @else
                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-3 px-3 py-2">
                                Pendente
                            </span>
                        @endif
                    </div>

                    <div class="small text-muted">
                        Cadastro realizado em
                        <span class="fw-semibold">{{ optional($medicamento->created_at)->format('d/m/Y \à\s H:i') ?? '—' }}</span>.
                    </div>
                </div>
            </div>

            <div class="card border shadow-sm rounded-4 bg-white">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-danger mb-3">Zona de ação</h5>
                    <p class="text-muted small mb-3">
                        Exclua este medicamento apenas se ele não for mais necessário no acompanhamento.
                    </p>

                    <form method="POST" action="{{ route('medicamentos.destroy', [$idoso->id, $medicamento->id]) }}" onsubmit="return confirm('Deseja excluir este medicamento? Esta ação não poderá ser desfeita.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100 rounded-3">
                            <i class="bi bi-trash me-1"></i> Excluir medicamento
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection