@php $step = 4; @endphp
@extends('layouts.wizard')

@section('wizard-content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
        <div>
            <h4 class="fw-bold mb-1">Contatos de referência</h4>
            <div class="text-muted small">
                Pelo menos 1 contato é obrigatório (quem deve ser avisado primeiro).
            </div>
        </div>

        <div class="text-end">
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2">
                Etapa 4 de 4
            </span>
        </div>
    </div>

    <div class="progress mb-4" style="height: 10px;">
        <div class="progress-bar bg-primary"
            style="width: 100%;"
            role="progressbar"
            aria-valuenow="100"
            aria-valuemin="0"
            aria-valuemax="100">
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger d-flex align-items-start gap-2">
            <i class="bi bi-exclamation-triangle mt-1"></i>
            <div>
                <strong>Ops!</strong> Revise os campos dos contatos.
            </div>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">

            <form method="POST" action="{{ route('idosos.store.step4', $idoso->id) }}" novalidate>
                @csrf

                <div id="contatos-wrapper">

                    {{-- Contato Principal --}}
                    <div class="contato-item border rounded-4 p-3 mb-3 bg-light">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="fw-bold">
                                Contato principal <span class="badge bg-warning text-dark ms-2">Obrigatório</span>
                            </div>
                            <div class="text-muted small">Avisado primeiro</div>
                        </div>

                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Nome *</label>
                                <input type="text"
                                    name="contatos[0][nome]"
                                    value="{{ old('contatos.0.nome', $contatos[0]->nome ?? '') }}"
                                    class="form-control @error('contatos.0.nome') is-invalid @enderror"
                                    placeholder="Ex.: João da Silva"
                                    required>
                                @error('contatos.0.nome')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Telefone *</label>
                                <input type="text"
                                    name="contatos[0][telefone]"
                                    value="{{ old('contatos.0.telefone', $contatos[0]->telefone ?? '') }}"
                                    class="form-control telefone @error('contatos.0.telefone') is-invalid @enderror"
                                    placeholder="(00) 00000-0000"
                                    inputmode="numeric"
                                    required>
                                @error('contatos.0.telefone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Parentesco (opcional)</label>
                                <input type="text"
                                    name="contatos[0][parentesco]"
                                    value="{{ old('contatos.0.parentesco', $contatos[0]->parentesco ?? '') }}"
                                    class="form-control"
                                    placeholder="Ex.: Filho, Filha, Cuidador, Irmão...">
                            </div>
                        </div>
                    </div>

                    {{-- Contatos extras existentes (se voltar com old) --}}
                    @php
                        $oldContatos = old('contatos');
                        $startIndex = 1;
                        if (is_array($oldContatos) && count($oldContatos) > 1) {
                            $startIndex = count($oldContatos);
                        }
                    @endphp

                    @if(is_array($oldContatos) && count($oldContatos) > 1)
                        @foreach($oldContatos as $i => $c)
                            @continue($i === 0)
                            <div class="contato-item border rounded-4 p-3 mb-3 position-relative">
                                <button type="button"
                                        class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-2"
                                        onclick="removerContato(this)">
                                    <i class="bi bi-x-lg"></i>
                                </button>

                                <div class="fw-bold mb-2">Contato adicional</div>

                                <div class="row g-3">
                                    <div class="col-12 col-md-6">
                                        <label class="form-label fw-semibold">Nome *</label>
                                        <input type="text"
                                            name="contatos[{{ $i }}][nome]"
                                            value="{{ $c['nome'] ?? '' }}"
                                            class="form-control"
                                            required>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="form-label fw-semibold">Telefone *</label>
                                        <input type="text"
                                            name="contatos[{{ $i }}][telefone]"
                                            value="{{ $c['telefone'] ?? '' }}"
                                            class="form-control telefone"
                                            inputmode="numeric"
                                            required>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Parentesco (opcional)</label>
                                        <input type="text"
                                            name="contatos[{{ $i }}][parentesco]"
                                            value="{{ $c['parentesco'] ?? '' }}"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>

                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-2">
                    <button type="button"
                            class="btn btn-outline-primary"
                            onclick="adicionarContato()">
                        <i class="bi bi-person-plus me-1"></i> Adicionar outro contato
                    </button>

                    <div class="text-muted small">
                        Dica: inclua um segundo contato caso o primeiro não atenda.
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-between gap-2 flex-wrap">
                    <a href="{{ route('idosos.create.step3', $idoso->id) }}"
                    class="btn btn-outline-secondary px-4">
                        <i class="bi bi-arrow-left me-1"></i> Voltar
                    </a>

                    <button type="submit" class="btn btn-primary px-4">
                        Finalizar cadastro <i class="bi bi-check2-circle ms-1"></i>
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@push('scripts')
<script>
(function(){
    let index = {{ $startIndex ?? 1 }};

    const onlyDigits = (v) => (v || "").replace(/\D/g,'');
    function maskPhone(v){
        v = onlyDigits(v).slice(0,11);
        if (v.length <= 10) {
            return v.replace(/(\d{2})(\d)/,'($1) $2')
                    .replace(/(\d{4})(\d)/,'$1-$2');
        }
        return v.replace(/(\d{2})(\d)/,'($1) $2')
                .replace(/(\d{5})(\d)/,'$1-$2');
    }

    function applyPhoneMask(container){
        const inputs = container.querySelectorAll('.telefone');
        inputs.forEach(inp => {
            inp.addEventListener('input', () => inp.value = maskPhone(inp.value));
            inp.value = maskPhone(inp.value);
        });
    }

    window.adicionarContato = function(){
        const wrapper = document.getElementById('contatos-wrapper');

        const html = `
            <div class="contato-item border rounded-4 p-3 mb-3 position-relative">
                <button type="button"
                        class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-2"
                        onclick="removerContato(this)">
                    <i class="bi bi-x-lg"></i>
                </button>

                <div class="fw-bold mb-2">Contato adicional</div>

                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Nome *</label>
                        <input type="text"
                            name="contatos[${index}][nome]"
                            class="form-control"
                            placeholder="Ex.: Ana Souza"
                            required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Telefone *</label>
                        <input type="text"
                            name="contatos[${index}][telefone]"
                            class="form-control telefone"
                            placeholder="(00) 00000-0000"
                            inputmode="numeric"
                            required>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Parentesco (opcional)</label>
                        <input type="text"
                            name="contatos[${index}][parentesco]"
                            class="form-control"
                            placeholder="Ex.: Cuidador, Irmã, Vizinho...">
                    </div>
                </div>
            </div>
        `;

        wrapper.insertAdjacentHTML('beforeend', html);
        const last = wrapper.lastElementChild;
        applyPhoneMask(last);

        index++;
    };

    window.removerContato = function(botao){
        botao.closest('.contato-item')?.remove();
    };

    // aplica máscara nos existentes
    applyPhoneMask(document);
})();
</script>
@endpush

@endsection
