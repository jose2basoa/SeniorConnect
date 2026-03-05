@extends('layouts.app')

@section('content')

<style>
  section { scroll-margin-top: 90px; }
</style>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2"
           href="{{ auth()->check() ? route('dashboard') : url('/') }}">
            <i class="bi bi-shield-check"></i>
            Sênior Conecta
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">

            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link text-white" href="#beneficios">Benefícios</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#funcionalidades">Funcionalidades</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#como-funciona">Como funciona</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#depoimentos">Relatos</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#faq">Dúvidas</a></li>
            </ul>

            <div class="d-flex align-items-center gap-2">

                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-sm">
                            Painel Admin
                        </a>
                    @endif

                    <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-speedometer2 me-1"></i> Painel
                    </a>

                    <a href="{{ route('profile.edit') }}" class="btn btn-light btn-sm d-flex align-items-center gap-2">
                        <i class="bi bi-person-circle"></i>
                        <span class="d-none d-lg-inline">{{ auth()->user()->name }}</span>
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button class="btn btn-light btn-sm">Sair</button>
                    </form>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="btn btn-light btn-sm">
                        Entrar
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-sm">
                        Criar conta
                    </a>
                @endguest

            </div>
        </div>
    </div>
</nav>

<div style="margin-top:80px;"></div>

<!-- HERO -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center g-4">

            <div class="col-lg-6">
                <span class="badge bg-primary-subtle text-primary mb-3">
                    Segurança e cuidado em tempo real
                </span>

                <h1 class="display-6 fw-bold mb-3">
                    Monitoramento inteligente e assistência remota para quem precisa de acompanhamento.
                </h1>

                <p class="lead text-muted mb-4">
                    Acompanhe alertas, rotinas e sinais de risco com rapidez — com um painel simples,
                    pensado para familiares, cuidadores e tutores.
                </p>

                <div class="d-flex flex-wrap gap-2">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">
                            Acessar meu painel
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                            Criar conta grátis
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-lg">
                            Já tenho conta
                        </a>
                    @endauth
                </div>

                <div class="d-flex flex-wrap gap-3 mt-4 text-muted">
                    <small><i class="bi bi-lightning-charge me-1"></i> Alertas rápidos</small>
                    <small><i class="bi bi-geo-alt me-1"></i> Localização</small>
                    <small><i class="bi bi-bell me-1"></i> Notificações</small>
                </div>
            </div>

            <div class="col-lg-6 text-center">
                <!-- Placeholder visual (pode trocar por print do dashboard depois) -->
                <div class="card shadow border-0 rounded-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <strong>Painel de Monitoramento</strong>
                            <span class="badge bg-success">Online</span>
                        </div>
                        <div class="bg-light rounded-3 p-3 text-start">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Última atividade</span>
                                <span class="fw-semibold">agora</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Alertas</span>
                                <span class="fw-semibold text-danger">2</span>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <span class="text-muted">Próximo medicamento</span>
                                <span class="fw-semibold">08:00</span>
                            </div>
                        </div>

                        <small class="text-muted d-block mt-3">
                            (Exemplo ilustrativo — depois você pode colocar um print real do seu dashboard)
                        </small>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- BENEFÍCIOS -->
<section id="beneficios" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Benefícios pensados para o dia a dia</h2>
            <p class="text-muted col-md-8 mx-auto">
                A ideia é reduzir ansiedade, agilizar decisões e trazer mais tranquilidade para quem cuida.
            </p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 rounded-4">
                    <div class="card-body p-4">
                        <div class="mb-3 fs-3 text-primary"><i class="bi bi-shield-check"></i></div>
                        <h5 class="fw-bold">Mais segurança</h5>
                        <p class="text-muted mb-0">
                            Alertas e registros para acompanhar situações fora do padrão com rapidez.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 rounded-4">
                    <div class="card-body p-4">
                        <div class="mb-3 fs-3 text-primary"><i class="bi bi-activity"></i></div>
                        <h5 class="fw-bold">Mais autonomia</h5>
                        <p class="text-muted mb-0">
                            Rotinas e acompanhamento sem invadir a privacidade — do jeito certo.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 rounded-4">
                    <div class="card-body p-4">
                        <div class="mb-3 fs-3 text-primary"><i class="bi bi-clock-history"></i></div>
                        <h5 class="fw-bold">Resposta mais rápida</h5>
                        <p class="text-muted mb-0">
                            Organização + histórico + notificações para agir sem perder tempo.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FUNCIONALIDADES -->
<section id="funcionalidades" class="bg-light py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Funcionalidades principais</h2>
            <p class="text-muted col-md-8 mx-auto">
                Tudo em um painel simples para monitorar, registrar e agir.
            </p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card shadow border-0 h-100 rounded-4">
                    <div class="card-body p-4 text-center">
                        <div class="fs-2 text-primary mb-2"><i class="bi bi-speedometer2"></i></div>
                        <h5 class="fw-bold">Dashboard em tempo real</h5>
                        <p class="text-muted mb-0">Eventos, alertas e status com visualização rápida.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow border-0 h-100 rounded-4">
                    <div class="card-body p-4 text-center">
                        <div class="fs-2 text-primary mb-2"><i class="bi bi-exclamation-triangle"></i></div>
                        <h5 class="fw-bold">Alertas e ocorrências</h5>
                        <p class="text-muted mb-0">Registro de incidentes, acompanhamento e resolução.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow border-0 h-100 rounded-4">
                    <div class="card-body p-4 text-center">
                        <div class="fs-2 text-primary mb-2"><i class="bi bi-geo-alt"></i></div>
                        <h5 class="fw-bold">Localização</h5>
                        <p class="text-muted mb-0">Acompanhe a última localização disponível com segurança.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- COMO FUNCIONA -->
<section id="como-funciona" class="py-5">
    <div class="container text-center">
        <h2 class="fw-bold mb-5">Como funciona</h2>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="p-4 border rounded-4 h-100">
                    <div class="fs-2 text-primary mb-2">1</div>
                    <h5 class="fw-bold">Cadastro e vínculo</h5>
                    <p class="text-muted mb-0">Tutor cria conta e vincula o perfil acompanhado com segurança.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-4 border rounded-4 h-100">
                    <div class="fs-2 text-primary mb-2">2</div>
                    <h5 class="fw-bold">Monitoramento</h5>
                    <p class="text-muted mb-0">Eventos e rotinas ficam registrados e visíveis no painel.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-4 border rounded-4 h-100">
                    <div class="fs-2 text-primary mb-2">3</div>
                    <h5 class="fw-bold">Ação rápida</h5>
                    <p class="text-muted mb-0">Em situação de risco, o tutor recebe alertas e pode agir.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- DEPOIMENTOS -->
<section id="depoimentos" class="bg-light py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Relatos de quem usa</h2>
            <p class="text-muted col-md-8 mx-auto">
                Uma experiência mais humana — com foco em tranquilidade para famílias e cuidadores.
            </p>
        </div>

        <div class="row g-4">
            @php
                // dados mockados (depois você pode puxar do banco)
                $depoimentos = [
                    [
                        'nome' => 'Mariana S.',
                        'papel' => 'Filha / Tutora',
                        'foto' => 'https://i.pravatar.cc/150?img=47',
                        'texto' => 'O painel me ajudou a acompanhar a rotina com mais calma. O histórico de alertas facilita muito.'
                    ],
                    [
                        'nome' => 'Carlos R.',
                        'papel' => 'Cuidador',
                        'foto' => 'https://i.pravatar.cc/150?img=12',
                        'texto' => 'Antes eu anotava tudo no papel. Agora fica organizado e dá para consultar rapidinho.'
                    ],
                    [
                        'nome' => 'Ana P.',
                        'papel' => 'Familiar',
                        'foto' => 'https://i.pravatar.cc/150?img=32',
                        'texto' => 'A sensação é de mais segurança. Mesmo longe, eu sei quando algo foge do normal.'
                    ],
                ];
            @endphp

            @foreach($depoimentos as $d)
                <div class="col-md-4">
                    <div class="card shadow border-0 h-100 rounded-4">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <img src="{{ $d['foto'] }}" alt="Foto de {{ $d['nome'] }}"
                                     class="rounded-circle" width="52" height="52">
                                <div class="text-start">
                                    <div class="fw-bold">{{ $d['nome'] }}</div>
                                    <small class="text-muted">{{ $d['papel'] }}</small>
                                </div>
                            </div>

                            <p class="text-muted mb-0">
                                “{{ $d['texto'] }}”
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- FORM COMENTÁRIO -->
        <div class="row justify-content-center mt-5">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Deixe um comentário</h5>

                        {{-- Depois você cria route('comentarios.store') e salva no banco --}}
                        <form method="POST" action="#">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Seu nome</label>
                                    <input type="text" name="nome" class="form-control" placeholder="Ex: João" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">E-mail (opcional)</label>
                                    <input type="email" name="email" class="form-control" placeholder="nome@dominio.com">
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Comentário</label>
                                    <textarea name="mensagem" class="form-control" rows="4"
                                              placeholder="Conte como você imagina que o sistema pode ajudar..."
                                              required></textarea>
                                </div>

                                <div class="col-12 d-flex justify-content-end">
                                    <button class="btn btn-primary">
                                        Enviar comentário
                                    </button>
                                </div>
                            </div>
                        </form>

                        <small class="text-muted d-block mt-2">
                            * Comentários podem aparecer publicamente após revisão.
                        </small>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- FAQ -->
<section id="faq" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Dúvidas comuns</h2>
            <p class="text-muted col-md-8 mx-auto">
                Respostas rápidas para entender o funcionamento e o que esperar do sistema.
            </p>
        </div>

        <div class="accordion accordion-flush" id="faqAccordion">

            <!-- 1 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="h1">
                    <button class="accordion-button collapsed" type="button"
                            data-bs-toggle="collapse" data-bs-target="#c1"
                            aria-expanded="false" aria-controls="c1">
                        O sistema é só para idosos?
                    </button>
                </h2>
                <div id="c1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion" aria-labelledby="h1">
                    <div class="accordion-body text-muted">
                        Não. Apesar do nome e do foco inicial, o Sênior Conecta pode ser usado por qualquer pessoa que
                        precise de acompanhamento: pessoas com deficiência (PCD), pessoas em reabilitação,
                        com mobilidade reduzida ou que necessitem de supervisão em rotinas específicas.
                        A ideia é oferecer uma forma segura e simples de monitorar e agir em situações importantes.
                    </div>
                </div>
            </div>

            <!-- 2 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="h2">
                    <button class="accordion-button collapsed" type="button"
                            data-bs-toggle="collapse" data-bs-target="#c2"
                            aria-expanded="false" aria-controls="c2">
                        Precisa de conhecimento técnico para usar?
                    </button>
                </h2>
                <div id="c2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion" aria-labelledby="h2">
                    <div class="accordion-body text-muted">
                        Não. O sistema foi pensado para o público geral, com interface simples e organizada.
                        O tutor consegue ver o que precisa em poucos cliques: status, alertas, histórico e dados principais.
                        A proposta é reduzir complicação — sem telas confusas, sem excesso de informação,
                        e com linguagem fácil para qualquer pessoa entender.
                    </div>
                </div>
            </div>

            <!-- 3 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="h3">
                    <button class="accordion-button collapsed" type="button"
                            data-bs-toggle="collapse" data-bs-target="#c3"
                            aria-expanded="false" aria-controls="c3">
                        Como os alertas funcionam na prática?
                    </button>
                </h2>
                <div id="c3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion" aria-labelledby="h3">
                    <div class="accordion-body text-muted">
                        O sistema registra eventos e pode gerar alertas quando algo foge do padrão,
                        como falta de resposta em checagens, alterações em rotina, ou situações que indiquem risco.
                        Os alertas aparecem no painel do tutor com data e horário, e podem ser acompanhados
                        até serem resolvidos. Assim, além de avisar, o sistema ajuda a organizar a resposta
                        e manter histórico para consultas futuras.
                    </div>
                </div>
            </div>

            <!-- 4 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="h4">
                    <button class="accordion-button collapsed" type="button"
                            data-bs-toggle="collapse" data-bs-target="#c4"
                            aria-expanded="false" aria-controls="c4">
                        O sistema substitui atendimento médico ou emergência?
                    </button>
                </h2>
                <div id="c4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion" aria-labelledby="h4">
                    <div class="accordion-body text-muted">
                        Não. O objetivo é apoiar o acompanhamento e agilizar decisões, mas não substituir profissionais.
                        O Sênior Conecta ajuda a identificar sinais de atenção, registrar ocorrências e facilitar a ação do tutor.
                        Em situações graves, o ideal é sempre acionar serviços de emergência e buscar orientação médica.
                        Pense no sistema como um “apoio inteligente” para aumentar a segurança e reduzir o tempo de reação.
                    </div>
                </div>
            </div>

            <!-- 5 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="h5">
                    <button class="accordion-button collapsed" type="button"
                            data-bs-toggle="collapse" data-bs-target="#c5"
                            aria-expanded="false" aria-controls="c5">
                        Os dados são protegidos? Como funciona a privacidade?
                    </button>
                </h2>
                <div id="c5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion" aria-labelledby="h5">
                    <div class="accordion-body text-muted">
                        Sim. A proposta do projeto segue boas práticas de segurança e privacidade:
                        acesso por login, separação de perfis (tutor/admin), e uso responsável de informações sensíveis.
                        Dados como localização e registros de eventos devem ser tratados com cuidado,
                        exibidos apenas para quem tem permissão, e armazenados de forma segura.
                        A ideia é manter transparência e controle: o tutor sabe o que está sendo registrado e por quê,
                        sempre respeitando a privacidade de quem está sendo acompanhado.
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- CTA FINAL -->
<section class="bg-primary text-white text-center py-5">
    <div class="container">
        @auth
            <h3 class="fw-bold mb-3">
                Bem-vindo de volta! Acompanhe tudo pelo seu painel.
            </h3>
            <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg">
                Acessar meu painel
            </a>
        @else
            <h3 class="fw-bold mb-3">
                Mais segurança, mais tranquilidade, mais cuidado.
            </h3>
            <p class="mb-4 opacity-75">
                Crie sua conta e comece a organizar o acompanhamento de forma simples.
            </p>
            <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                Criar conta gratuitamente
            </a>
        @endauth
    </div>
</section>

<!-- FOOTER -->
<footer class="bg-dark text-white text-center py-4">
    <div class="container">
        <p class="mb-1">
            © {{ date('Y') }} Sênior Conecta
        </p>
        <small class="opacity-75">
            Desenvolvido por José Basoa e Paulo Palhuzi.
            Todos os direitos reservados.
        </small>
    </div>
</footer>

@endsection