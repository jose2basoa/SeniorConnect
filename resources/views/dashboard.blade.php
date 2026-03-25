@extends('layouts.app')

@section('content')

@php
    $hoje = \Carbon\Carbon::now()->format('d/m/Y');
    $horaAgora = \Carbon\Carbon::now()->format('H:i');
@endphp

<style>
    .dashboard-page {
        padding-bottom: 2rem;
    }

    .dashboard-hero-title {
        font-size: clamp(1.75rem, 2vw, 2.4rem);
        line-height: 1.15;
    }

    .dashboard-card,
    .dashboard-summary-card,
    .dashboard-person-card {
        border: 0;
        border-radius: 1.25rem;
        box-shadow: 0 .125rem .75rem rgba(15, 23, 42, .08);
    }

    .dashboard-summary-card .card-body {
        min-height: 220px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .dashboard-panel-header {
        border: 0;
        border-radius: 1.25rem 1.25rem 0 0 !important;
        padding: 1rem 1.25rem;
    }

    .dashboard-collapse-label {
        white-space: nowrap;
    }

    .dashboard-floating-idosos {
        position: fixed;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 1030;
        background: rgba(255,255,255,.97);
        backdrop-filter: blur(10px);
        border-top: 1px solid rgba(0,0,0,.08);
        box-shadow: 0 -4px 20px rgba(0,0,0,.08);
    }

    .dashboard-person-card {
        width: 240px;
        min-width: 240px;
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .dashboard-person-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 .4rem 1rem rgba(15, 23, 42, .12);
    }

    .dashboard-person-avatar {
        width: 52px;
        height: 52px;
        min-width: 52px;
    }

    .dashboard-bottom-spacer {
        height: 130px;
    }

    @media (max-width: 991.98px) {
        .dashboard-floating-idosos {
            position: static;
            margin-top: 1.5rem;
            border: 1px solid rgba(0,0,0,.08);
            border-radius: 1.25rem;
            box-shadow: 0 .125rem .75rem rgba(15, 23, 42, .08);
            backdrop-filter: none;
        }

        .dashboard-bottom-spacer {
            display: none;
        }
    }

    @media (max-width: 767.98px) {
        .dashboard-summary-card .card-body {
            min-height: auto;
        }

        .dashboard-collapse-label {
            white-space: normal;
        }
    }
</style>

<div class="container py-4 py-lg-5 dashboard-page">

    <div class="row align-items-center g-3 g-lg-4 mb-4 mb-lg-5">
        <div class="col-12 col-xl">
            <h1 class="dashboard-hero-title fw-bold mb-2">Painel de<br class="d-none d-md-block"> Monitoramento</h1>

            <div class="text-muted small mb-1">
                <i class="bi bi-calendar3 me-1"></i> {{ $hoje }}
                <span class="mx-2">•</span>
                <i class="bi bi-clock me-1"></i> {{ $horaAgora }}
            </div>

            @auth
                <div class="text-muted">
                    Olá, <span class="fw-semibold">{{ auth()->user()->name }}</span> 👋
                </div>
            @endauth
        </div>

        <div class="col-12 col-xl-auto">
            <div class="d-grid d-md-flex gap-2 justify-content-xl-end">
                @if($idoso)
                    <span class="badge {{ $alertas > 0 ? 'bg-danger' : 'bg-success' }} fs-6 px-3 py-2 d-inline-flex align-items-center justify-content-center">
                        <i class="bi {{ $alertas > 0 ? 'bi-exclamation-triangle' : 'bi-check-circle' }} me-2"></i>
                        {{ $alertas > 0 ? "$alertas alertas ativos" : 'Sem alertas' }}
                    </span>

                    <a href="{{ route('idosos.gerenciar') }}" class="btn btn-primary px-3">
                        <i class="bi bi-people me-1"></i> Gerenciar acompanhados
                    </a>
                @else
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('idosos.gerenciar') }}" class="btn btn-primary px-3">
                            <i class="bi bi-people me-1"></i> Gerenciar idosos
                        </a>
                    @else
                        <a href="{{ route('idosos.cadastrar') }}" class="btn btn-primary px-3">
                            <i class="bi bi-plus-circle me-1"></i> Cadastrar pessoa acompanhada
                        </a>
                    @endif
                @endif
            </div>
        </div>
    </div>

    @if($idoso)
        @php
            $idade = $idoso->data_nascimento ? \Carbon\Carbon::parse($idoso->data_nascimento)->age : null;
            $statusLabel = $idoso->status_online ? 'Online' : 'Offline';
            $statusClass = $idoso->status_online ? 'text-success' : 'text-danger';
            $statusIcon = $idoso->status_online ? 'bi-wifi' : 'bi-wifi-off';
        @endphp

        <div class="card dashboard-card mb-4">
            <div class="card-body p-3 p-lg-4">
                <div class="row align-items-center g-3">
                    <div class="col-12 col-lg">
                        <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                            <h2 class="h3 fw-bold mb-0">{{ $idoso->nome }}</h2>

                            @if(!is_null($idade))
                                <span class="badge bg-light text-dark border">{{ $idade }} anos</span>
                            @endif

                            <span class="badge bg-light text-dark border d-inline-flex align-items-center">
                                <i class="bi {{ $statusIcon }} me-1 {{ $statusClass }}"></i>
                                <span class="{{ $statusClass }} fw-semibold">{{ $statusLabel }}</span>
                            </span>
                        </div>

                        <div class="text-muted">
                            @if($idoso->ultima_atividade)
                                Última atividade às
                            <span class="fw-semibold">{{ \Carbon\Carbon::parse($idoso->ultima_atividade)->format('H:i') }}</span>
                            @else
                                Sem registro de atividade recente
                            @endif
                        </div>
                    </div>

                    <div class="col-12 col-lg-auto">
                        <div class="d-grid d-sm-flex gap-2 justify-content-lg-end">
                            <a href="{{ route('idosos.show', $idoso->id) }}" class="btn btn-outline-primary px-3">
                                <i class="bi bi-person-badge me-1"></i> Dados pessoais
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(!$idoso)

        <div class="card dashboard-card">
            <div class="card-body p-4 p-md-5 text-center">
                <div class="display-6 mb-2">👵📱</div>
                <h4 class="fw-bold mb-2">Vamos começar?</h4>
                <p class="text-muted mb-4">
                    Para iniciar o acompanhamento, cadastre ou vincule uma pessoa ao seu perfil.
                    Assim você poderá visualizar alertas, eventos, medicamentos e localização.
                </p>

                <div class="row g-3 justify-content-center mb-4">
                    <div class="col-12 col-md-4">
                        <div class="p-3 border rounded-4 h-100">
                            <div class="fw-bold mb-1">1) Cadastre</div>
                            <div class="text-muted small">Informe os dados principais da pessoa acompanhada.</div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="p-3 border rounded-4 h-100">
                            <div class="fw-bold mb-1">2) Vincule</div>
                            <div class="text-muted small">Associe o cadastro ao seu perfil com segurança.</div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="p-3 border rounded-4 h-100">
                            <div class="fw-bold mb-1">3) Monitore</div>
                            <div class="text-muted small">Acompanhe alertas, rotina e informações importantes.</div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('idosos.cadastrar') }}" class="btn btn-primary btn-lg px-4">
                    <i class="bi bi-plus-circle me-2"></i> Começar agora
                </a>

                <div class="mt-3">
                    <small class="text-muted">
                        Se a pessoa já possuir cadastro, utilize a opção de vínculo por CPF e data de nascimento.
                    </small>
                </div>
            </div>
        </div>

    @else

        <div class="row g-3 g-lg-4 mb-4">

            <div class="col-12 col-md-6 col-xxl-3">
                <div class="card dashboard-summary-card h-100">
                    <div class="card-body p-4 text-center">
                        <div class="fs-2 mb-2 {{ $idoso->status_online ? 'text-success' : 'text-danger' }}">
                            <i class="bi {{ $idoso->status_online ? 'bi-wifi' : 'bi-wifi-off' }}"></i>
                        </div>
                        <div class="text-muted small">Status</div>
                        <div class="fw-bold fs-4 {{ $idoso->status_online ? 'text-success' : 'text-danger' }}">{{ $idoso->status_online ? 'Online' : 'Offline' }}</div>
                        <small class="text-muted d-block mt-2">
                            Última atividade:
                            <span class="fw-semibold">{{ $idoso->ultima_atividade ? \Carbon\Carbon::parse($idoso->ultima_atividade)->format('H:i') : 'Sem registro' }}</span>
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xxl-3">
                <div class="card dashboard-summary-card h-100">
                    <div class="card-body p-4 text-center">
                        <div class="fs-2 mb-2 {{ $alertas > 0 ? 'text-danger' : 'text-success' }}">
                            <i class="bi bi-exclamation-triangle"></i>
                        </div>
                        <div class="text-muted small">Alertas ativos</div>
                        <div class="fw-bold fs-2 {{ $alertas > 0 ? 'text-danger' : 'text-success' }}">{{ $alertas }}</div>
                        <small class="text-muted d-block">{{ $alertas > 0 ? 'Requer atenção' : 'Tudo certo no momento' }}</small>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xxl-3">
                <div class="card dashboard-summary-card h-100">
                    <div class="card-body p-4 text-center">
                        <div class="fs-2 mb-2 text-primary">
                            <i class="bi bi-geo-alt"></i>
                        </div>

                        <div class="text-muted small">Última localização</div>
                        <div class="fw-semibold">{{ $ultimaLocalizacao->endereco ?? 'Sem localização registrada' }}</div>

                        <small class="text-muted d-block mt-2">
                            @if($ultimaLocalizacao?->capturado_em)
                                {{ \Carbon\Carbon::parse($ultimaLocalizacao->capturado_em)->format('H:i') }}
                            @else
                                Sem horário disponível
                            @endif
                        </small>

                        @php
                            $latitude = $ultimaLocalizacao->latitude ?? null;
                            $longitude = $ultimaLocalizacao->longitude ?? null;
                        @endphp

                        <div class="mt-3 d-grid">
                            @if($latitude && $longitude)
                                <a class="btn btn-outline-primary btn-sm" target="_blank" href="https://www.google.com/maps?q={{ $latitude }},{{ $longitude }}">
                                    <i class="bi bi-map me-1"></i> Ver no mapa
                                </a>
                            @else
                                <button class="btn btn-outline-secondary btn-sm" disabled>
                                    <i class="bi bi-map me-1"></i> Mapa indisponível
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xxl-3">
                <div class="card dashboard-summary-card h-100">
                    <div class="card-body p-4 text-center">
                        <div class="fs-2 mb-2 text-warning">
                            <i class="bi bi-capsule"></i>
                        </div>

                        <div class="text-muted small">
                            {{ $proximoMedicamento && !$proximoMedicamento->tomado ? 'Próximo medicamento' : 'Medicamento atual' }}
                        </div>

                        <div class="fw-semibold mt-1">{{ $proximoMedicamento->nome ?? 'Nenhum cadastrado' }}</div>

                        <small class="text-muted d-block mt-2">
                            @if($proximoMedicamento && $proximoMedicamento->horario)
                                {{ \Carbon\Carbon::parse($proximoMedicamento->horario)->format('H:i') }}
                            @endif
                        </small>

                        <div class="mt-2">
                            @if($proximoMedicamento)
                                @if($proximoMedicamento->tomado)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-3 px-3 py-2">
                                        Medicamento tomado
                                    </span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-3 px-3 py-2">
                                        Pendente
                                    </span>
                                @endif
                            @endif
                        </div>

                        <div class="mt-3 d-grid">
                            @if($proximoMedicamento)
                                @if(!$proximoMedicamento->tomado)
                                    <form action="{{ route('medicamentos.toggleTomado', [$idoso->id, $proximoMedicamento->id]) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-outline-warning btn-sm rounded-3 w-100">
                                            <i class="bi bi-check2-circle me-1"></i> Marcar como tomado
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-outline-secondary btn-sm rounded-3 w-100" disabled>
                                        <i class="bi bi-check2-circle me-1"></i> Já marcado como tomado
                                    </button>
                                @endif
                            @else
                                <button class="btn btn-outline-secondary btn-sm rounded-3 w-100" disabled>
                                    <i class="bi bi-check2-circle me-1"></i> Sem agendamentos
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="card dashboard-card mb-4">
            @php
                $alertasAtivos = $alertas ?? 0;
                $alertasCriticos = $ultimosEventos->where('nivel', 'critico')->count();
            @endphp

            <div class="card-header dashboard-panel-header bg-primary text-white d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2"
                 data-bs-toggle="collapse"
                 data-bs-target="#eventosCollapse"
                 aria-expanded="false"
                 aria-controls="eventosCollapse"
                 style="cursor:pointer;">

                <div class="d-flex align-items-start align-items-md-center gap-2 flex-wrap">
                    <span class="fw-bold d-flex align-items-center gap-2 flex-wrap">
                        <i class="bi bi-bell"></i>
                        Últimos eventos

                        @if($alertasAtivos > 0)
                            <span class="badge bg-light text-primary fw-bold rounded-pill px-2 py-1">{{ $alertasAtivos }}</span>
                        @endif

                        @if($alertasCriticos > 0)
                            <span class="badge bg-danger fw-semibold rounded-pill px-2 py-1">
                                {{ $alertasCriticos }} crítico{{ $alertasCriticos > 1 ? 's' : '' }}
                            </span>
                        @endif
                    </span>

                    @if($alertasAtivos > 0)
                        <small class="text-white-50">{{ $alertasAtivos }} alerta{{ $alertasAtivos > 1 ? 's' : '' }} ativo{{ $alertasAtivos > 1 ? 's' : '' }}</small>
                    @else
                        <small class="text-white-50">Sem alertas ativos no momento</small>
                    @endif
                </div>

                <small class="opacity-75 d-flex align-items-center dashboard-collapse-label">
                    Registros recentes
                    <i class="bi bi-chevron-down ms-2 collapse-arrow"></i>
                </small>
            </div>

            <div id="eventosCollapse" class="collapse">
                <div class="card-body p-3 p-md-4">
                    @if($ultimosEventos->isEmpty())
                        <div class="text-muted">Nenhum evento registrado até o momento.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tipo</th>
                                        <th>Descrição</th>
                                        <th class="d-none d-md-table-cell">Nível</th>
                                        <th class="text-end">Hora</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ultimosEventos as $evento)
                                        @php
                                            $nivel = $evento->nivel ?? 'medio';

                                            $badge = match($nivel) {
                                                'critico' => 'bg-danger',
                                                'alto' => 'bg-warning text-dark',
                                                'medio' => 'bg-secondary',
                                                'baixo' => 'bg-success',
                                                default => 'bg-secondary'
                                            };

                                            $linha = match($nivel) {
                                                'critico' => 'table-danger',
                                                'alto' => 'table-warning',
                                                default => ''
                                            };

                                            $icone = match($evento->tipo) {
                                                'queda' => 'bi-exclamation-triangle',
                                                'medicacao' => 'bi-capsule',
                                                'sintoma' => 'bi-heart-pulse',
                                                'consulta' => 'bi-hospital',
                                                'comportamento' => 'bi-person',
                                                'rotina' => 'bi-calendar-check',
                                                'outro' => 'bi-journal-text',
                                                default => 'bi-dot'
                                            };
                                        @endphp

                                        <tr class="{{ $linha }}">
                                            <td class="fw-semibold text-nowrap">
                                                <i class="bi {{ $icone }} me-1"></i>
                                                {{ ucfirst($evento->tipo) }}
                                            </td>
                                            <td class="text-muted">{{ $evento->descricao }}</td>
                                            <td class="d-none d-md-table-cell">
                                                <span class="badge {{ $badge }}">{{ ucfirst($nivel) }}</span>
                                            </td>
                                            <td class="text-end text-muted text-nowrap">
                                                {{ $evento->data_evento ? \Carbon\Carbon::parse($evento->data_evento)->format('H:i') : $evento->created_at->format('H:i') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3 d-grid d-md-flex justify-content-md-end">
                            <a href="{{ route('eventos.index', ['idoso' => $idoso->id]) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-list-ul me-1"></i> Ver histórico completo
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="card dashboard-card mb-4">
            <div class="card-header dashboard-panel-header bg-danger text-white d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2"
                 data-bs-toggle="collapse"
                 data-bs-target="#acoesCollapse"
                 aria-expanded="false"
                 aria-controls="acoesCollapse"
                 style="cursor:pointer;">

                <span class="fw-bold d-flex align-items-center gap-2">
                    <i class="bi bi-lightning-charge me-1"></i> Ações rápidas
                </span>

                <small class="opacity-75 d-flex align-items-center dashboard-collapse-label">
                    Atalhos do tutor
                    <i class="bi bi-chevron-down ms-2 collapse-arrow"></i>
                </small>
            </div>

            <div id="acoesCollapse" class="collapse">
                <div class="card-body p-3 p-md-4">
                    <div class="row g-3 text-center">
                        <div class="col-12 col-sm-6 col-xl-3">
                            <a href="{{ $idoso->telefone ? 'tel:'.$idoso->telefone : '#' }}" class="btn btn-primary w-100 {{ $idoso->telefone ? '' : 'disabled' }}">
                                <i class="bi bi-telephone me-1"></i> Ligar
                            </a>
                        </div>

                        <div class="col-12 col-sm-6 col-xl-3">
                            <a href="{{ route('medicamentos.index', $idoso->id) }}" class="btn btn-outline-warning w-100">
                                <i class="bi bi-capsule me-1"></i> Medicamentos
                            </a>
                        </div>

                        <div class="col-12 col-sm-6 col-xl-3">
                            <a href="{{ route('eventos.index', $idoso->id) }}" class="btn btn-outline-primary w-100">
                                <i class="bi bi-bell me-1"></i> Eventos
                            </a>
                        </div>

                        <div class="col-12 col-sm-6 col-xl-3">
                            <a href="{{ route('contatos.index', $idoso->id) }}" class="btn btn-outline-secondary w-100">
                                <i class="bi bi-telephone-forward me-1"></i> Contatos
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(isset($idosos) && $idosos->count() > 1 && $idoso)
            <div class="dashboard-floating-idosos">
                <div class="container py-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="fw-bold mb-0 text-muted text-uppercase small">
                            <i class="bi bi-people me-2"></i>Pessoas acompanhadas
                        </h6>
                    </div>

                    <div class="d-flex flex-nowrap gap-3 overflow-auto pb-1">
                        @foreach($idosos as $pessoa)
                            @php
                                $ativo = isset($idosoSelecionado) && $idosoSelecionado && $idosoSelecionado->id === $pessoa->id;
                                $idadePessoa = $pessoa->data_nascimento ? \Carbon\Carbon::parse($pessoa->data_nascimento)->age : null;
                            @endphp

                            <a href="{{ route('dashboard', ['idoso' => $pessoa->id]) }}"
                               class="card dashboard-person-card text-decoration-none flex-shrink-0 {{ $ativo ? 'bg-primary text-white' : 'bg-white text-dark' }}">
                                <div class="card-body d-flex align-items-center gap-3 p-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center overflow-hidden dashboard-person-avatar {{ $ativo ? 'bg-white text-primary' : 'bg-primary-subtle text-primary' }}">
                                        <span class="fw-bold fs-5">{{ strtoupper(mb_substr($pessoa->nome, 0, 1)) }}</span>
                                    </div>

                                    <div class="flex-grow-1 overflow-hidden">
                                        <div class="fw-bold text-truncate">{{ $pessoa->nome }}</div>
                                        <div class="small {{ $ativo ? 'text-white-50' : 'text-muted' }}">
                                            {{ $idadePessoa ? $idadePessoa . ' anos' : 'Idade não informada' }}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="dashboard-bottom-spacer"></div>
        @endif

    @endif

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    function bindCollapseArrow(collapseId) {
        const header = document.querySelector('[data-bs-target="#' + collapseId + '"]');
        const collapse = document.getElementById(collapseId);

        if (!header || !collapse) return;

        const icon = header.querySelector('.collapse-arrow');
        if (!icon) return;

        collapse.addEventListener('show.bs.collapse', function () {
            icon.classList.remove('bi-chevron-down');
            icon.classList.add('bi-chevron-up');
        });

        collapse.addEventListener('hide.bs.collapse', function () {
            icon.classList.remove('bi-chevron-up');
            icon.classList.add('bi-chevron-down');
        });
    }

    bindCollapseArrow('eventosCollapse');
    bindCollapseArrow('acoesCollapse');
});
</script>

@endsection
