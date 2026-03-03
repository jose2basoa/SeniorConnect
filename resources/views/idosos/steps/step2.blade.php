@php $step = 2; @endphp
@extends('layouts.wizard')

@section('wizard-content')

<form method="POST" action="{{ route('idosos.store.step2', $idoso->id) }}">
    @csrf

    <div class="mb-3">
        <label class="form-label">CEP</label>
        <input type="text" name="cep" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Rua</label>
        <input type="text" name="rua" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Número</label>
        <input type="text" name="numero" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Complemento</label>
        <input type="text" name="complemento" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Bairro</label>
        <input type="text" name="bairro" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Cidade</label>
        <input type="text" name="cidade" class="form-control">
    </div>

    <div class="mb-4">
        <label class="form-label">Estado</label>
        <input type="text" name="estado" class="form-control">
    </div>

    <div class="d-flex justify-content-between">

        <!-- Botão Voltar -->
        <a href="{{ route('idosos.create.step1') }}" 
           class="btn btn-outline-secondary">
            ← Voltar
        </a>

        <!-- Botão Próximo -->
        <button type="submit" class="btn btn-primary">
            Próximo →
        </button>

    </div>

</form>

@endsection