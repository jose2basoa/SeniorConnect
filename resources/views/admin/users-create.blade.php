@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 820px;">

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
    <h2 class="fw-bold mb-1">Criar usuário</h2>
    <small class="text-muted">
        Defina os dados do usuário. O tipo (Admin/Tutor) é opcional e, se não informado, o padrão é Tutor.
    </small>
    </div>

    <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary btn-sm">
    <i class="bi bi-arrow-left"></i> Voltar
    </a>
</div>

@if ($errors->any())
    <div class="alert alert-danger d-flex align-items-start gap-2">
    <i class="bi bi-exclamation-triangle mt-1"></i>
    <div>
        <strong>Ops!</strong> Revise os campos destacados.
    </div>
    </div>
@endif

<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-4">

    <form method="POST" action="{{ route('admin.users.store') }}" novalidate>
        @csrf

        <div class="row g-3">

        {{-- Nome --}}
        <div class="col-md-6">
            <label class="form-label fw-bold">Nome *</label>
            <input type="text"
                name="name"
                value="{{ old('name') }}"
                class="form-control @error('name') is-invalid @enderror"
                required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            <div class="form-text">Nome completo do usuário.</div>
        </div>

        {{-- Email --}}
        <div class="col-md-6">
            <label class="form-label fw-bold">Email *</label>
            <input type="email"
                name="email"
                value="{{ old('email') }}"
                class="form-control @error('email') is-invalid @enderror"
                required>
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            <div class="form-text">Será usado para login no sistema.</div>
        </div>

        {{-- CPF --}}
        <div class="col-md-6">
            <label class="form-label fw-bold">CPF *</label>
            <input type="text"
                name="cpf"
                id="cpf"
                inputmode="numeric"
                autocomplete="off"
                placeholder="000.000.000-00"
                value="{{ old('cpf') }}"
                class="form-control @error('cpf') is-invalid @enderror"
                required>
            @error('cpf') <div class="invalid-feedback">{{ $message }}</div> @enderror
            <div class="form-text">CPF com 11 dígitos.</div>
        </div>

        {{-- Tipo de usuário (OPCIONAL) --}}
        <div class="col-md-6">
            <label class="form-label fw-bold">Tipo de usuário</label>

            <select name="is_admin" class="form-select @error('is_admin') is-invalid @enderror">

                <option value="0" @selected(old('is_admin') === '0')>
                    Tutor (usuário comum)
                </option>

                <option value="1" @selected(old('is_admin') === '1')>
                    Administrador
                </option>

            </select>

            @error('is_admin') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Senha --}}
        <div class="col-md-6">
            <label class="form-label fw-bold">Senha *</label>
            <input type="password"
                name="password"
                class="form-control @error('password') is-invalid @enderror"
                required>
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            <div class="form-text">Mínimo 8 caracteres.</div>
        </div>

        {{-- Confirmar senha --}}
        <div class="col-md-6">
            <label class="form-label fw-bold">Confirmar senha *</label>
            <input type="password"
                name="password_confirmation"
                class="form-control"
                required>
            <div class="form-text">Digite novamente a senha.</div>
        </div>

        </div>

        <hr class="my-4">

        <div class="d-flex justify-content-end">
        <button class="btn btn-primary px-4">
            <i class="bi bi-check2-circle me-1"></i> Criar usuário
        </button>
        </div>

    </form>

    </div>
</div>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
const cpfInput = document.getElementById('cpf');
if (!cpfInput) return;

function formatCPF(value) {
    value = (value || '').replace(/\D/g,'').slice(0, 11);
    value = value.replace(/(\d{3})(\d)/,'$1.$2');
    value = value.replace(/(\d{3})(\d)/,'$1.$2');
    value = value.replace(/(\d{3})(\d{1,2})$/,'$1-$2');
    return value;
}

cpfInput.addEventListener('input', () => {
    cpfInput.value = formatCPF(cpfInput.value);
});

cpfInput.value = formatCPF(cpfInput.value);
});
</script>
@endpush

@endsection
