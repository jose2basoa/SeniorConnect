@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 980px;">

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Criar cadastro</h2>
        <small class="text-muted">Dados pessoais básicos da pessoa acompanhada.</small>
    </div>

    <a href="{{ route('admin.idosos') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>
</div>

@if ($errors->any())
<div class="alert alert-danger">
    <strong>Ops!</strong> Revise os campos destacados.
</div>
@endif

<div class="card shadow-sm border-0 rounded-4">
<div class="card-body p-4">

<form method="POST" action="{{ route('admin.idosos.store') }}">
@csrf

<div class="row g-3">

    <div class="col-md-6">
        <label class="form-label fw-bold">Nome *</label>
        <input type="text" name="nome"
            value="{{ old('nome') }}"
            required
            class="form-control @error('nome') is-invalid @enderror">

        @error('nome')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label fw-bold">Data de nascimento *</label>
        <input type="date"
            name="data_nascimento"
            value="{{ old('data_nascimento') }}"
            required
            class="form-control @error('data_nascimento') is-invalid @enderror">

        @error('data_nascimento')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label fw-bold">Sexo *</label>

        <select name="sexo"
            required
            class="form-select @error('sexo') is-invalid @enderror">

            <option value="">Selecionar</option>

            <option value="Masculino"
                {{ old('sexo') == 'Masculino' ? 'selected' : '' }}>
                Masculino
            </option>

            <option value="Feminino"
                {{ old('sexo') == 'Feminino' ? 'selected' : '' }}>
                Feminino
            </option>

            <option value="Outro"
                {{ old('sexo') == 'Outro' ? 'selected' : '' }}>
                Outro
            </option>

        </select>

        @error('sexo')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label fw-bold">CPF *</label>

        <input type="text"
            name="cpf"
            value="{{ old('cpf') }}"
            required
            maxlength="14"
            inputmode="numeric"
            class="form-control cpf @error('cpf') is-invalid @enderror"
            placeholder="000.000.000-00">

        @error('cpf')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label fw-bold">Telefone *</label>

        <input type="text"
            name="telefone"
            value="{{ old('telefone') }}"
            required
            maxlength="15"
            inputmode="numeric"
            class="form-control telefone @error('telefone') is-invalid @enderror"
            placeholder="(00) 00000-0000">

        @error('telefone')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label class="form-label fw-bold">Observações (opcional)</label>

        <textarea name="observacoes"
            rows="3"
            class="form-control @error('observacoes') is-invalid @enderror"
            placeholder="Informações importantes...">{{ old('observacoes') }}</textarea>

        @error('observacoes')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

</div>

<div class="d-flex justify-content-end mt-4">
    <button class="btn btn-primary">
        <i class="bi bi-check2-circle me-1"></i> Criar cadastro
    </button>
</div>

</form>
</div>
</div>

</div>

@push('scripts')
<script>

function somenteNumeros(valor){
    return valor.replace(/\D/g, '');
}

function mascaraCPF(valor){
    valor = somenteNumeros(valor);

    valor = valor.replace(/(\d{3})(\d)/, "$1.$2");
    valor = valor.replace(/(\d{3})(\d)/, "$1.$2");
    valor = valor.replace(/(\d{3})(\d{1,2})$/, "$1-$2");

    return valor;
}

function mascaraTelefone(valor){
    valor = somenteNumeros(valor);

    if(valor.length <= 10){
        valor = valor.replace(/(\d{2})(\d)/, "($1) $2");
        valor = valor.replace(/(\d{4})(\d)/, "$1-$2");
    }else{
        valor = valor.replace(/(\d{2})(\d)/, "($1) $2");
        valor = valor.replace(/(\d{5})(\d)/, "$1-$2");
    }

    return valor;
}

document.querySelectorAll('.cpf').forEach(input => {
    input.addEventListener('input', e => {
        e.target.value = mascaraCPF(e.target.value);
    });
});

document.querySelectorAll('.telefone').forEach(input => {
    input.addEventListener('input', e => {
        e.target.value = mascaraTelefone(e.target.value);
    });
});

</script>
@endpush

@endsection