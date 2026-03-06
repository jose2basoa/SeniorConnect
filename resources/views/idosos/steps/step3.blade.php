@php $step = 3; @endphp
@extends('layouts.wizard')

@section('wizard-content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
        <div>
            <h4 class="fw-bold mb-1">Informações de saúde</h4>
            <div class="text-muted small">
                Esses dados ajudam em situações de emergência e no acompanhamento.
            </div>
        </div>

        <div class="text-end">
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2">
                Etapa 3 de 4
            </span>
        </div>
    </div>

    <div class="progress mb-4" style="height: 10px;">
        <div class="progress-bar" style="width: 75%;" role="progressbar"
             aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger d-flex align-items-start gap-2">
            <i class="bi bi-exclamation-triangle mt-1"></i>
            <div>
                <strong>Ops!</strong> Revise os campos destacados.
            </div>
        </div>
    @endif

    <div id="card-clinico" class="card shadow-sm border-0 rounded-4 mb-4 js-card">

        <div class="card-body p-4">
            @php
                $c = $clinico ?? null;

                $planosFamosos = [
                    'Unimed','Bradesco Saúde','SulAmérica','Amil',
                    'Hapvida NotreDame Intermédica','Porto Saúde','São Cristóvão Saúde',
                    'Prevent Senior','Assim Saúde','BlueMed',
                ];

                $planoAtual = old('plano_saude', $c->plano_saude ?? '');
                $isOutro = $planoAtual && !in_array($planoAtual, $planosFamosos) && $planoAtual !== 'Não possui';
            @endphp

            <form method="POST" action="{{ route('idosos.store.step3', $idoso->id) }}" novalidate>
                @csrf

                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Cartão SUS</label>
                        <input type="text"
                               name="cartao_sus"
                               id="cartao_sus"
                               inputmode="numeric"
                               autocomplete="off"
                               placeholder="000 0000 0000 0000"
                               value="{{ old('cartao_sus', $c->cartao_sus ?? '') }}"
                               class="form-control @error('cartao_sus') is-invalid @enderror">
                        @error('cartao_sus') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <small class="text-muted">Formato: 15 dígitos (opcional).</small>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Plano de saúde</label>

                        <select name="plano_saude" id="plano_saude_select"
                                class="form-select @error('plano_saude') is-invalid @enderror">
                            <option value="">Selecione</option>
                            <option value="Não possui" @selected($planoAtual === 'Não possui')>Não possui</option>

                            <optgroup label="Planos mais comuns">
                                @foreach($planosFamosos as $p)
                                    <option value="{{ $p }}" @selected($planoAtual === $p)>{{ $p }}</option>
                                @endforeach
                            </optgroup>

                            <option value="__outro__" @selected($isOutro)>Outro plano</option>
                        </select>

                        @error('plano_saude') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text">Opcional.</div>
                    </div>

                    <div class="col-md-4" id="wrap_outro_plano">
                        <label class="form-label fw-bold">Qual plano?</label>
                        <input type="text"
                               id="outro_plano_input"
                               class="form-control"
                               placeholder="Digite o nome do plano"
                               value="{{ $isOutro ? $planoAtual : '' }}">
                        <small class="text-muted">Será salvo como “Plano de saúde”.</small>
                    </div>

                    <div class="col-md-4" id="wrap_numero_plano">
                        <label class="form-label fw-bold">Número do plano</label>
                        <input type="text"
                               name="numero_plano"
                               id="numero_plano"
                               value="{{ old('numero_plano', $c->numero_plano ?? '') }}"
                               class="form-control @error('numero_plano') is-invalid @enderror"
                               placeholder="Carteirinha / matrícula / código">
                        @error('numero_plano') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text">Opcional.</div>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Tipo sanguíneo</label>
                        <select name="tipo_sanguineo" class="form-select @error('tipo_sanguineo') is-invalid @enderror">
                            @php $ts = old('tipo_sanguineo', $c->tipo_sanguineo ?? ''); @endphp
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
                        <label class="form-label fw-bold">Alergias</label>
                        <textarea name="alergias"
                                  class="form-control @error('alergias') is-invalid @enderror"
                                  rows="3"
                                  placeholder="Ex: dipirona, poeira, frutos do mar...">{{ old('alergias', $c->alergias ?? '') }}</textarea>
                        @error('alergias') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Doenças crônicas</label>
                        <textarea name="doencas_cronicas"
                                  class="form-control @error('doencas_cronicas') is-invalid @enderror"
                                  rows="3"
                                  placeholder="Ex: hipertensão, diabetes, asma...">{{ old('doencas_cronicas', $c->doencas_cronicas ?? '') }}</textarea>
                        @error('doencas_cronicas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Restrições</label>
                        <textarea name="restricoes"
                                  class="form-control @error('restricoes') is-invalid @enderror"
                                  rows="3"
                                  placeholder="Ex: não pode ficar sozinho, restrição alimentar...">{{ old('restricoes', $c->restricoes ?? '') }}</textarea>
                        @error('restricoes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-between gap-2 flex-wrap">
                    <a href="{{ route('idosos.create.step2', $idoso->id) }}" class="btn btn-outline-secondary px-4">
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
document.addEventListener('DOMContentLoaded', () => {
    const sus = document.getElementById('cartao_sus');
    const onlyDigits = (v) => (v || "").replace(/\D/g,'');
    function maskSUS(v){
        v = onlyDigits(v).slice(0,15);
        return v.replace(/(\d{3})(\d)/, '$1 $2')
                .replace(/(\d{4})(\d)/, '$1 $2')
                .replace(/(\d{4})(\d)/, '$1 $2');
    }
    if (sus) {
        sus.addEventListener('input', () => sus.value = maskSUS(sus.value));
        sus.value = maskSUS(sus.value);
    }

    const selectPlano = document.getElementById('plano_saude_select');
    const wrapOutro = document.getElementById('wrap_outro_plano');
    const inputOutro = document.getElementById('outro_plano_input');

    const wrapNumero = document.getElementById('wrap_numero_plano');
    const inputNumero = document.getElementById('numero_plano');

    function setVisible(el, visible) {
        if (!el) return;
        el.style.display = visible ? '' : 'none';
    }

    function applyPlanoUI() {
        if (!selectPlano) return;
        const val = selectPlano.value;

        const isOutro = val === '__outro__';
        const naoPossui = val === 'Não possui' || val === '';

        setVisible(wrapOutro, isOutro);
        setVisible(wrapNumero, !naoPossui);

        if (naoPossui && inputNumero) inputNumero.value = '';
    }

    function syncOutroToSelect() {
        if (!selectPlano || !inputOutro) return;
        if (selectPlano.value === '__outro__') {
            const nome = (inputOutro.value || '').trim();
            if (!nome) return;

            let opt = selectPlano.querySelector('option[data-dynamic="1"]');
            if (!opt) {
                opt = document.createElement('option');
                opt.setAttribute('data-dynamic', '1');
                selectPlano.appendChild(opt);
            }
            opt.value = nome;
            opt.textContent = nome;
            opt.selected = true;
        }
    }

    if (selectPlano) {
        selectPlano.addEventListener('change', () => {
            if (selectPlano.value !== '__outro__' && inputOutro) inputOutro.value = '';
            applyPlanoUI();
        });
    }
    if (inputOutro) {
        inputOutro.addEventListener('blur', syncOutroToSelect);
        inputOutro.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                syncOutroToSelect();
            }
        });
    }

    applyPlanoUI();
});
</script>
@endpush

@endsection
