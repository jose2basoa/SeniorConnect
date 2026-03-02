@extends('layouts.public')

@section('content')

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="#">
            Sênior Conecta
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="#funcionalidades">Funcionalidades</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#como-funciona">Como Funciona</a>
                </li>

                @guest
                    <li class="nav-item ms-3">
                        <a href="{{ route('login') }}" class="btn btn-outline-primary">
                            Login
                        </a>
                    </li>
                    <li class="nav-item ms-2">
                        <a href="{{ route('register') }}" class="btn btn-primary">
                            Criar Conta
                        </a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<!-- HERO -->
<section class="bg-light py-5 text-center">
    <div class="container">
        <h1 class="display-5 fw-bold mb-3">
            Monitoramento Inteligente para Idosos
        </h1>
        <p class="lead text-muted mb-4">
            Segurança, assistência remota e protocolos automáticos de emergência.
        </p>
        <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-4">
            Começar Agora
        </a>
    </div>
</section>

<!-- POR QUE -->
<section class="py-5">
    <div class="container text-center">
        <h2 class="fw-bold mb-4">Por que o Sênior Conecta?</h2>
        <p class="text-muted col-md-8 mx-auto">
            O crescimento da população idosa exige soluções tecnológicas que garantam
            monitoramento contínuo, detecção de quedas e acionamento automático de emergência.
        </p>
    </div>
</section>

<!-- FUNCIONALIDADES -->
<section id="funcionalidades" class="bg-light py-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">Funcionalidades</h2>

        <div class="row g-4">

            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100 text-center">
                    <div class="card-body">
                        <h5 class="fw-bold">Dashboard Inteligente</h5>
                        <p class="text-muted">
                            Visualização de eventos, quedas e alertas em tempo real.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100 text-center">
                    <div class="card-body">
                        <h5 class="fw-bold">Monitoramento por Sensores</h5>
                        <p class="text-muted">
                            Uso de acelerômetro, giroscópio e GPS.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100 text-center">
                    <div class="card-body">
                        <h5 class="fw-bold">Protocolo de Emergência</h5>
                        <p class="text-muted">
                            Acionamento automático com notificações e localização.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- COMO FUNCIONA -->
<section id="como-funciona" class="py-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">Como Funciona</h2>

        <div class="row text-center">
            <div class="col-md-4">
                <h5 class="fw-bold">1. App do Idoso</h5>
                <p class="text-muted">Coleta dados e detecta eventos.</p>
            </div>
            <div class="col-md-4">
                <h5 class="fw-bold">2. Processamento na API</h5>
                <p class="text-muted">Validação e execução do protocolo.</p>
            </div>
            <div class="col-md-4">
                <h5 class="fw-bold">3. Portal do Tutor</h5>
                <p class="text-muted">Visualização e resposta rápida.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA FINAL -->
<section class="bg-primary text-white text-center py-5">
    <div class="container">
        <h3 class="fw-bold mb-3">
            Garanta mais segurança para quem você ama
        </h3>
        <a href="{{ route('register') }}" class="btn btn-light btn-lg">
            Criar Conta Gratuitamente
        </a>
    </div>
</section>

<!-- FOOTER -->
<footer class="bg-dark text-white text-center py-3">
    © {{ date('Y') }} Sênior Conecta - Todos os direitos reservados.
</footer>

@endsection
