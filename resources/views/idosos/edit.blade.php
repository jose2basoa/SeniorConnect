@extends('layouts.app')

@section('content')
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Editar cadastro</h3>
            <small class="text-muted">
                Atualize as informações por seção. Cada bloco salva separadamente.
            </small>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('idosos.show', $idoso->id) }}" class="btn btn-outline-secondary rounded-3">
                <i class="bi bi-arrow-left me-1"></i> Voltar ao perfil
            </a>
        </div>
    </div>

    @if(session('success_step1')) <div class="alert alert-success rounded-4"><i class="bi bi-check-circle me-1"></i>{{ session('success_step1') }}</div> @endif
    @if(session('success_step2')) <div class="alert alert-success rounded-4"><i class="bi bi-check-circle me-1"></i>{{ session('success_step2') }}</div> @endif
    @if(session('success_step3')) <div class="alert alert-success rounded-4"><i class="bi bi-check-circle me-1"></i>{{ session('success_step3') }}</div> @endif
    @if(session('success_step4')) <div class="alert alert-success rounded-4"><i class="bi bi-check-circle me-1"></i>{{ session('success_step4') }}</div> @endif

    <div class="row g-4">

        <div class="col-lg-3 d-none d-lg-block">
            <div class="card shadow-sm border-0 rounded-4 position-sticky" style="top: 90px;">
                <div class="card-body p-3">
                    <div class="fw-bold mb-2">Seções</div>

                    <div class="list-group list-group-flush small">
                        <a class="list-group-item list-group-item-action rounded-3" href="#card-pessoais">
                            <i class="bi bi-1-circle me-1"></i> Dados pessoais
                        </a>
                        <a class="list-group-item list-group-item-action rounded-3" href="#card-endereco">
                            <i class="bi bi-2-circle me-1"></i> Endereço
                        </a>
                        <a class="list-group-item list-group-item-action rounded-3" href="#card-clinico">
                            <i class="bi bi-3-circle me-1"></i> Dados clínicos
                        </a>
                        <a class="list-group-item list-group-item-action rounded-3" href="#card-contatos">
                            <i class="bi bi-4-circle me-1"></i> Contatos
                        </a>
                    </div>

                    <hr class="my-3">

                    <button type="button" id="btnTop" class="btn btn-outline-secondary w-100 rounded-3">
                        <i class="bi bi-arrow-up"></i> Topo
                    </button>
                </div>
            </div>
        </div>

        <div class="col-lg-9">

            <div id="card-pessoais" class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-light fw-bold rounded-top-4">
                    <i class="bi bi-1-circle me-1"></i> Dados pessoais
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('idosos.update.step1', $idoso->id) }}" id="form-step1">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nome *</label>
                                <input type="text"
                                       name="nome"
                                       value="{{ old('nome', $idoso->nome) }}"
                                       class="form-control @error('nome') is-invalid @enderror"
                                       required>
                                @error('nome') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Nascimento *</label>
                                <input type="date"
                                       name="data_nascimento"
                                       value="{{ old('data_nascimento', $idoso->data_nascimento) }}"
                                       class="form-control @error('data_nascimento') is-invalid @enderror"
                                       required>
                                @error('data_nascimento') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Sexo</label>
                                <select name="sexo" class="form-select @error('sexo') is-invalid @enderror">
                                    <option value="">Selecione</option>
                                    <option value="Masculino" @selected(old('sexo', $idoso->sexo) === 'Masculino')>Masculino</option>
                                    <option value="Feminino" @selected(old('sexo', $idoso->sexo) === 'Feminino')>Feminino</option>
                                    <option value="Outro" @selected(old('sexo', $idoso->sexo) === 'Outro')>Outro</option>
                                </select>
                                @error('sexo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">CPF *</label>
                                <input type="text"
                                       name="cpf"
                                       id="cpf"
                                       value="{{ old('cpf', $idoso->cpf) }}"
                                       class="form-control @error('cpf') is-invalid @enderror"
                                       placeholder="000.000.000-00"
                                       inputmode="numeric"
                                       required>
                                @error('cpf') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Telefone</label>
                                <input type="text"
                                       name="telefone"
                                       id="telefone"
                                       value="{{ old('telefone', $idoso->telefone) }}"
                                       class="form-control @error('telefone') is-invalid @enderror"
                                       placeholder="(00) 00000-0000"
                                       inputmode="numeric">
                                @error('telefone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Observações</label>
                                <textarea name="observacoes"
                                          rows="4"
                                          class="form-control @error('observacoes') is-invalid @enderror"
                                          placeholder="Rotina, cuidados, limitações, preferências...">{{ old('observacoes', $idoso->observacoes) }}</textarea>
                                @error('observacoes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary rounded-3">
                                <i class="bi bi-check2-circle me-1"></i> Salvar dados pessoais
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="card-endereco" class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-light fw-bold rounded-top-4">
                    <i class="bi bi-2-circle me-1"></i> Endereço
                </div>

                <div class="card-body p-4">
                    @php $e = $idoso->endereco; @endphp

                    <form method="POST" action="{{ route('idosos.update.step2', $idoso->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">CEP</label>
                                <input type="text"
                                       name="cep"
                                       id="cep"
                                       value="{{ old('cep', $e->cep ?? '') }}"
                                       class="form-control @error('cep') is-invalid @enderror"
                                       placeholder="00000-000">
                                @error('cep') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Logradouro</label>
                                <input type="text"
                                       name="logradouro"
                                       id="logradouro"
                                       value="{{ old('logradouro', $e->logradouro ?? '') }}"
                                       class="form-control"
                                       placeholder="Ex: Av. Brasil">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Número</label>
                                <input type="text"
                                       name="numero"
                                       value="{{ old('numero', $e->numero ?? '') }}"
                                       class="form-control"
                                       placeholder="Ex: 123">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Complemento</label>
                                <input type="text"
                                       name="complemento"
                                       value="{{ old('complemento', $e->complemento ?? '') }}"
                                       class="form-control"
                                       placeholder="Apto, casa dos fundos...">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Bairro</label>
                                <input type="text"
                                       name="bairro"
                                       id="bairro"
                                       value="{{ old('bairro', $e->bairro ?? '') }}"
                                       class="form-control"
                                       placeholder="Ex: Centro">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Cidade</label>
                                <input type="text"
                                       name="cidade"
                                       id="cidade"
                                       value="{{ old('cidade', $e->cidade ?? '') }}"
                                       class="form-control"
                                       placeholder="Ex: Guararapes">
                            </div>

                            <div class="col-md-2">
                                <label class="form-label fw-semibold">UF</label>
                                @php $uf = old('estado', $e->estado ?? ''); @endphp
                                <select name="estado" id="estado" class="form-select @error('estado') is-invalid @enderror">
                                    <option value="">UF</option>
                                    @foreach(['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'] as $u)
                                        <option value="{{ $u }}" @selected($uf === $u)>{{ $u }}</option>
                                    @endforeach
                                </select>
                                @error('estado') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary rounded-3">
                                <i class="bi bi-check2-circle me-1"></i> Salvar endereço
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="card-clinico" class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-light fw-bold rounded-top-4">
                    <i class="bi bi-3-circle me-1"></i> Dados clínicos
                </div>

                <div class="card-body p-4">
                    @php $c = $idoso->dadosClinico; @endphp

                    <form method="POST" action="{{ route('idosos.update.step3', $idoso->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Cartão SUS</label>
                                <input type="text"
                                       name="cartao_sus"
                                       id="cartao_sus"
                                       value="{{ old('cartao_sus', $c->cartao_sus ?? '') }}"
                                       class="form-control @error('cartao_sus') is-invalid @enderror"
                                       placeholder="000 0000 0000 0000">
                                @error('cartao_sus') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Plano de saúde</label>
                                <input type="text"
                                       name="plano_saude"
                                       value="{{ old('plano_saude', $c->plano_saude ?? '') }}"
                                       class="form-control @error('plano_saude') is-invalid @enderror"
                                       placeholder="Ex: Unimed">
                                @error('plano_saude') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Número do plano</label>
                                <input type="text"
                                       name="numero_plano"
                                       value="{{ old('numero_plano', $c->numero_plano ?? '') }}"
                                       class="form-control @error('numero_plano') is-invalid @enderror"
                                       placeholder="Carteirinha / matrícula">
                                @error('numero_plano') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Tipo sanguíneo</label>
                                @php $ts = old('tipo_sanguineo', $c->tipo_sanguineo ?? ''); @endphp
                                <select name="tipo_sanguineo" class="form-select @error('tipo_sanguineo') is-invalid @enderror">
                                    <option value="">Selecione</option>
                                    <option value="A+" @selected($ts==='A+')>A+</option>
                                    <option value="A-" @selected($ts==='A-')>A-</option>
                                    <option value="B+" @selected($ts==='B+')>B+</option>
                                    <option value="B-" @selected($ts==='B-')>B-</option>
                                    <option value="AB+" @selected($ts==='AB+')>AB+</option>
                                    <option value="AB-" @selected($ts==='AB-')>AB-</option>
                                    <option value="O+" @selected($ts==='O+')>O+</option>
                                    <option value="O-" @selected($ts==='O-')>O-</option>
                                    <option value="Não sabe" @selected($ts==='Não sabe')>Não sabe</option>
                                </select>
                                @error('tipo_sanguineo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Alergias</label>
                                <textarea name="alergias" class="form-control" rows="3">{{ old('alergias', $c->alergias ?? '') }}</textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Doenças crônicas</label>
                                <textarea name="doencas_cronicas" class="form-control" rows="3">{{ old('doencas_cronicas', $c->doencas_cronicas ?? '') }}</textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Restrições</label>
                                <textarea name="restricoes" class="form-control" rows="3">{{ old('restricoes', $c->restricoes ?? '') }}</textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary rounded-3">
                                <i class="bi bi-check2-circle me-1"></i> Salvar dados clínicos
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="card-contatos" class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-light fw-bold rounded-top-4">
                    <i class="bi bi-4-circle me-1"></i> Contatos de emergência
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('idosos.update.step4', $idoso->id) }}">
                        @csrf
                        @method('PUT')

                        @php
                            $contatos = old('contatos', $idoso->contatosEmergencia->toArray());
                        @endphp

                        <div id="contatos-wrapper">
                            @forelse($contatos as $i => $ct)
                                <div class="border rounded-4 p-3 mb-3 contato-item">
                                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                                        <strong>
                                            Contato #{{ $i + 1 }}
                                            @if($i === 0)
                                                <span class="badge bg-success ms-2">Principal</span>
                                            @endif
                                        </strong>

                                        @if($i > 0)
                                            <button type="button" class="btn btn-outline-danger btn-sm btn-remove-contato">
                                                <i class="bi bi-x-circle me-1"></i> Remover
                                            </button>
                                        @endif
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Nome *</label>
                                            <input type="text" name="contatos[{{ $i }}][nome]" value="{{ $ct['nome'] ?? '' }}" class="form-control" required>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">Telefone *</label>
                                            <input type="text" name="contatos[{{ $i }}][telefone]" value="{{ $ct['telefone'] ?? '' }}" class="form-control js-phone" placeholder="(00) 00000-0000" required>
                                        </div>

                                        <div class="col-md-2">
                                            <label class="form-label fw-semibold">Parentesco</label>
                                            <input type="text" name="contatos[{{ $i }}][parentesco]" value="{{ $ct['parentesco'] ?? '' }}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="border rounded-4 p-3 mb-3 contato-item">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <strong>Contato #1 <span class="badge bg-success ms-2">Principal</span></strong>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Nome *</label>
                                            <input type="text" name="contatos[0][nome]" class="form-control" required>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">Telefone *</label>
                                            <input type="text" name="contatos[0][telefone]" class="form-control js-phone" placeholder="(00) 00000-0000" required>
                                        </div>

                                        <div class="col-md-2">
                                            <label class="form-label fw-semibold">Parentesco</label>
                                            <input type="text" name="contatos[0][parentesco]" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        <button type="button" id="btn-add-contato" class="btn btn-outline-primary rounded-3">
                            <i class="bi bi-plus-circle me-1"></i> Adicionar contato
                        </button>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary rounded-3">
                                <i class="bi bi-check2-circle me-1"></i> Salvar contatos
                            </button>
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
    const btnTop = document.getElementById('btnTop');
    btnTop?.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

    const cpfInput = document.getElementById('cpf');
    const telefoneInput = document.getElementById('telefone');
    const cepInput = document.getElementById('cep');
    const cartaoSusInput = document.getElementById('cartao_sus');

    function onlyDigits(v){ return (v || '').replace(/\D/g,''); }

    function formatCPF(v){
        v = onlyDigits(v).slice(0,11);
        v = v.replace(/(\d{3})(\d)/, '$1.$2');
        v = v.replace(/(\d{3})(\d)/, '$1.$2');
        v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        return v;
    }

    function formatTelefone(v){
        v = onlyDigits(v).slice(0,11);
        if (v.length <= 10) {
            v = v.replace(/(\d{2})(\d)/, '($1) $2');
            v = v.replace(/(\d{4})(\d)/, '$1-$2');
        } else {
            v = v.replace(/(\d{2})(\d)/, '($1) $2');
            v = v.replace(/(\d{5})(\d)/, '$1-$2');
        }
        return v;
    }

    function formatCEP(v){
        v = onlyDigits(v).slice(0,8);
        v = v.replace(/(\d{5})(\d)/, '$1-$2');
        return v;
    }

    function formatSUS(v){
        v = onlyDigits(v).slice(0,15);
        const parts = [v.slice(0,3), v.slice(3,7), v.slice(7,11), v.slice(11,15)].filter(Boolean);
        return parts.join(' ');
    }

    cpfInput?.addEventListener('input', () => cpfInput.value = formatCPF(cpfInput.value));
    telefoneInput?.addEventListener('input', () => telefoneInput.value = formatTelefone(telefoneInput.value));
    cepInput?.addEventListener('input', () => cepInput.value = formatCEP(cepInput.value));
    cartaoSusInput?.addEventListener('input', () => cartaoSusInput.value = formatSUS(cartaoSusInput.value));

    if (cpfInput) cpfInput.value = formatCPF(cpfInput.value);
    if (telefoneInput) telefoneInput.value = formatTelefone(telefoneInput.value);
    if (cepInput) cepInput.value = formatCEP(cepInput.value);
    if (cartaoSusInput) cartaoSusInput.value = formatSUS(cartaoSusInput.value);

    const logradouro = document.getElementById('logradouro');
    const bairro = document.getElementById('bairro');
    const cidade = document.getElementById('cidade');
    const estado = document.getElementById('estado');

    let cepTimer = null;

    cepInput?.addEventListener('input', () => {
        clearTimeout(cepTimer);

        cepTimer = setTimeout(async () => {
            const cep = onlyDigits(cepInput.value);
            if (cep.length !== 8) return;

            try {
                const res = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
                const data = await res.json();

                if (data.erro) return;

                if (logradouro) logradouro.value = data.logradouro || '';
                if (bairro) bairro.value = data.bairro || '';
                if (cidade) cidade.value = data.localidade || '';
                if (estado) estado.value = data.uf || '';
            } catch (e) {}
        }, 400);
    });

    const wrapper = document.getElementById('contatos-wrapper');
    const btnAdd = document.getElementById('btn-add-contato');

    function applyPhoneMasks() {
        document.querySelectorAll('.js-phone').forEach(input => {
            input.removeEventListener('input', input._phoneMaskHandler || (() => {}));

            const handler = () => input.value = formatTelefone(input.value);
            input._phoneMaskHandler = handler;
            input.addEventListener('input', handler);
            input.value = formatTelefone(input.value);
        });
    }

    function reindexContacts() {
        const items = wrapper.querySelectorAll('.contato-item');

        items.forEach((item, index) => {
            const title = item.querySelector('strong');
            if (title) {
                title.innerHTML = `Contato #${index + 1} ${index === 0 ? '<span class="badge bg-success ms-2">Principal</span>' : ''}`;
            }

            item.querySelectorAll('input').forEach(input => {
                input.name = input.name.replace(/contatos\[\d+\]/, `contatos[${index}]`);
            });

            const removeBtn = item.querySelector('.btn-remove-contato');
            if (removeBtn) {
                removeBtn.classList.toggle('d-none', index === 0);
            }
        });

        applyPhoneMasks();
    }

    btnAdd?.addEventListener('click', () => {
        const index = wrapper.querySelectorAll('.contato-item').length;

        const div = document.createElement('div');
        div.className = 'border rounded-4 p-3 mb-3 contato-item';
        div.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <strong>Contato #${index + 1}</strong>
                <button type="button" class="btn btn-outline-danger btn-sm btn-remove-contato">
                    <i class="bi bi-x-circle me-1"></i> Remover
                </button>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nome *</label>
                    <input type="text" name="contatos[${index}][nome]" class="form-control" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Telefone *</label>
                    <input type="text" name="contatos[${index}][telefone]" class="form-control js-phone" placeholder="(00) 00000-0000" required>
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-semibold">Parentesco</label>
                    <input type="text" name="contatos[${index}][parentesco]" class="form-control">
                </div>
            </div>
        `;

        wrapper.appendChild(div);
        reindexContacts();
    });

    wrapper?.addEventListener('click', (e) => {
        const btn = e.target.closest('.btn-remove-contato');
        if (!btn) return;

        const items = wrapper.querySelectorAll('.contato-item');
        if (items.length <= 1) {
            alert('É obrigatório manter pelo menos 1 contato.');
            return;
        }

        btn.closest('.contato-item').remove();
        reindexContacts();
    });

    applyPhoneMasks();
});
</script>
@endpush
@endsection