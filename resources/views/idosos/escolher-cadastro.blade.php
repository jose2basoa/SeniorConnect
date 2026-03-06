@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="text-center mb-5">
        <h3 class="fw-bold">Vincular pessoa ao sistema</h3>

        <p class="text-muted mt-3">
            Esta pessoa já possui cadastro no sistema ou será o primeiro registro?
        </p>
    </div>

    <div class="row justify-content-center g-4">

        <div class="col-md-4">
            <div class="card shadow-sm h-100 text-center p-4">
                <h5 class="mb-3">Já possui cadastro</h5>

                <p class="text-muted small">
                    Caso a pessoa já esteja cadastrada, você pode apenas vinculá-la
                    à sua conta para começar o acompanhamento.
                </p>

                <a href="{{ route('idosos.vincular') }}"
                    class="btn btn-primary mt-3">
                    Vincular cadastro existente
                </a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm h-100 text-center p-4">
                <h5 class="mb-3">Novo cadastro</h5>

                <p class="text-muted small">
                    Se ainda não houver cadastro, você pode registrar as
                    informações iniciais para começar o acompanhamento.
                </p>

                <a href="{{ route('idosos.create.step1') }}"
                    class="btn btn-outline-primary mt-3">
                    Fazer novo cadastro
                </a>
            </div>
        </div>

    </div>

    {{-- Botão voltar --}}
    <div class="text-center mt-5">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Voltar ao painel
        </a>
    </div>

</div>

@endsection