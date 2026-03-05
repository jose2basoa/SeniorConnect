@extends('layouts.app')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">

            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-5">

                    <h3 class="text-center mb-2 text-primary fw-bold">
                        Criar Conta - Tutor
                    </h3>
                    <p class="text-center text-muted mb-4">
                        Preencha seus dados para começar a usar o sistema.
                    </p>

                    <form method="POST" action="{{ route('register') }}" id="form-register" novalidate>
                        @csrf

                        <div class="row">
                            <!-- Nome -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nome</label>
                                <input type="text"
                                    name="name"
                                    id="name"
                                    value="{{ old('name') }}"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Ex: João"
                                    required>

                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <div class="invalid-feedback js-feedback" style="display:none;"></div>
                            </div>

                            <!-- Sobrenome -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sobrenome</label>
                                <input type="text"
                                    name="sobrenome"
                                    id="sobrenome"
                                    value="{{ old('sobrenome') }}"
                                    class="form-control @error('sobrenome') is-invalid @enderror"
                                    placeholder="Ex: Silva"
                                    required>

                                @error('sobrenome')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <div class="invalid-feedback js-feedback" style="display:none;"></div>
                            </div>
                        </div>

                        <!-- CPF -->
                        <div class="mb-3">
                            <label class="form-label">CPF</label>
                            <input type="text"
                                name="cpf"
                                id="cpf"
                                value="{{ old('cpf') }}"
                                class="form-control @error('cpf') is-invalid @enderror"
                                placeholder="000.000.000-00"
                                inputmode="numeric"
                                autocomplete="off"
                                required>

                            @error('cpf')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div class="invalid-feedback js-feedback" style="display:none;"></div>
                            <div class="form-text">
                                Usamos o CPF apenas para identificação e segurança.
                            </div>
                        </div>

                        <div class="row">
                            <!-- Telefone -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Telefone</label>
                                <input type="text"
                                    name="telefone"
                                    id="telefone"
                                    value="{{ old('telefone') }}"
                                    class="form-control @error('telefone') is-invalid @enderror"
                                    placeholder="(00) 00000-0000"
                                    inputmode="numeric"
                                    autocomplete="tel"
                                    required>

                                @error('telefone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <div class="invalid-feedback js-feedback" style="display:none;"></div>
                            </div>

                            <!-- Data Nascimento -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Data de Nascimento</label>
                                <input type="date"
                                    name="data_nascimento"
                                    id="data_nascimento"
                                    value="{{ old('data_nascimento') }}"
                                    class="form-control @error('data_nascimento') is-invalid @enderror"
                                    required>

                                @error('data_nascimento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <div class="invalid-feedback js-feedback" style="display:none;"></div>
                            </div>
                        </div>

                        <!-- CEP -->
                        <div class="mb-3">
                            <label class="form-label">CEP</label>
                            <input type="text"
                                name="cep"
                                id="cep"
                                value="{{ old('cep') }}"
                                class="form-control @error('cep') is-invalid @enderror"
                                placeholder="00000-000"
                                inputmode="numeric"
                                autocomplete="postal-code"
                                required>

                            @error('cep')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div class="invalid-feedback js-feedback" style="display:none;"></div>
                            <div class="form-text" id="cep-status"></div>
                        </div>

                        <!-- Endereço -->
                        <div class="mb-3">
                            <label class="form-label">Endereço</label>
                            <input type="text"
                                name="endereco"
                                id="endereco"
                                value="{{ old('endereco') }}"
                                class="form-control @error('endereco') is-invalid @enderror"
                                placeholder="Rua / Bairro / Cidade - UF"
                                required>

                            @error('endereco')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div class="invalid-feedback js-feedback" style="display:none;"></div>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label">E-mail</label>
                            <input type="email"
                                name="email"
                                id="email"
                                value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="nome@dominio.com"
                                autocomplete="email"
                                required>

                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div class="invalid-feedback js-feedback" style="display:none;"></div>
                        </div>

                        <!-- Senha -->
                        <div class="mb-3">
                            <label class="form-label">Senha</label>
                            <input type="password"
                                name="password"
                                id="password"
                                class="form-control @error('password') is-invalid @enderror"
                                autocomplete="new-password"
                                required>

                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div class="form-text">
                                Dica: use pelo menos 8 caracteres.
                            </div>
                            <div class="invalid-feedback js-feedback" style="display:none;"></div>
                        </div>

                        <!-- Confirmar Senha -->
                        <div class="mb-4">
                            <label class="form-label">Confirmar Senha</label>
                            <input type="password"
                                name="password_confirmation"
                                id="password_confirmation"
                                class="form-control"
                                autocomplete="new-password"
                                required>

                            <div class="invalid-feedback js-feedback" style="display:none;"></div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Registrar
                            </button>
                        </div>

                        <div class="text-center mt-3">
                            <a href="{{ route('login') }}">
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
    const enderecoInput = document.getElementById('endereco');
    const cepStatus = document.getElementById('cep-status');

    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const passwordConfirmInput = document.getElementById('password_confirmation');

    function onlyDigits(v){ return (v || '').replace(/\D/g,''); }

    function setFeedback(input, ok, msg = ''){
        // não sobrescreve erro do Laravel se já tem is-invalid na renderização
        // mas pode complementar se o usuário mexer no campo
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

    // ===== CPF (máscara + validação real) =====
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

    cpfInput.addEventListener('input', () => {
        cpfInput.value = maskCPF(cpfInput.value);
    });

    cpfInput.addEventListener('blur', () => {
        const raw = onlyDigits(cpfInput.value);
        if (!raw) return; // required cuida
        const ok = cpfValido(raw);
        setFeedback(cpfInput, ok, 'CPF inválido. Confira os números.');
    });

    // ===== Telefone (máscara BR) =====
    function maskTelefone(v){
        v = onlyDigits(v).slice(0,11);
        if (v.length <= 10) {
            // (00) 0000-0000
            v = v.replace(/^(\d{2})(\d)/, '($1) $2');
            v = v.replace(/(\d{4})(\d)/, '$1-$2');
        } else {
            // (00) 00000-0000
            v = v.replace(/^(\d{2})(\d)/, '($1) $2');
            v = v.replace(/(\d{5})(\d)/, '$1-$2');
        }
        return v;
    }

    telefoneInput.addEventListener('input', () => {
        telefoneInput.value = maskTelefone(telefoneInput.value);
    });

    telefoneInput.addEventListener('blur', () => {
        const raw = onlyDigits(telefoneInput.value);
        if (!raw) return;
        const ok = raw.length >= 10 && raw.length <= 11;
        setFeedback(telefoneInput, ok, 'Telefone inválido. Ex: (11) 99999-9999');
    });

    // ===== CEP (máscara + ViaCEP) =====
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

    let cepTimer = null;

    cepInput.addEventListener('input', () => {
        cepInput.value = maskCEP(cepInput.value);

        // limpa status
        cepStatus.textContent = '';
        cepStatus.className = 'form-text';

        clearTimeout(cepTimer);
        cepTimer = setTimeout(async () => {
            const cep = onlyDigits(cepInput.value);
            if (cep.length !== 8) return;

            enderecoInput.disabled = true;
            enderecoInput.value = '';
            cepStatus.textContent = 'Buscando endereço...';
            cepStatus.className = 'form-text text-muted';

            try {
                const data = await buscarCep(cep);

                if (data.erro) {
                    setFeedback(cepInput, false, 'CEP não encontrado. Confira e tente novamente.');
                    cepStatus.textContent = '';
                    enderecoInput.value = '';
                } else {
                    setFeedback(cepInput, true);
                    const texto = [
                        data.logradouro,
                        data.bairro,
                        `${data.localidade}/${data.uf}`
                    ].filter(Boolean).join(' - ');

                    enderecoInput.value = texto || '';
                    if (texto) setFeedback(enderecoInput, true);
                    cepStatus.textContent = 'Endereço preenchido automaticamente.';
                    cepStatus.className = 'form-text text-success';
                }
            } catch (e) {
                setFeedback(cepInput, false, 'Não foi possível consultar o CEP agora. Tente novamente.');
                cepStatus.textContent = '';
                enderecoInput.value = '';
            } finally {
                enderecoInput.disabled = false;
            }
        }, 400);
    });

    // ===== Email (mensagem humana) =====
    emailInput.addEventListener('blur', () => {
        if (!emailInput.value) return;
        const ok = emailInput.checkValidity();
        setFeedback(emailInput, ok, 'E-mail inválido. Verifique se está no formato nome@dominio.com');
    });

    // ===== Senha + confirmação =====
    function validarSenhas(){
        const p1 = passwordInput.value || '';
        const p2 = passwordConfirmInput.value || '';

        if (p1) {
            const ok = p1.length >= 8;
            setFeedback(passwordInput, ok, 'A senha precisa ter pelo menos 8 caracteres.');
        }

        if (p2) {
            const ok2 = p1 === p2;
            setFeedback(passwordConfirmInput, ok2, 'As senhas não conferem.');
        }
    }

    passwordInput.addEventListener('blur', validarSenhas);
    passwordConfirmInput.addEventListener('blur', validarSenhas);

    // ===== Campos obrigatórios com mensagem amigável =====
    form.querySelectorAll('input[required]').forEach((input) => {
        input.addEventListener('blur', () => {
            if (!input.value) {
                setFeedback(input, false, 'Este campo é obrigatório.');
            }
        });

        input.addEventListener('input', () => {
            // se começou a digitar, remove erro
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

    // ===== Bloqueia envio se tiver inválidos do front =====
    form.addEventListener('submit', (e) => {
        // dispara validações principais
        cpfInput.dispatchEvent(new Event('blur'));
        telefoneInput.dispatchEvent(new Event('blur'));
        emailInput.dispatchEvent(new Event('blur'));
        validarSenhas();

        // se algum input está inválido, impede submit
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