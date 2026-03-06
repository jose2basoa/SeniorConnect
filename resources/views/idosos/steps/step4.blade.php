@php $step = 4; @endphp
@extends('layouts.wizard')

@section('wizard-content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
        <div>
            <h4 class="fw-bold mb-1">Contatos de referência</h4>
            <div class="text-muted small">
                Pelo menos 1 contato é obrigatório para concluir o cadastro.
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
        <div class="alert alert-danger d-flex align-items-start gap-2 rounded-4">
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
                    @php
                        $contatosOld = old('contatos');
                        $contatosBase = is_array($contatosOld)
                            ? $contatosOld
                            : (($contatos ?? collect())->count() ? $contatos->map(fn($c) => [
                                'nome' => $c->nome,
                                'telefone' => $c->telefone,
                                'parentesco' => $c->parentesco,
                            ])->toArray() : [[
                                'nome' => '',
                                'telefone' => '',
                                'parentesco' => '',
                            ]]);
                    @endphp

                    @foreach($contatosBase as $i => $c)
                        <div class="contato-item border rounded-4 p-3 mb-3 {{ $i === 0 ? 'bg-light' : 'position-relative' }}">
                            @if($i > 0)
                                <button type="button"
                                        class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-2 btn-remove-contato">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            @endif

                            <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-2">
                                <div class="fw-bold contato-title">
                                    @if($i === 0)
                                        Contato principal <span class="badge bg-warning text-dark ms-2">Obrigatório</span>
                                    @else
                                        
                                    @endif
                                </div>
                                <div class="text-muted small">
                                    {{ $i === 0 ? 'Avisado primeiro' : '' }}
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-semibold">Nome *</label>
                                    <input type="text"
                                        name="contatos[{{ $i }}][nome]"
                                        value="{{ $c['nome'] ?? '' }}"
                                        class="form-control @error('contatos.'.$i.'.nome') is-invalid @enderror"
                                        placeholder="Ex.: João da Silva"
                                        required>
                                    @error('contatos.'.$i.'.nome')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-semibold">Telefone *</label>
                                    <input type="text"
                                        name="contatos[{{ $i }}][telefone]"
                                        value="{{ $c['telefone'] ?? '' }}"
                                        class="form-control telefone @error('contatos.'.$i.'.telefone') is-invalid @enderror"
                                        placeholder="(00) 00000-0000"
                                        inputmode="numeric"
                                        required>
                                    @error('contatos.'.$i.'.telefone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold">Parentesco (opcional)</label>
                                    <input type="text"
                                        name="contatos[{{ $i }}][parentesco]"
                                        value="{{ $c['parentesco'] ?? '' }}"
                                        class="form-control"
                                        placeholder="Ex.: Filho, Filha, Cuidador, Irmão...">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-2">
                    <button type="button" class="btn btn-outline-primary rounded-3" id="btn-add-contato">
                        <i class="bi bi-person-plus me-1"></i> Adicionar outro contato
                    </button>

                    <div class="text-muted small">
                        Dica: inclua um segundo contato caso o primeiro não atenda.
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-between gap-2 flex-wrap">
                    <a href="{{ route('idosos.create.step3', $idoso->id) }}"
                    class="btn btn-outline-secondary px-4 rounded-3">
                        <i class="bi bi-arrow-left me-1"></i> Voltar
                    </a>

                    <button type="submit" class="btn btn-primary px-4 rounded-3">
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
    const wrapper = document.getElementById('contatos-wrapper');
    const btnAdd = document.getElementById('btn-add-contato');

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
            inp.removeEventListener('input', inp._maskHandler || (() => {}));
            const handler = () => inp.value = maskPhone(inp.value);
            inp._maskHandler = handler;
            inp.addEventListener('input', handler);
            inp.value = maskPhone(inp.value);
        });
    }

    function reindexContatos() {
        const items = wrapper.querySelectorAll('.contato-item');

        items.forEach((item, index) => {
            item.querySelectorAll('input').forEach(input => {
                input.name = input.name.replace(/contatos\[\d+\]/, `contatos[${index}]`);
            });

            const title = item.querySelector('.contato-title');
            const hint = item.querySelector('.text-muted.small');

            if (index === 0) {
                item.classList.add('bg-light');
                item.classList.remove('position-relative');
                title.innerHTML = 'Contato principal <span class="badge bg-warning text-dark ms-2">Obrigatório</span>';
                if (hint) hint.textContent = 'Avisado primeiro';
            } else {
                item.classList.remove('bg-light');
                item.classList.add('position-relative');
                title.innerHTML = 'Contato adicional';
                if (hint) hint.textContent = '';
            }

            let removeBtn = item.querySelector('.btn-remove-contato');
            if (index === 0) {
                if (removeBtn) removeBtn.remove();
            } else if (!removeBtn) {
                removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-2 btn-remove-contato';
                removeBtn.innerHTML = '<i class="bi bi-x-lg"></i>';
                item.prepend(removeBtn);
            }
        });

        applyPhoneMask(wrapper);
    }

    btnAdd?.addEventListener('click', () => {
        const index = wrapper.querySelectorAll('.contato-item').length;

        const html = `
            <div class="contato-item border rounded-4 p-3 mb-3 position-relative">
                <button type="button"
                        class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-2 btn-remove-contato">
                    <i class="bi bi-x-lg"></i>
                </button>

                <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-2">
                    <div class="fw-bold contato-title">Contato adicional</div>
                    <div class="text-muted small"></div>
                </div>

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
        reindexContatos();
    });

    wrapper?.addEventListener('click', (e) => {
        const btn = e.target.closest('.btn-remove-contato');
        if (!btn) return;

        const items = wrapper.querySelectorAll('.contato-item');
        if (items.length <= 1) {
            alert('É obrigatório manter pelo menos 1 contato.');
            return;
        }

        btn.closest('.contato-item')?.remove();
        reindexContatos();
    });

    applyPhoneMask(document);
})();
</script>
@endpush

@endsection