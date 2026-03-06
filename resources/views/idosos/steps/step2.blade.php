@php $step = 2; @endphp
@extends('layouts.wizard')

@section('wizard-content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
        <div>
            <h4 class="fw-bold mb-1">Endereço</h4>
            <div class="text-muted small">
                Se não souber tudo agora, pode preencher depois. O CEP ajuda bastante.
            </div>
        </div>

        <div class="text-end">
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2">
                Etapa 2 de 4
            </span>
        </div>
    </div>

    <div class="progress mb-4" style="height: 10px;">
        <div class="progress-bar" style="width: 50%;" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger d-flex align-items-start gap-2 rounded-4">
            <i class="bi bi-exclamation-triangle mt-1"></i>
            <div>
                <strong>Ops!</strong> Revise os campos destacados.
            </div>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">

            <form method="POST" action="{{ route('idosos.store.step2', $idoso->id) }}" novalidate>
                @csrf

                <div class="row g-3">

                    <div class="col-12 col-md-4">
                        <label class="form-label fw-semibold">CEP</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                            <input
                                type="text"
                                name="cep"
                                id="cep"
                                value="{{ old('cep', $endereco->cep ?? '') }}"
                                class="form-control @error('cep') is-invalid @enderror"
                                placeholder="00000-000"
                                inputmode="numeric"
                                autocomplete="postal-code"
                            >
                            <button class="btn btn-outline-secondary" type="button" id="btnBuscarCep">
                                Buscar
                            </button>
                        </div>
                        @error('cep')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Ao informar o CEP, tentamos completar logradouro, bairro, cidade e estado.</div>
                    </div>

                    <div class="col-12 col-md-8">
                        <label class="form-label fw-semibold">Logradouro</label>
                        <input
                            type="text"
                            name="logradouro"
                            id="logradouro"
                            value="{{ old('logradouro', $endereco->logradouro ?? '') }}"
                            class="form-control @error('logradouro') is-invalid @enderror"
                            placeholder="Ex.: Rua das Flores"
                            autocomplete="address-line1"
                        >
                        @error('logradouro')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-3">
                        <label class="form-label fw-semibold">Número</label>
                        <input
                            type="text"
                            name="numero"
                            value="{{ old('numero', $endereco->numero ?? '') }}"
                            class="form-control @error('numero') is-invalid @enderror"
                            placeholder="Ex.: 123"
                            autocomplete="address-line2"
                        >
                        @error('numero')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-5">
                        <label class="form-label fw-semibold">Complemento</label>
                        <input
                            type="text"
                            name="complemento"
                            value="{{ old('complemento', $endereco->complemento ?? '') }}"
                            class="form-control @error('complemento') is-invalid @enderror"
                            placeholder="Ex.: Apto 12 / Casa dos fundos"
                        >
                        @error('complemento')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-4">
                        <label class="form-label fw-semibold">Bairro</label>
                        <input
                            type="text"
                            name="bairro"
                            id="bairro"
                            value="{{ old('bairro', $endereco->bairro ?? '') }}"
                            class="form-control @error('bairro') is-invalid @enderror"
                            placeholder="Ex.: Centro"
                        >
                        @error('bairro')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Cidade</label>
                        <input
                            type="text"
                            name="cidade"
                            id="cidade"
                            value="{{ old('cidade', $endereco->cidade ?? '') }}"
                            class="form-control @error('cidade') is-invalid @enderror"
                            placeholder="Ex.: Guararapes"
                            autocomplete="address-level2"
                        >
                        @error('cidade')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Estado (UF)</label>
                        <input
                            type="text"
                            name="estado"
                            id="estado"
                            value="{{ old('estado', $endereco->estado ?? '') }}"
                            class="form-control @error('estado') is-invalid @enderror"
                            placeholder="Ex.: SP"
                            maxlength="2"
                            style="text-transform: uppercase;"
                            autocomplete="address-level1"
                        >
                        @error('estado')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-between gap-2 flex-wrap">
                    <a href="{{ route('idosos.create.step1', $idoso->id) }}" class="btn btn-outline-secondary px-4 rounded-3">
                        <i class="bi bi-arrow-left me-1"></i> Voltar
                    </a>

                    <button type="submit" class="btn btn-primary px-4 rounded-3">
                        Próximo <i class="bi bi-arrow-right ms-1"></i>
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@push('scripts')
<script>
(function(){
    const cepEl = document.getElementById('cep');
    const btn = document.getElementById('btnBuscarCep');

    const logradouro = document.getElementById('logradouro');
    const bairro = document.getElementById('bairro');
    const cidade = document.getElementById('cidade');
    const estado = document.getElementById('estado');

    const onlyDigits = (v) => (v || "").replace(/\D/g,'');
    const maskCEP = (v) => {
        v = onlyDigits(v).slice(0,8);
        if (v.length > 5) v = v.replace(/(\d{5})(\d)/, '$1-$2');
        return v;
    };

    async function buscarCEP(){
        const cep = onlyDigits(cepEl.value);
        if (cep.length !== 8) return;

        btn.disabled = true;
        btn.innerText = '...';

        try {
            const resp = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
            const data = await resp.json();
            if (data && !data.erro) {
                if (logradouro && !logradouro.value) logradouro.value = data.logradouro || '';
                if (bairro && !bairro.value) bairro.value = data.bairro || '';
                if (cidade && !cidade.value) cidade.value = data.localidade || '';
                if (estado) estado.value = (data.uf || estado.value || '').toUpperCase();
            }
        } catch (e) {
        } finally {
            btn.disabled = false;
            btn.innerText = 'Buscar';
        }
    }

    if (cepEl) {
        cepEl.addEventListener('input', () => {
            cepEl.value = maskCEP(cepEl.value);
            if (onlyDigits(cepEl.value).length === 8) buscarCEP();
        });
        cepEl.value = maskCEP(cepEl.value);
    }

    if (btn) btn.addEventListener('click', buscarCEP);
})();
</script>
@endpush

@endsection