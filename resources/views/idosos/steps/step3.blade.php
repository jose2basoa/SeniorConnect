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
        <div class="progress-bar" style="width: 75%;" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger d-flex align-items-start gap-2">
            <i class="bi bi-exclamation-triangle mt-1"></i>
            <div>
                <strong>Ops!</strong> Revise os campos destacados.
            </div>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">

            <form method="POST" action="{{ route('idosos.store.step3', $idoso->id) }}" novalidate>
                @csrf

                <div class="row g-3">

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Cartão do SUS (opcional)</label>
                        <input type="text"
                               name="cartao_sus"
                               value="{{ old('cartao_sus', $clinico->cartao_sus ?? '') }}"
                               class="form-control @error('cartao_sus') is-invalid @enderror"
                               inputmode="numeric"
                               id="cartao_sus"
                               placeholder="Ex.: 000 0000 0000 0000">
                        @error('cartao_sus')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Se preferir, pode deixar em branco.</div>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Tipo sanguíneo (opcional)</label>
                        @php $tipo = old('tipo_sanguineo', $clinico->tipo_sanguineo ?? ''); @endphp
                        <select name="tipo_sanguineo" class="form-select @error('tipo_sanguineo') is-invalid @enderror">
                            <option value="">Não sei / Não informar</option>
                            @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $t)
                                <option value="{{ $t }}" {{ $tipo === $t ? 'selected' : '' }}>{{ $t }}</option>
                            @endforeach
                        </select>
                        @error('tipo_sanguineo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Plano de saúde (opcional)</label>
                        <input type="text"
                               name="plano_saude"
                               value="{{ old('plano_saude', $clinico->plano_saude ?? '') }}"
                               class="form-control @error('plano_saude') is-invalid @enderror"
                               placeholder="Ex.: Unimed, Bradesco Saúde...">
                        @error('plano_saude')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Número do plano (opcional)</label>
                        <input type="text"
                               name="numero_plano"
                               value="{{ old('numero_plano', $clinico->numero_plano ?? '') }}"
                               class="form-control @error('numero_plano') is-invalid @enderror"
                               placeholder="Ex.: 123456789">
                        @error('numero_plano')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Alergias (opcional)</label>
                        <textarea name="alergias"
                                  class="form-control @error('alergias') is-invalid @enderror"
                                  rows="2"
                                  placeholder="Ex.: dipirona, frutos do mar...">{{ old('alergias', $clinico->alergias ?? '') }}</textarea>
                        @error('alergias')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Doenças crônicas (opcional)</label>
                        <textarea name="doencas_cronicas"
                                  class="form-control @error('doencas_cronicas') is-invalid @enderror"
                                  rows="2"
                                  placeholder="Ex.: hipertensão, diabetes...">{{ old('doencas_cronicas', $clinico->doencas_cronicas ?? '') }}</textarea>
                        @error('doencas_cronicas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Restrições / observações médicas (opcional)</label>
                        <textarea name="restricoes"
                                  class="form-control @error('restricoes') is-invalid @enderror"
                                  rows="2"
                                  placeholder="Ex.: dieta sem sal, risco de queda, usa prótese...">{{ old('restricoes', $clinico->restricoes ?? '') }}</textarea>
                        @error('restricoes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
(function(){
    const sus = document.getElementById('cartao_sus');
    const onlyDigits = (v) => (v || "").replace(/\D/g,'');
    function maskSUS(v){
        v = onlyDigits(v).slice(0,15);
        // 000 0000 0000 0000 (simples)
        return v.replace(/(\d{3})(\d)/, '$1 $2')
                .replace(/(\d{4})(\d)/, '$1 $2')
                .replace(/(\d{4})(\d)/, '$1 $2');
    }
    if (sus) {
        sus.addEventListener('input', () => sus.value = maskSUS(sus.value));
        sus.value = maskSUS(sus.value);
    }
})();
</script>
@endpush

@endsection