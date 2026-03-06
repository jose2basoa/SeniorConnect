@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-9">

            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-4 p-md-5">

                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-primary mb-2">Criar conta</h3>
                        <p class="text-muted mb-0">
                            Preencha seus dados para começar a usar o sistema como tutor.
                        </p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger rounded-3">
                            Revise os campos destacados antes de continuar.
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}" id="form-register" novalidate>
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nome *</label>
                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    value="{{ old('name') }}"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Ex: João"
                                    required
                                >
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <div class="invalid-feedback js-feedback" style="display:none;"></div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Sobrenome</label>
                                <input
                                    type="text"
                                    name="sobrenome"
                                    id="sobrenome"
                                    value="{{ old('sobrenome') }}"
                                    class="form-control @error('sobrenome') is-invalid @enderror"
                                    placeholder="Ex: Silva"
                                >
                                @error('sobrenome') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <div class="invalid-feedback js-feedback" style="display:none;"></div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">CPF *</label>
                                <input
                                    type="text"
                                    name="cpf"
                                    id="cpf"
                                    value="{{ old('cpf') }}"
                                    class="form-control @error('cpf') is-invalid @enderror"
                                    placeholder="000.000.000-00"
                                    inputmode="numeric"
                                    required
                                >
                                @error('cpf') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <div class="invalid-feedback js-feedback" style="display:none;"></div>
                                <div class="form-text">Usado para identificação e segurança do cadastro.</div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Telefone *</label>
                                <input
                                    type="text"
                                    name="telefone"
                                    id="telefone"
                                    value="{{ old('telefone') }}"
                                    class="form-control @error('telefone') is-invalid @enderror"
                                    placeholder="(00) 00000-0000"
                                    inputmode="numeric"
                                    required
                                >
                                @error('telefone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <div class="invalid-feedback js-feedback" style="display:none;"></div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Data de nascimento</label>
                                <input
                                    type="date"
                                    name="data_nascimento"
                                    id="data_nascimento"
                                    value="{{ old('data_nascimento') }}"
                                    class="form-control @error('data_nascimento') is-invalid @enderror"
                                >
                                @error('data_nascimento') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <div class="invalid-feedback js-feedback" style="display:none;"></div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-bold">CEP</label>
                                <input
                                    type="text"
                                    name="cep"
                                    id="cep"
                                    value="{{ old('cep') }}"
                                    class="form-control @error('cep') is-invalid @enderror"
                                    placeholder="00000-000"
                                    inputmode="numeric"
                                >
                                @error('cep') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <div class="invalid-feedback js-feedback" style="display:none;"></div>
                                <div class="form-text" id="cep-status"></div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Logradouro</label>
                                <input
                                    type="text"
                                    name="logradouro"
                                    id="logradouro"
                                    value="{{ old('logradouro') }}"
                                    class="form-control @error('logradouro') is-invalid @enderror"
                                    placeholder="Rua, avenida..."
                                >
                                @error('logradouro') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-bold">Número</label>
                                <input
                                    type="text"
                                    name="numero"
                                    id="numero"
                                    value="{{ old('numero') }}"
                                    class="form-control @error('numero') is-invalid @enderror"
                                    placeholder="123"
                                >
                                @error('numero') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Bairro</label>
                                <input
                                    type="text"
                                    name="bairro"
                                    id="bairro"
                                    value="{{ old('bairro') }}"
                                    class="form-control @error('bairro') is-invalid @enderror"
                                >
                                @error('bairro') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Cidade</label>
                                <input
                                    type="text"
                                    name="cidade"
                                    id="cidade"
                                    value="{{ old('cidade') }}"
                                    class="form-control @error('cidade') is-invalid @enderror"
                                >
                                @error('cidade') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-2">
                                <label class="form-label fw-bold">Estado</label>
                                <input
                                    type="text"
                                    name="estado"
                                    id="estado"
                                    value="{{ old('estado') }}"
                                    maxlength="2"
                                    class="form-control @error('estado') is-invalid @enderror"
                                    placeholder="SP"
                                >
                                @error('estado') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-2">
                                <label class="form-label fw-bold">Complemento</label>
                                <input
                                    type="text"
                                    name="complemento"
                                    id="complemento"
                                    value="{{ old('complemento') }}"
                                    class="form-control @error('complemento') is-invalid @enderror"
                                    placeholder="Apto, bloco..."
                                >
                                @error('complemento') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">E-mail *</label>
                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    value="{{ old('email') }}"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="nome@dominio.com"
                                    autocomplete="email"
                                    required
                                >
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <div class="invalid-feedback js-feedback" style="display:none;"></div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Senha *</label>
                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    autocomplete="new-password"
                                    required
                                >
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <div class="form-text">Use pelo menos 8 caracteres.</div>
                                <div class="invalid-feedback js-feedback" style="display:none;"></div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Confirmar senha *</label>
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    id="password_confirmation"
                                    class="form-control"
                                    autocomplete="new-password"
                                    required
                                >
                                <div class="invalid-feedback js-feedback" style="display:none;"></div>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Criar conta
                            </button>
                        </div>

                        <div class="text-center mt-3">
                            <a href="{{ route('login') }}" class="text-decoration-none">
                                Já possui conta? Entrar
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
    const form = document.getElementById('form-register');

    const cpfInput = document.getElementById('cpf');
    const telefoneInput = document.getElementById('telefone');
    const cepInput = document.getElementById('cep');

    const logradouroInput = document.getElementById('logradouro');
    const bairroInput = document.getElementById('bairro');
    const cidadeInput = document.getElementById('cidade');
    const estadoInput = document.getElementById('estado');
    const cepStatus = document.getElementById('cep-status');

    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const passwordConfirmInput = document.getElementById('password_confirmation');

    function onlyDigits(v){ return (v || '').replace(/\D/g,''); }

    function setFeedback(input, ok, msg = ''){
        input.classList.remove('is-valid','is-invalid');
        const wrap = input.parentElement;
        const jsFb = wrap.querySelector('.invalid-feedback.js-feedback');

        if (!ok) {
            input.classList.add('is-invalid');
            if (jsFb) {
                jsFb.style.display = 'block';
                jsFb.textContent = msg || 'Campo inválido.';
            }
        } else {
            input.classList.add('is-valid');
            if (jsFb) {
                jsFb.style.display = 'none';
                jsFb.textContent = '';
            }
        }
    }

    function maskCPF(v){
        v = onlyDigits(v).slice(0,11);
        v = v.replace(/^(\d{3})(\d)/, '$1.$2');
        v = v.replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3');
        v = v.replace(/\.(\d{3})(\d)/, '.$1-$2');
        return v;
    }

    function cpfValido(cpf){
        cpf = onlyDigits(cpf);
        if (cpf.length !== 11) return false;
        if (/^(\d)\1+$/.test(cpf)) return false;

        let soma = 0;
        for (let i=0; i<9; i++) soma += parseInt(cpf[i]) * (10 - i);
        let d1 = (soma * 10) % 11;
        if (d1 === 10) d1 = 0;
        if (d1 !== parseInt(cpf[9])) return false;

        soma = 0;
        for (let i=0; i<10; i++) soma += parseInt(cpf[i]) * (11 - i);
        let d2 = (soma * 10) % 11;
        if (d2 === 10) d2 = 0;

        return d2 === parseInt(cpf[10]);
    }

    function maskTelefone(v){
        v = onlyDigits(v).slice(0,11);

        if (v.length <= 10) {
            v = v.replace(/^(\d{2})(\d)/, '($1) $2');
            v = v.replace(/(\d{4})(\d)/, '$1-$2');
        } else {
            v = v.replace(/^(\d{2})(\d)/, '($1) $2');
            v = v.replace(/(\d{5})(\d)/, '$1-$2');
        }

        return v;
    }

    function maskCEP(v){
        v = onlyDigits(v).slice(0,8);
        if (v.length > 5) v = v.replace(/^(\d{5})(\d{1,3})$/, '$1-$2');
        return v;
    }

    async function buscarCep(cep) {
        const res = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
        if (!res.ok) throw new Error('Falha ao consultar CEP');
        return await res.json();
    }

    cpfInput?.addEventListener('input', () => cpfInput.value = maskCPF(cpfInput.value));
    telefoneInput?.addEventListener('input', () => telefoneInput.value = maskTelefone(telefoneInput.value));
    cepInput?.addEventListener('input', () => cepInput.value = maskCEP(cepInput.value));

    cpfInput?.addEventListener('blur', () => {
        const raw = onlyDigits(cpfInput.value);
        if (!raw) return;
        setFeedback(cpfInput, cpfValido(raw), 'CPF inválido. Confira os números.');
    });

    telefoneInput?.addEventListener('blur', () => {
        const raw = onlyDigits(telefoneInput.value);
        if (!raw) return;
        setFeedback(telefoneInput, raw.length >= 10 && raw.length <= 11, 'Telefone inválido. Ex: (11) 99999-9999');
    });

    emailInput?.addEventListener('blur', () => {
        if (!emailInput.value) return;
        setFeedback(emailInput, emailInput.checkValidity(), 'E-mail inválido. Use o formato nome@dominio.com');
    });

    function validarSenhas(){
        const p1 = passwordInput.value || '';
        const p2 = passwordConfirmInput.value || '';

        if (p1) {
            setFeedback(passwordInput, p1.length >= 8, 'A senha precisa ter pelo menos 8 caracteres.');
        }

        if (p2) {
            setFeedback(passwordConfirmInput, p1 === p2, 'As senhas não conferem.');
        }
    }

    passwordInput?.addEventListener('blur', validarSenhas);
    passwordConfirmInput?.addEventListener('blur', validarSenhas);

    let cepTimer = null;

    cepInput?.addEventListener('input', () => {
        clearTimeout(cepTimer);

        cepStatus.textContent = '';
        cepStatus.className = 'form-text';

        cepTimer = setTimeout(async () => {
            const cep = onlyDigits(cepInput.value);
            if (cep.length !== 8) return;

            cepStatus.textContent = 'Buscando endereço...';
            cepStatus.className = 'form-text text-muted';

            try {
                const data = await buscarCep(cep);

                if (data.erro) {
                    setFeedback(cepInput, false, 'CEP não encontrado. Confira e tente novamente.');
                    cepStatus.textContent = '';
                    return;
                }

                setFeedback(cepInput, true);
                logradouroInput.value = data.logradouro || logradouroInput.value;
                bairroInput.value = data.bairro || bairroInput.value;
                cidadeInput.value = data.localidade || cidadeInput.value;
                estadoInput.value = data.uf || estadoInput.value;

                cepStatus.textContent = 'Endereço preenchido automaticamente.';
                cepStatus.className = 'form-text text-success';
            } catch (e) {
                setFeedback(cepInput, false, 'Não foi possível consultar o CEP agora.');
                cepStatus.textContent = '';
            }
        }, 400);
    });

    form?.querySelectorAll('input[required]').forEach((input) => {
        input.addEventListener('blur', () => {
            if (!input.value) {
                setFeedback(input, false, 'Este campo é obrigatório.');
            }
        });

        input.addEventListener('input', () => {
            if (input.value) {
                input.classList.remove('is-invalid');
                const jsFb = input.parentElement.querySelector('.invalid-feedback.js-feedback');
                if (jsFb) {
                    jsFb.style.display = 'none';
                    jsFb.textContent = '';
                }
            }
        });
    });

    form?.addEventListener('submit', (e) => {
        cpfInput?.dispatchEvent(new Event('blur'));
        telefoneInput?.dispatchEvent(new Event('blur'));
        emailInput?.dispatchEvent(new Event('blur'));
        validarSenhas();

        const invalid = form.querySelector('.is-invalid');
        if (invalid) {
            e.preventDefault();
            invalid.focus();
        }
    });
});
</script>
@endpush
@endsection