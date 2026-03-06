@extends('layouts.app')

@section('content')

<!-- HERO -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center g-5">

            <div class="col-lg-6">
                <span class="badge bg-primary-subtle text-primary mb-3 px-3 py-2 rounded-pill">
                    Segurança e cuidado em tempo real
                </span>

                <h1 class="display-5 fw-bold mb-3">
                    Um painel claro, moderno e prático para acompanhar quem mais importa.
                </h1>

                <p class="lead text-muted mb-4">
                    O Sênior Conecta reúne alertas, medicamentos, eventos, contatos e status de monitoramento
                    em um só lugar, facilitando a rotina de familiares, cuidadores e tutores.
                </p>

                <div class="d-flex flex-wrap gap-2">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg px-4">
                            Acessar meu painel
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-4">
                            Criar conta grátis
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-lg px-4">
                            Já tenho conta
                        </a>
                    @endauth
                </div>

                <div class="d-flex flex-wrap gap-3 mt-4 text-muted">
                    <small><i class="bi bi-lightning-charge me-1"></i> Alertas rápidos</small>
                    <small><i class="bi bi-capsule-pill me-1"></i> Controle de medicamentos</small>
                    <small><i class="bi bi-journal-text me-1"></i> Histórico de eventos</small>
                    <small><i class="bi bi-people me-1"></i> Contatos úteis</small>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="position-relative">
                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                        <div class="card-body p-2 p-md-3 bg-white">
                            <img 
                                src="{{ asset('media/Dashboard.png') }}" 
                                alt="Dashboard do Sênior Conecta"
                                class="img-fluid rounded-4 w-100"
                            >
                        </div>
                    </div>

                    <div class="position-absolute top-0 end-0 translate-middle-y me-3 mt-4 d-none d-md-block">
                        <span class="badge rounded-pill bg-white text-dark shadow-sm border px-3 py-2">
                            <i class="bi bi-shield-check text-primary me-1"></i> Interface real do sistema
                        </span>
                    </div>

                    <div class="position-absolute bottom-0 end-0 translate-middle-y me-3 d-none d-md-block">
                        <span class="badge rounded-pill bg-primary px-3 py-2 shadow-sm">
                            <i class="bi bi-activity me-1"></i> Monitoramento centralizado
                        </span>
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
            <span class="badge bg-primary-subtle text-primary mb-3 px-3 py-2 rounded-pill">
                Relatos e participação da comunidade
            </span>

            <h2 class="fw-bold">Comentários aprovados e espaço para contribuição</h2>
            <p class="text-muted col-md-8 mx-auto">
                Comentários enviados pelos usuários passam por validação antes de aparecer publicamente,
                mantendo a área mais organizada, confiável e alinhada com a proposta do projeto.
            </p>
        </div>

        @if(session('success'))
            <div class="alert alert-success rounded-4 border-0 shadow-sm mb-4">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger rounded-4 border-0 shadow-sm mb-4">
                <div class="fw-semibold mb-1">Não foi possível enviar seu comentário.</div>
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row g-4 align-items-stretch">
            <div class="col-lg-7">
                <div class="row g-4">
                    @forelse($comentarios as $comentario)
                        <div class="col-md-6">
                            <div class="card shadow-sm border-0 rounded-4 h-100">
                                <div class="card-body p-4 d-flex flex-column">
                                    <div class="d-flex align-items-center gap-3 mb-3">
                                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center fw-bold"
                                             style="width: 54px; height: 54px; font-size: 1.05rem;">
                                            {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($comentario->nome_publico, 0, 1)) }}
                                        </div>

                                        <div>
                                            <div class="fw-bold">{{ $comentario->nome_publico }}</div>
                                            <small class="text-muted">
                                                {{ $comentario->cargo ?: 'Usuário da plataforma' }}
                                            </small>
                                        </div>
                                    </div>

                                    <p class="text-muted mb-4 flex-grow-1">
                                        “{{ $comentario->comentario }}”
                                    </p>

                                    <div class="d-flex align-items-center justify-content-between mt-auto pt-2 border-top">
                                        <small class="text-muted">
                                            Publicado em
                                            {{ optional($comentario->aprovado_em ?? $comentario->created_at)->format('d/m/Y') }}
                                        </small>

                                        <span class="badge rounded-pill text-bg-light border">
                                            <i class="bi bi-patch-check text-primary me-1"></i> Validado
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="card border-0 shadow-sm rounded-4">
                                <div class="card-body p-4 p-lg-5 text-center">
                                    <div class="fs-1 text-primary mb-3">
                                        <i class="bi bi-chat-square-quote"></i>
                                    </div>
                                    <h5 class="fw-bold mb-2">Nenhum comentário público ainda</h5>
                                    <p class="text-muted mb-0">
                                        Os primeiros comentários aprovados aparecerão aqui assim que forem validados pela equipe.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card border-0 shadow rounded-4 h-100">
                    <div class="card-body p-4 p-lg-4">
                        <div class="d-flex align-items-start gap-3 mb-3">
                            <div class="fs-3 text-primary">
                                <i class="bi bi-pencil-square"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">Deixe seu comentário</h5>
                                <p class="text-muted mb-0">
                                    Compartilhe sua percepção sobre o Sênior Conecta.
                                </p>
                            </div>
                        </div>

                        @auth
                            <form method="POST" action="{{ route('comentarios.store') }}">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Nome público</label>
                                    <input
                                        type="text"
                                        name="nome_publico"
                                        class="form-control @error('nome_publico') is-invalid @enderror"
                                        value="{{ old('nome_publico', auth()->user()->name) }}"
                                        placeholder="Como seu nome aparecerá"
                                        required
                                    >
                                    @error('nome_publico')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Cargo ou relação com o projeto</label>
                                    <input
                                        type="text"
                                        name="cargo"
                                        class="form-control @error('cargo') is-invalid @enderror"
                                        value="{{ old('cargo') }}"
                                        placeholder="Ex: Familiar, tutor, cuidador"
                                    >
                                    @error('cargo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Comentário</label>
                                    <textarea
                                        name="comentario"
                                        rows="5"
                                        class="form-control @error('comentario') is-invalid @enderror"
                                        placeholder="Conte como a plataforma pode ajudar ou como foi sua experiência."
                                        required
                                    >{{ old('comentario') }}</textarea>
                                    @error('comentario')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-grid">
                                    <button class="btn btn-primary btn-lg">
                                        <i class="bi bi-send me-1"></i> Enviar comentário
                                    </button>
                                </div>
                            </form>

                            <div class="small text-muted mt-3">
                                <i class="bi bi-info-circle me-1"></i>
                                Seu comentário ficará como <strong>pendente</strong> até a revisão do administrador.
                            </div>
                        @else
                            <div class="rounded-4 border bg-light p-4">
                                <div class="fw-semibold mb-2">Entre para participar</div>
                                <p class="text-muted mb-3">
                                    Para enviar um comentário, é preciso estar logado na plataforma.
                                </p>

                                <div class="d-flex flex-wrap gap-2">
                                    <a href="{{ route('login') }}" class="btn btn-primary">
                                        Entrar
                                    </a>
                                    <a href="{{ route('register') }}" class="btn btn-outline-primary">
                                        Criar conta
                                    </a>
                                </div>
                            </div>
                        @endauth

                        <hr class="my-4">

                        <div class="row g-3 text-center">
                            <div class="col-4">
                                <div class="border rounded-4 p-3 h-100 bg-light">
                                    <div class="fw-bold fs-5">{{ $comentarios->count() }}</div>
                                    <small class="text-muted">Visíveis agora</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="border rounded-4 p-3 h-100 bg-light">
                                    <div class="fw-bold fs-5">100%</div>
                                    <small class="text-muted">Moderados</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="border rounded-4 p-3 h-100 bg-light">
                                    <div class="fw-bold fs-5">Público</div>
                                    <small class="text-muted">Após aprovação</small>
                                </div>
                            </div>
                        </div>
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
