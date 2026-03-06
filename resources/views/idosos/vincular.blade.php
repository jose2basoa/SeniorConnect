@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-primary text-white rounded-top-4 text-center py-3">
                    <h5 class="mb-0">Vincular cadastro existente</h5>
                </div>

                <div class="card-body p-4 p-md-5">

                    <p class="text-muted text-center mb-4">
                        Informe o CPF e a data de nascimento da pessoa para localizar
                        o cadastro e vinculá-lo à sua conta.
                    </p>

                    @if(session('erro'))
                        <div class="alert alert-danger rounded-3">
                            {{ session('erro') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('idosos.vincular.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="cpf" class="form-label fw-bold">CPF</label>
                            <input
                                type="text"
                                id="cpf"
                                name="cpf"
                                value="{{ old('cpf') }}"
                                class="form-control rounded-3 @error('cpf') is-invalid @enderror"
                                placeholder="000.000.000-00"
                                inputmode="numeric"
                                required
                            >
                            @error('cpf')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="data_nascimento" class="form-label fw-bold">Data de nascimento</label>
                            <input
                                type="date"
                                id="data_nascimento"
                                name="data_nascimento"
                                value="{{ old('data_nascimento') }}"
                                class="form-control rounded-3 @error('data_nascimento') is-invalid @enderror"
                                required
                            >
                            @error('data_nascimento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button class="btn btn-primary btn-lg rounded-3">
                                <i class="bi bi-link-45deg me-1"></i> Buscar e vincular
                            </button>

                            <a href="{{ route('idosos.cadastrar') }}" class="btn btn-outline-secondary rounded-3">
                                Voltar
                            </a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const cpfInput = document.getElementById('cpf');

    function onlyDigits(v) {
        return (v || '').replace(/\D/g, '');
    }

    function formatCPF(v) {
        v = onlyDigits(v).slice(0, 11);
        v = v.replace(/(\d{3})(\d)/, '$1.$2');
        v = v.replace(/(\d{3})(\d)/, '$1.$2');
        v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        return v;
    }

    cpfInput?.addEventListener('input', () => {
        cpfInput.value = formatCPF(cpfInput.value);
    });

    if (cpfInput) {
        cpfInput.value = formatCPF(cpfInput.value);
    }
});
</script>
@endpush
@endsection