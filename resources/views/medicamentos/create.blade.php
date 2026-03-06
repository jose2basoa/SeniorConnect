@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Novo medicamento</h2>
            <p class="text-muted mb-0">
                Cadastre um medicamento para <span class="fw-semibold">{{ $idoso->nome }}</span>.
            </p>
        </div>

        <a href="{{ route('medicamentos.index', $idoso->id) }}" class="btn btn-outline-secondary rounded-3 px-4">
            <i class="bi bi-arrow-left me-1"></i> Voltar
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-4">
            <div class="fw-bold mb-1">Não foi possível salvar o medicamento.</div>
            <div class="small">Revise os campos destacados e tente novamente.</div>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border shadow-sm rounded-4 bg-white">
                <div class="card-body p-4 p-lg-5">
                    <div class="mb-4">
                        <h4 class="fw-bold mb-1">Informações do medicamento</h4>
                        <p class="text-muted mb-0">
                            Preencha os dados principais para facilitar o acompanhamento.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('medicamentos.store', $idoso->id) }}">
                        @csrf

                        <div class="row g-4">
                            <div class="col-md-7">
                                <label for="nome" class="form-label fw-bold">Nome do medicamento *</label>
                                <input
                                    type="text"
                                    id="nome"
                                    name="nome"
                                    class="form-control form-control-lg rounded-3 @error('nome') is-invalid @enderror"
                                    value="{{ old('nome') }}"
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
                                    value="{{ old('dosagem') }}"
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
                                    value="{{ old('horario') }}"
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
                                    <option value="1x ao dia" {{ old('frequencia') == '1x ao dia' ? 'selected' : '' }}>1x ao dia</option>
                                    <option value="2x ao dia" {{ old('frequencia') == '2x ao dia' ? 'selected' : '' }}>2x ao dia</option>
                                    <option value="3x ao dia" {{ old('frequencia') == '3x ao dia' ? 'selected' : '' }}>3x ao dia</option>
                                    <option value="4x ao dia" {{ old('frequencia') == '4x ao dia' ? 'selected' : '' }}>4x ao dia</option>
                                    <option value="A cada 6 horas" {{ old('frequencia') == 'A cada 6 horas' ? 'selected' : '' }}>A cada 6 horas</option>
                                    <option value="A cada 8 horas" {{ old('frequencia') == 'A cada 8 horas' ? 'selected' : '' }}>A cada 8 horas</option>
                                    <option value="A cada 12 horas" {{ old('frequencia') == 'A cada 12 horas' ? 'selected' : '' }}>A cada 12 horas</option>
                                    <option value="Semanal" {{ old('frequencia') == 'Semanal' ? 'selected' : '' }}>Semanal</option>
                                    <option value="Sob demanda" {{ old('frequencia') == 'Sob demanda' ? 'selected' : '' }}>Sob demanda</option>
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
                                    value="{{ old('data_inicio') }}"
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
                                    value="{{ old('data_fim') }}"
                                >
                                @error('data_fim')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Deixe em branco para uso contínuo.</div>
                            </div>

                            <div class="col-12">
                                <label for="observacoes" class="form-label fw-bold">Observações</label>
                                <textarea
                                    id="observacoes"
                                    name="observacoes"
                                    rows="5"
                                    class="form-control rounded-3 @error('observacoes') is-invalid @enderror"
                                    placeholder="Ex: tomar após o café da manhã, evitar jejum, uso contínuo..."
                                >{{ old('observacoes') }}</textarea>
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
                                        {{ old('ativo', '1') ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label ms-2" for="ativo">
                                        <span class="fw-bold">Medicamento ativo</span>
                                        <span class="d-block text-muted small">
                                            Desative apenas se o uso foi interrompido.
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
                                        {{ old('tomado') ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label ms-2" for="tomado">
                                        <span class="fw-bold">Marcar como tomado</span>
                                        <span class="d-block text-muted small">
                                            Ative apenas se esse medicamento já estiver registrado como administrado.
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
                                <i class="bi bi-check-circle me-1"></i> Salvar medicamento
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border shadow-sm rounded-4 h-100 bg-white">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Resumo do cadastro</h5>

                    <div class="border rounded-4 p-3 mb-3 bg-light-subtle">
                        <div class="small text-muted mb-1">Pessoa acompanhada</div>
                        <div class="fw-bold">{{ $idoso->nome }}</div>
                    </div>

                    <div class="mb-3">
                        <div class="fw-bold mb-2">Boas práticas</div>
                        <ul class="text-muted small ps-3 mb-0">
                            <li>Use o nome como aparece na receita ou embalagem.</li>
                            <li>Preencha a dosagem para evitar confusão entre medicamentos parecidos.</li>
                            <li>Defina frequência e período para facilitar consultas futuras.</li>
                            <li>Use observações para orientações relevantes do uso.</li>
                        </ul>
                    </div>

                    <div class="alert alert-light border rounded-4 small mb-0">
                        <div class="fw-bold mb-1">Dica</div>
                        Ao padronizar nome, horário, frequência e período, a rotina medicamentosa fica mais clara.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection