@extends('layouts.public')

@section('content')

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow fixed-top">
    <div class="container">

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">

            <a class="navbar-brand fw-bold" href="{{ auth()->check() ? route('dashboard') : url('/') }}">
                Sênior Conecta
            </a>

            <!-- LINKS LANDING PAGE -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-white" href="#funcionalidades">Funcionalidades</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white" href="#tecnologia">Tecnologia</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white" href="#como-funciona">Como Funciona</a>
                </li>
            </ul>

            <!-- AREA USUÁRIO -->
            <div class="d-flex align-items-center gap-3">

                @auth

                    {{-- Links Admin --}}
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-sm">
                            Painel Admin
                        </a>

                        <a href="{{ route('admin.users') }}" class="btn btn-outline-light btn-sm">
                            Usuários
                        </a>

                        <a href="{{ route('admin.idosos') }}" class="btn btn-outline-light btn-sm">
                            Idosos
                        </a>
                    @endif

                    <span class="text-white">
                        {{ auth()->user()->name }}
                    </span>

                    <a href="{{ route('profile.edit') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-person-circle"></i>
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-light btn-sm">
                            Sair
                        </button>
                    </form>

                @endauth

                @guest
                    <a href="{{ route('login') }}" class="btn btn-light btn-sm">
                        Login
                    </a>

                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-sm">
                        Criar Conta
                    </a>
                @endguest

            </div>

        </div>
    </div>
</nav>

<div style="margin-top:80px;"></div>

<!-- HERO -->
<section class="bg-light py-5 text-center">
    <div class="container">
        <h1 class="display-5 fw-bold mb-3">
            Monitoramento Inteligente e Assistência Remota para Idosos
        </h1>
        <p class="lead text-muted mb-4">
            Plataforma integrada com aplicativo mobile, portal web e protocolos automatizados de emergência.
        </p>
        <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-4 me-2">
            Começar Agora
        </a>
        <a href="#funcionalidades" class="btn btn-outline-secondary btn-lg">
            Saiba Mais
        </a>
    </div>
</section>

<!-- SOBRE O PROJETO -->
<section class="py-5">
    <div class="container text-center">
        <h2 class="fw-bold mb-4">Sobre o Projeto</h2>
        <p class="text-muted col-md-8 mx-auto">
            O Sênior Conecta é um sistema desenvolvido para promover segurança,
            autonomia e monitoramento contínuo de idosos. Utiliza sensores do smartphone,
            geolocalização e protocolos automáticos para reduzir o tempo de resposta
            em situações críticas.
        </p>
    </div>
</section>

<!-- FUNCIONALIDADES -->
<section id="funcionalidades" class="bg-light py-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">Principais Funcionalidades</h2>

        <div class="row g-4">

            <div class="col-md-4">
                <div class="card shadow border-0 h-100 text-center p-3">
                    <h5 class="fw-bold">Dashboard em Tempo Real</h5>
                    <p class="text-muted">
                        Visualização instantânea de eventos, quedas, alertas e status online.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow border-0 h-100 text-center p-3">
                    <h5 class="fw-bold">Detecção de Quedas</h5>
                    <p class="text-muted">
                        Uso de acelerômetro e giroscópio para identificar variações bruscas.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow border-0 h-100 text-center p-3">
                    <h5 class="fw-bold">Protocolo Automático</h5>
                    <p class="text-muted">
                        Tentativas progressivas de contato e envio de localização.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- TECNOLOGIA -->
<section id="tecnologia" class="py-5">
    <div class="container text-center">
        <h2 class="fw-bold mb-4">Tecnologia Utilizada</h2>

        <div class="row">
            <div class="col-md-3">
                <p><strong>Mobile:</strong><br>Flutter / React Native</p>
            </div>
            <div class="col-md-3">
                <p><strong>Backend:</strong><br>Node.js / API REST</p>
            </div>
            <div class="col-md-3">
                <p><strong>Banco de Dados:</strong><br>Firestore / PostgreSQL</p>
            </div>
            <div class="col-md-3">
                <p><strong>Segurança:</strong><br>HTTPS, JWT, LGPD</p>
            </div>
        </div>
    </div>
</section>

<!-- COMO FUNCIONA -->
<section id="como-funciona" class="bg-light py-5">
    <div class="container text-center">
        <h2 class="fw-bold mb-5">Como Funciona</h2>

        <div class="row">
            <div class="col-md-4">
                <h5 class="fw-bold">1️⃣ Aplicativo do Idoso</h5>
                <p class="text-muted">
                    Coleta dados de sensores e envia eventos automaticamente.
                </p>
            </div>

            <div class="col-md-4">
                <h5 class="fw-bold">2️⃣ Processamento Inteligente</h5>
                <p class="text-muted">
                    A API valida informações e executa protocolos.
                </p>
            </div>

            <div class="col-md-4">
                <h5 class="fw-bold">3️⃣ Portal do Tutor</h5>
                <p class="text-muted">
                    Permite monitoramento, resposta rápida e histórico completo.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- CTA FINAL -->
<section class="bg-primary text-white text-center py-5">
    <div class="container">
        <h3 class="fw-bold mb-3">
            Mais segurança, mais tranquilidade, mais cuidado.
        </h3>
        <a href="{{ route('register') }}" class="btn btn-light btn-lg">
            Criar Conta Gratuitamente
        </a>
    </div>
</section>

<!-- FOOTER -->
<footer class="bg-dark text-white text-center py-4">
    <div class="container">
        <p class="mb-1">
            © {{ date('Y') }} Sênior Conecta
        </p>
        <small>
            Desenvolvido por José Basoa e Paulo Palhuzi.
            Todos os direitos reservados.
        </small>
    </div>
</footer>

@endsection
