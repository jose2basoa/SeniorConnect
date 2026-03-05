@php $step = 1; @endphp

@extends('layouts.wizard')

@section('wizard-content')

<form method="POST" action="{{ route('idosos.store.step1') }}">
    @csrf

    <div class="mb-3">
        <label class="form-label">Nome Completo *</label>
        <input type="text" name="nome" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Data de Nascimento *</label>
        <input type="date" name="data_nascimento" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Sexo</label>
        <select name="sexo" class="form-control">
            <option value="">Selecione</option>
            <option value="Masculino">Masculino</option>
            <option value="Feminino">Feminino</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">CPF</label>
        <input type="text" name="cpf" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Telefone</label>
        <input type="text" name="telefone" class="form-control">
    </div>

    <div class="mb-4">
        <label class="form-label">Observações</label>
        <textarea name="observacoes" class="form-control"></textarea>
    </div>


    <div class="d-flex justify-content-between mt-4">

        <!-- Botão Voltar -->
        <a href="{{ route('idosos.cadastrar') }}"
        class="btn btn-outline-secondary px-4">
            ← Voltar
        </a>

        <!-- Botão Próximo -->
        <button type="submit"
                class="btn btn-primary px-4">
            Próximo →
        </button>

    </div>

</form>

@endsection
