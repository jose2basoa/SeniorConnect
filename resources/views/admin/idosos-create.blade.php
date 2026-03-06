@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 980px;">

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
    <h2 class="fw-bold mb-1">Criar cadastro (Step 1)</h2>
    <small class="text-muted">Dados pessoais básicos do idoso/pessoa acompanhada.</small>
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
                class="form-control @error('nome') is-invalid @enderror">
            @error('nome') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-3">
            <label class="form-label fw-bold">Data de nascimento *</label>
            <input type="date" name="data_nascimento"
                value="{{ old('data_nascimento') }}"
                class="form-control @error('data_nascimento') is-invalid @enderror">
            @error('data_nascimento') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-3">
            <label class="form-label fw-bold">Sexo (opcional)</label>
            <input type="text" name="sexo"
                value="{{ old('sexo') }}"
                class="form-control @error('sexo') is-invalid @enderror"
                placeholder="Ex: Masculino/Feminino">
            @error('sexo') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4">
            <label class="form-label fw-bold">CPF (opcional)</label>
            <input type="text" name="cpf"
                value="{{ old('cpf') }}"
                class="form-control @error('cpf') is-invalid @enderror"
                placeholder="000.000.000-00">
            @error('cpf') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4">
            <label class="form-label fw-bold">Telefone (opcional)</label>
            <input type="text" name="telefone"
                value="{{ old('telefone') }}"
                class="form-control @error('telefone') is-invalid @enderror"
                placeholder="(00) 00000-0000">
            @error('telefone') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="col-12">
            <label class="form-label fw-bold">Observações (opcional)</label>
            <textarea name="observacoes"
                    rows="3"
                    class="form-control @error('observacoes') is-invalid @enderror"
                    placeholder="Informações importantes...">{{ old('observacoes') }}</textarea>
            @error('observacoes') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
@endsection
