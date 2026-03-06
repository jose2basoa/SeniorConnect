@extends('layouts.app')

@section('content')

<div class="container py-5" style="max-width: 1100px;">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="mb-1 fw-bold">Meu perfil</h2>
            <small class="text-muted">Atualize seus dados de acesso e informações pessoais.</small>
        </div>

        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Voltar ao painel
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Ops!</strong> Revise os campos destacados.
        </div>
    @endif

    <div class="row g-4">

        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Dados cadastrais</h5>

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nome *</label>
                                <input type="text"
                                    name="name"
                                    value="{{ old('name', $user->name) }}"
                                    class="form-control @error('name') is-invalid @enderror"
                                    required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Email *</label>
                                <input type="email"
                                    name="email"
                                    value="{{ old('email', $user->email) }}"
                                    class="form-control @error('email') is-invalid @enderror"
                                    required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">CPF *</label>
                                <input type="text"
                                    id="cpf"
                                    name="cpf"
                                    value="{{ old('cpf', preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', preg_replace('/\D/', '', $user->cpf ?? ''))) }}"
                                    class="form-control @error('cpf') is-invalid @enderror"
                                    placeholder="000.000.000-00"
                                    maxlength="14"
                                    inputmode="numeric"
                                    required>
                                @error('cpf') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Telefone *</label>
                                <input type="text"
                                    id="telefone"
                                    name="telefone"
                                    value="{{ old('telefone', preg_replace('/^(\d{2})(\d{4,5})(\d{4})$/', '($1) $2-$3', preg_replace('/\D/', '', $user->telefone ?? ''))) }}"
                                    class="form-control @error('telefone') is-invalid @enderror"
                                    placeholder="(00) 00000-0000"
                                    maxlength="15"
                                    inputmode="numeric"
                                    required>
                                @error('telefone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Data de nascimento</label>
                                <input type="date"
                                    name="data_nascimento"
                                    value="{{ old('data_nascimento', optional($user->data_nascimento)->format('Y-m-d')) }}"
                                    class="form-control @error('data_nascimento') is-invalid @enderror">
                                @error('data_nascimento') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-bold">CEP</label>
                                <input type="text"
                                    id="cep"
                                    name="cep"
                                    value="{{ old('cep', preg_replace('/^(\d{5})(\d{3})$/', '$1-$2', preg_replace('/\D/', '', $user->cep ?? ''))) }}"
                                    class="form-control @error('cep') is-invalid @enderror"
                                    placeholder="00000-000"
                                    maxlength="9"
                                    inputmode="numeric">
                                @error('cep') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-7">
                                <label class="form-label fw-bold">Rua / Logradouro</label>
                                <input type="text"
                                    id="logradouro"
                                    name="logradouro"
                                    value="{{ old('logradouro', $user->logradouro) }}"
                                    class="form-control @error('logradouro') is-invalid @enderror">
                                @error('logradouro') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-2">
                                <label class="form-label fw-bold">Número</label>
                                <input type="text"
                                    id="numero"
                                    name="numero"
                                    value="{{ old('numero', $user->numero) }}"
                                    class="form-control @error('numero') is-invalid @enderror"
                                    inputmode="numeric">
                                @error('numero') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Bairro</label>
                                <input type="text"
                                    id="bairro"
                                    name="bairro"
                                    value="{{ old('bairro', $user->bairro) }}"
                                    class="form-control @error('bairro') is-invalid @enderror">
                                @error('bairro') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-5">
                                <label class="form-label fw-bold">Cidade</label>
                                <input type="text"
                                    id="cidade"
                                    name="cidade"
                                    value="{{ old('cidade', $user->cidade) }}"
                                    class="form-control @error('cidade') is-invalid @enderror">
                                @error('cidade') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-bold">Estado</label>
                                <input type="text"
                                    id="estado"
                                    name="estado"
                                    value="{{ old('estado', $user->estado) }}"
                                    class="form-control @error('estado') is-invalid @enderror"
                                    maxlength="2">
                                @error('estado') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">Complemento</label>
                                <input type="text"
                                    id="complemento"
                                    name="complemento"
                                    value="{{ old('complemento', $user->complemento) }}"
                                    class="form-control @error('complemento') is-invalid @enderror"
                                    placeholder="Apartamento, bloco, referência...">
                                @error('complemento') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                        </div>

                        <div class="mt-4 d-flex justify-content-end">
                            <button class="btn btn-primary">
                                <i class="bi bi-check2-circle me-1"></i> Salvar alterações
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card shadow-sm border-danger rounded-4">
                <div class="card-body p-4">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>

    </div>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const cpf = document.getElementById('cpf');
    const telefone = document.getElementById('telefone');
    const cep = document.getElementById('cep');
    const numero = document.getElementById('numero');
    const estado = document.getElementById('estado');

    const logradouro = document.getElementById('logradouro');
    const bairro = document.getElementById('bairro');
    const cidade = document.getElementById('cidade');
    const complemento = document.getElementById('complemento');

    function apenasNumeros(valor) {
        return valor.replace(/\D/g, '');
    }

    function mascaraCPF(valor) {
        valor = apenasNumeros(valor);
        valor = valor.replace(/^(\d{3})(\d)/, '$1.$2');
        valor = valor.replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3');
        valor = valor.replace(/\.(\d{3})(\d)/, '.$1-$2');
        return valor.slice(0, 14);
    }

    function mascaraTelefone(valor) {
        valor = apenasNumeros(valor);

        if (valor.length <= 10) {
            valor = valor.replace(/^(\d{2})(\d)/, '($1) $2');
            valor = valor.replace(/(\d{4})(\d)/, '$1-$2');
        } else {
            valor = valor.replace(/^(\d{2})(\d)/, '($1) $2');
            valor = valor.replace(/(\d{5})(\d)/, '$1-$2');
        }

        return valor.slice(0, 15);
    }

    function mascaraCEP(valor) {
        valor = apenasNumeros(valor);
        valor = valor.replace(/^(\d{5})(\d)/, '$1-$2');
        return valor.slice(0, 9);
    }

    cpf?.addEventListener('input', (e) => {
        e.target.value = mascaraCPF(e.target.value);
    });

    telefone?.addEventListener('input', (e) => {
        e.target.value = mascaraTelefone(e.target.value);
    });

    cep?.addEventListener('input', (e) => {
        e.target.value = mascaraCEP(e.target.value);
    });

    numero?.addEventListener('input', (e) => {
        e.target.value = apenasNumeros(e.target.value);
    });

    estado?.addEventListener('input', (e) => {
        e.target.value = e.target.value.replace(/[^a-zA-Z]/g, '').toUpperCase().slice(0, 2);
    });

    cep?.addEventListener('blur', async () => {
        const cepLimpo = apenasNumeros(cep.value);

        if (cepLimpo.length !== 8) return;

        try {
            const response = await fetch(`https://viacep.com.br/ws/${cepLimpo}/json/`);
            const data = await response.json();

            if (data.erro) return;

            logradouro.value = data.logradouro || '';
            bairro.value = data.bairro || '';
            cidade.value = data.localidade || '';
            estado.value = data.uf || '';

            if (!complemento.value) {
                complemento.value = data.complemento || '';
            }

            numero?.focus();
        } catch (error) {
            console.error('Erro ao buscar CEP:', error);
        }
    });

    if (cpf?.value) cpf.value = mascaraCPF(cpf.value);
    if (telefone?.value) telefone.value = mascaraTelefone(telefone.value);
    if (cep?.value) cep.value = mascaraCEP(cep.value);
});
</script>
@endpush

@endsection