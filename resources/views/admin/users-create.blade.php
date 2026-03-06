@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 980px;">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="fw-bold mb-1">Criar usuário</h2>
            <small class="text-muted">
                Cadastre um novo administrador ou tutor com dados completos.
            </small>
        </div>

        <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Voltar
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger rounded-4">
            <strong>Ops.</strong> Revise os campos destacados.
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">

            <form method="POST" action="{{ route('admin.users.store') }}" novalidate>
                @csrf

                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Nome *</label>
                        <input type="text"
                               name="name"
                               value="{{ old('name') }}"
                               class="form-control @error('name') is-invalid @enderror"
                               required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Sobrenome</label>
                        <input type="text"
                               name="sobrenome"
                               value="{{ old('sobrenome') }}"
                               class="form-control @error('sobrenome') is-invalid @enderror">
                        @error('sobrenome') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Tipo de usuário *</label>
                        <select name="is_admin" class="form-select @error('is_admin') is-invalid @enderror" required>
                            <option value="0" @selected(old('is_admin', '0') === '0')>Tutor</option>
                            <option value="1" @selected(old('is_admin') === '1')>Administrador</option>
                        </select>
                        @error('is_admin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Email *</label>
                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror"
                               required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">CPF *</label>
                        <input type="text"
                               name="cpf"
                               id="cpf"
                               inputmode="numeric"
                               placeholder="000.000.000-00"
                               value="{{ old('cpf') }}"
                               class="form-control @error('cpf') is-invalid @enderror"
                               required>
                        @error('cpf') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Telefone *</label>
                        <input type="text"
                               name="telefone"
                               id="telefone"
                               inputmode="numeric"
                               placeholder="(00) 00000-0000"
                               value="{{ old('telefone') }}"
                               class="form-control @error('telefone') is-invalid @enderror"
                               required>
                        @error('telefone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Data de nascimento</label>
                        <input type="date"
                               name="data_nascimento"
                               value="{{ old('data_nascimento') }}"
                               class="form-control @error('data_nascimento') is-invalid @enderror">
                        @error('data_nascimento') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">CEP</label>
                        <input type="text"
                               name="cep"
                               id="cep"
                               inputmode="numeric"
                               maxlength="9"
                               placeholder="00000-000"
                               value="{{ old('cep') }}"
                               class="form-control @error('cep') is-invalid @enderror">
                        @error('cep') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Logradouro</label>
                        <input type="text"
                               name="logradouro"
                               value="{{ old('logradouro') }}"
                               class="form-control @error('logradouro') is-invalid @enderror">
                        @error('logradouro') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-bold">Número</label>
                        <input type="text"
                               name="numero"
                               value="{{ old('numero') }}"
                               class="form-control @error('numero') is-invalid @enderror">
                        @error('numero') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Bairro</label>
                        <input type="text"
                               name="bairro"
                               value="{{ old('bairro') }}"
                               class="form-control @error('bairro') is-invalid @enderror">
                        @error('bairro') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Cidade</label>
                        <input type="text"
                               name="cidade"
                               value="{{ old('cidade') }}"
                               class="form-control @error('cidade') is-invalid @enderror">
                        @error('cidade') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-bold">Estado</label>
                        <input type="text"
                               name="estado"
                               maxlength="2"
                               value="{{ old('estado') }}"
                               class="form-control @error('estado') is-invalid @enderror">
                        @error('estado') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Complemento</label>
                        <input type="text"
                               name="complemento"
                               value="{{ old('complemento') }}"
                               class="form-control @error('complemento') is-invalid @enderror">
                        @error('complemento') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Senha *</label>
                        <input type="password"
                               name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               required>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Confirmar senha *</label>
                        <input type="password"
                               name="password_confirmation"
                               class="form-control"
                               required>
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
    const telefoneInput = document.getElementById('telefone');
    const cepInput = document.getElementById('cep');

    function onlyDigits(value) {
        return (value || '').replace(/\D/g, '');
    }

    function formatCPF(value) {
        value = onlyDigits(value).slice(0, 11);
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        return value;
    }

    function formatTelefone(value) {
        value = onlyDigits(value).slice(0, 11);

        if (value.length <= 10) {
            value = value.replace(/(\d{2})(\d)/, '($1) $2');
            value = value.replace(/(\d{4})(\d)/, '$1-$2');
        } else {
            value = value.replace(/(\d{2})(\d)/, '($1) $2');
            value = value.replace(/(\d{5})(\d)/, '$1-$2');
        }

        return value;
    }

    function formatCEP(value) {
        value = onlyDigits(value).slice(0, 8);
        value = value.replace(/(\d{5})(\d)/, '$1-$2');
        return value;
    }

    cpfInput?.addEventListener('input', () => cpfInput.value = formatCPF(cpfInput.value));
    telefoneInput?.addEventListener('input', () => telefoneInput.value = formatTelefone(telefoneInput.value));
    cepInput?.addEventListener('input', () => cepInput.value = formatCEP(cepInput.value));

    if (cpfInput) cpfInput.value = formatCPF(cpfInput.value);
    if (telefoneInput) telefoneInput.value = formatTelefone(telefoneInput.value);
    if (cepInput) cepInput.value = formatCEP(cepInput.value);
});
</script>
@endpush
@endsection