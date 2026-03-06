@extends('layouts.app')

@section('content')
<div class="container py-5">

    <div class="row justify-content-center mb-5">
        <div class="col-lg-8 text-center">
            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 mb-3">
                Início do acompanhamento
            </span>

            <h2 class="fw-bold mb-3">Como você deseja começar?</h2>

            <p class="text-muted mb-0">
                Você pode vincular uma pessoa que já possui cadastro no sistema
                ou iniciar um novo cadastro em etapas.
            </p>
        </div>
    </div>

    <div class="row justify-content-center g-4">
        <div class="col-md-5">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body p-4 text-center">
                    <div class="fs-1 text-primary mb-3">
                        <i class="bi bi-link-45deg"></i>
                    </div>

                    <h5 class="fw-bold mb-2">Vincular cadastro existente</h5>

                    <p class="text-muted small mb-4">
                        Use esta opção quando a pessoa já estiver cadastrada no sistema
                        e você quiser apenas associá-la à sua conta.
                    </p>

                    <a href="{{ route('idosos.vincular') }}" class="btn btn-primary w-100 rounded-3">
                        <i class="bi bi-search me-1"></i> Vincular cadastro
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body p-4 text-center">
                    <div class="fs-1 text-success mb-3">
                        <i class="bi bi-person-plus"></i>
                    </div>

                    <h5 class="fw-bold mb-2">Criar novo cadastro</h5>

                    <p class="text-muted small mb-4">
                        Comece um novo registro com dados pessoais, endereço,
                        informações clínicas e contatos de emergência.
                    </p>

                    <a href="{{ route('idosos.create.step1') }}" class="btn btn-outline-primary w-100 rounded-3">
                        <i class="bi bi-plus-circle me-1"></i> Novo cadastro
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-5">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary rounded-3">
            <i class="bi bi-arrow-left me-1"></i> Voltar ao painel
        </a>
    </div>

</div>
@endsection