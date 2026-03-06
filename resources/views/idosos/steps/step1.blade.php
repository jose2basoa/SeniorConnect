@php $step = 1; @endphp
@extends('layouts.wizard')

@section('wizard-content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
        <div>
            <h4 class="fw-bold mb-1">Dados pessoais</h4>
            <div class="text-muted small">
                Todos os campos desta etapa são obrigatórios.
            </div>
        </div>

        <div class="text-end">
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2">
                Etapa 1 de 4
            </span>
        </div>
    </div>

    <div class="progress mb-4" style="height: 10px;">
        <div class="progress-bar" style="width: 25%;" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger d-flex align-items-start gap-2">
            <i class="bi bi-exclamation-triangle mt-1"></i>
            <div>
                <strong>Ops!</strong> Revise os campos destacados e tente novamente.
            </div>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">

            <form method="POST" action="{{ route('idosos.store.step1') }}" novalidate>
                @csrf

                <div class="row g-3">

                    <div class="col-12">
                        <label class="form-label fw-semibold">Nome completo *</label>
                        <input
                            type="text"
                            name="nome"
                            value="{{ old('nome', $idoso->nome ?? '') }}"
                            class="form-control @error('nome') is-invalid @enderror"
                            placeholder="Ex.: Maria Aparecida Silva"
                            required
                            autocomplete="name"
                        >
                        @error('nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-4">
                        <label class="form-label fw-semibold">Data de nascimento *</label>
                        <input
                            type="date"
                            name="data_nascimento"
                            value="{{ old('data_nascimento', $idoso->data_nascimento ?? '') }}"
                            class="form-control @error('data_nascimento') is-invalid @enderror"
                            required
                        >
                        @error('data_nascimento')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-4">
                        <label class="form-label fw-semibold">Gênero / Sexo *</label>
                        @php $sexo = old('sexo', $idoso->sexo ?? ''); @endphp
                        <select
                            name="sexo"
                            class="form-select @error('sexo') is-invalid @enderror"
                            required
                        >
                            <option value="" disabled {{ $sexo==='' ? 'selected' : '' }}>Selecione...</option>
                            <option value="Masculino" {{ $sexo === 'Masculino' ? 'selected' : '' }}>Masculino</option>
                            <option value="Feminino" {{ $sexo === 'Feminino' ? 'selected' : '' }}>Feminino</option>
                            <option value="Outro" {{ $sexo === 'Outro' ? 'selected' : '' }}>Outro</option>
                        </select>
                        @error('sexo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-4">
                        <label class="form-label fw-semibold">CPF *</label>
                        <input
                            type="text"
                            name="cpf"
                            value="{{ old('cpf', $idoso->cpf ?? '') }}"
                            class="form-control @error('cpf') is-invalid @enderror"
                            placeholder="000.000.000-00"
                            inputmode="numeric"
                            id="cpf"
                            required
                            autocomplete="off"
                        >
                        @error('cpf')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Telefone *</label>
                        <input
                            type="text"
                            name="telefone"
                            value="{{ old('telefone', $idoso->telefone ?? '') }}"
                            class="form-control @error('telefone') is-invalid @enderror"
                            placeholder="(00) 00000-0000"
                            inputmode="numeric"
                            id="telefone"
                            required
                            autocomplete="tel"
                        >
                        @error('telefone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Observações</label>
                        <textarea
                            name="observacoes"
                            class="form-control @error('observacoes') is-invalid @enderror"
                            rows="3"
                            placeholder="Ex.: cuidados, rotina, preferências, limitações..."
                        >{{ old('observacoes', $idoso->observacoes ?? '') }}</textarea>
                        @error('observacoes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-between gap-2 flex-wrap">
                    <a href="{{ route('idosos.cadastrar') }}" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-arrow-left me-1"></i> Voltar
                    </a>

                    <button type="submit" class="btn btn-primary px-4">
                        Próximo <i class="bi bi-arrow-right ms-1"></i>
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@push('scripts')
<script>
(function(){
    const onlyDigits = (v) => (v || "").replace(/\D/g,'');
    const cpf = document.getElementById('cpf');
    const tel = document.getElementById('telefone');

    function maskCPF(v){
        v = onlyDigits(v).slice(0,11);
        v = v.replace(/(\d{3})(\d)/, '$1.$2')
             .replace(/(\d{3})(\d)/, '$1.$2')
             .replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        return v;
    }

    function maskPhone(v){
        v = onlyDigits(v).slice(0,11);
        if (v.length <= 10) {
            return v.replace(/(\d{2})(\d)/,'($1) $2')
                    .replace(/(\d{4})(\d)/,'$1-$2');
        }
        return v.replace(/(\d{2})(\d)/,'($1) $2')
                .replace(/(\d{5})(\d)/,'$1-$2');
    }

    if (cpf) {
        cpf.addEventListener('input', () => cpf.value = maskCPF(cpf.value));
        cpf.value = maskCPF(cpf.value);
    }
    if (tel) {
        tel.addEventListener('input', () => tel.value = maskPhone(tel.value));
        tel.value = maskPhone(tel.value);
    }
})();
</script>
@endpush

@endsection
