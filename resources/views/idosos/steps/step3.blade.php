@php $step = 3; @endphp
@extends('layouts.wizard')

@section('wizard-content')

<form method="POST" action="{{ route('idosos.store.step3', $idoso->id) }}">
    @csrf

    <!-- Cartão SUS -->
    <div class="mb-3">
        <label class="form-label">Cartão do SUS</label>
        <input type="text"
               name="cartao_sus"
               value="{{ old('cartao_sus') }}"
               class="form-control @error('cartao_sus') is-invalid @enderror">

        @error('cartao_sus')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <!-- Plano de Saúde -->
    <div class="mb-3">
        <label class="form-label">Plano de Saúde</label>
        <input type="text"
               name="plano_saude"
               value="{{ old('plano_saude') }}"
               class="form-control @error('plano_saude') is-invalid @enderror">

        @error('plano_saude')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <!-- Número do Plano -->
    <div class="mb-3">
        <label class="form-label">Número do Plano</label>
        <input type="text"
               name="numero_plano"
               value="{{ old('numero_plano') }}"
               class="form-control @error('numero_plano') is-invalid @enderror">

        @error('numero_plano')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <!-- Tipo Sanguíneo -->
    <div class="mb-3">
        <label class="form-label">Tipo Sanguíneo</label>
        <select name="tipo_sanguineo"
                class="form-control @error('tipo_sanguineo') is-invalid @enderror">
            <option value="">Selecione</option>
            <option value="A+" {{ old('tipo_sanguineo') == 'A+' ? 'selected' : '' }}>A+</option>
            <option value="A-">A-</option>
            <option value="B+">B+</option>
            <option value="B-">B-</option>
            <option value="AB+">AB+</option>
            <option value="AB-">AB-</option>
            <option value="O+">O+</option>
            <option value="O-">O-</option>
        </select>

        @error('tipo_sanguineo')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <!-- Alergias -->
    <div class="mb-3">
        <label class="form-label">Alergias</label>
        <textarea name="alergias"
                  class="form-control @error('alergias') is-invalid @enderror"
                  rows="2">{{ old('alergias') }}</textarea>

        @error('alergias')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <!-- Doenças Crônicas -->
    <div class="mb-3">
        <label class="form-label">Doenças Crônicas</label>
        <textarea name="doencas_cronicas"
                  class="form-control @error('doencas_cronicas') is-invalid @enderror"
                  rows="2">{{ old('doencas_cronicas') }}</textarea>

        @error('doencas_cronicas')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <!-- Restrições -->
    <div class="mb-4">
        <label class="form-label">Restrições / Observações Médicas</label>
        <textarea name="restricoes"
                  class="form-control @error('restricoes') is-invalid @enderror"
                  rows="2">{{ old('restricoes') }}</textarea>

        @error('restricoes')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <!-- Botões -->
    <div class="d-flex justify-content-between mt-4">

        <a href="{{ route('idosos.create.step2', $idoso->id) }}"
           class="btn btn-outline-secondary px-4">
            ← Voltar
        </a>

        <button type="submit"
                class="btn btn-primary px-4">
            Próximo →
        </button>

    </div>

</form>

@endsection