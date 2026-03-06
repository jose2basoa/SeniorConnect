@extends('layouts.app')

@section('content')

@php
    $hoje = \Carbon\Carbon::now()->format('d/m/Y');
    $horaAgora = \Carbon\Carbon::now()->format('H:i');
@endphp

<div class="container py-5">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-3">
        <div>
            <h3 class="mb-1 fw-bold">Painel de Monitoramento</h3>

            <div class="text-muted">
                <i class="bi bi-calendar3 me-1"></i> {{ $hoje }}
                <span class="mx-2">•</span>
                <i class="bi bi-clock me-1"></i> {{ $horaAgora }}
            </div>

            @auth
                <small class="text-muted d-block mt-1">
                    Olá, <span class="fw-semibold">{{ auth()->user()->name }}</span> 👋
                </small>
            @endauth
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">

            @if($idoso)
                <span class="badge {{ $alertas > 0 ? 'bg-danger' : 'bg-success' }} fs-6">
                    <i class="bi {{ $alertas > 0 ? 'bi-exclamation-triangle' : 'bi-check-circle' }} me-1"></i>
                    {{ $alertas > 0 ? "$alertas alertas ativos" : 'Sem alertas' }}
                </span>
                <a href="{{ route('idosos.gerenciar') }}" class="btn btn-primary">
                    <i class="bi bi-people me-1"></i> Gerenciar vinculados
                </a>
            @else
                @if(auth()->user()->is_admin)
                    <a href="{{ url('idosos/gerenciar') }}" class="btn btn-primary">
                        <i class="bi bi-people me-1"></i> Gerenciar idosos
                    </a>
                @else
                    <a href="{{ route('idosos.cadastrar') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i> Cadastrar pessoa acompanhada
                    </a>
                @endif
            @endif

        </div>
    </div>

    {{-- ✅ IDEIA EXTRA: “quem está sendo monitorado agora” --}}
    @if($idoso)
        @php
            $idade = $idoso->data_nascimento
                ? \Carbon\Carbon::parse($idoso->data_nascimento)->age
                : null;

            $statusLabel = $idoso->status_online ? 'Online' : 'Offline';
            $statusClass = $idoso->status_online ? 'text-success' : 'text-danger';
            $statusIcon  = $idoso->status_online ? 'bi-wifi' : 'bi-wifi-off';
        @endphp

        <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <h4 class="fw-bold mb-0">{{ $idoso->nome }}</h4>

                        @if(!is_null($idade))
                            <span class="badge bg-light text-dark border">
                                {{ $idade }} anos
                            </span>
                        @endif

                        <span class="badge bg-light text-dark border">
                            <i class="bi {{ $statusIcon }} me-1 {{ $statusClass }}"></i>
                            <span class="{{ $statusClass }} fw-semibold">{{ $statusLabel }}</span>
                        </span>
                    </div>

                    <small class="text-muted d-block mt-1">
                        @if($idoso->ultima_atividade)
                            Última atividade às <span class="fw-semibold">{{ \Carbon\Carbon::parse($idoso->ultima_atividade)->format('H:i') }}</span>
                        @else
                            Sem registro de atividade recente
                        @endif
                    </small>
                </div>

                <div class="d-flex gap-2 flex-wrap">
                    {{-- ✅ “Dados pessoais” agora vai direto pro perfil do idoso atual --}}
                    <a href="{{ route('idosos.show', $idoso->id) }}" class="btn btn-outline-primary">
                        <i class="bi bi-person-badge me-1"></i> Dados pessoais
                    </a>

                </div>
            </div>
        </div>
    @endif


    {{-- SEM IDOSO: Onboarding --}}
    @if(!$idoso)

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-4 p-md-5 text-center">
                <div class="display-6 mb-2">👵📱</div>
                <h4 class="fw-bold mb-2">Vamos começar?</h4>
                <p class="text-muted mb-4">
                    Para iniciar o monitoramento, cadastre a pessoa acompanhada e vincule ao seu perfil.
                    Isso leva menos de 2 minutos.
                </p>

                <div class="row g-3 justify-content-center mb-4">
                    <div class="col-md-4">
                        <div class="p-3 border rounded-4 h-100">
                            <div class="fw-bold mb-1">1) Cadastre</div>
                            <div class="text-muted small">Nome, nascimento e dados básicos.</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 border rounded-4 h-100">
                            <div class="fw-bold mb-1">2) Vincule</div>
                            <div class="text-muted small">Confirme CPF e data de nascimento.</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 border rounded-4 h-100">
                            <div class="fw-bold mb-1">3) Monitore</div>
                            <div class="text-muted small">Veja alertas, eventos e localização.</div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('idosos.cadastrar') }}" class="btn btn-primary btn-lg px-4">
                    <i class="bi bi-plus-circle me-2"></i> Cadastrar agora
                </a>

                <div class="mt-3">
                    <small class="text-muted">
                        Já existe cadastro? Use a opção de vínculo por CPF e data de nascimento.
                    </small>
                </div>
            </div>
        </div>

    @else

        {{-- RESUMO / KPIs --}}
        <div class="row g-4 mb-4">

            <!-- STATUS -->
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-body p-4 text-center">
                        <div class="fs-2 mb-2 {{ $idoso->status_online ? 'text-success' : 'text-danger' }}">
                            <i class="bi {{ $idoso->status_online ? 'bi-wifi' : 'bi-wifi-off' }}"></i>
                        </div>
                        <div class="text-muted small">Status</div>
                        <div class="fw-bold fs-5 {{ $idoso->status_online ? 'text-success' : 'text-danger' }}">
                            {{ $idoso->status_online ? 'Online' : 'Offline' }}
                        </div>
                        <small class="text-muted d-block mt-2">
                            Última atividade:
                            <span class="fw-semibold">
                                {{ $idoso->ultima_atividade ? \Carbon\Carbon::parse($idoso->ultima_atividade)->format('H:i') : 'Sem registro' }}
                            </span>
                        </small>
                    </div>
                </div>
            </div>

            <!-- ALERTAS -->
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-body p-4 text-center">
                        <div class="fs-2 mb-2 {{ $alertas > 0 ? 'text-danger' : 'text-success' }}">
                            <i class="bi bi-exclamation-triangle"></i>
                        </div>
                        <div class="text-muted small">Alertas ativos</div>
                        <div class="fw-bold fs-3 {{ $alertas > 0 ? 'text-danger' : 'text-success' }}">
                            {{ $alertas }}
                        </div>
                        <small class="text-muted d-block">
                            {{ $alertas > 0 ? 'Requer atenção' : 'Tudo certo no momento' }}
                        </small>
                    </div>
                </div>
            </div>

            <!-- LOCALIZAÇÃO -->
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-body p-4 text-center">
                        <div class="fs-2 mb-2 text-primary">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <div class="text-muted small">Última localização</div>

                        <div class="fw-semibold">
                            {{ $ultimaLocalizacao->endereco ?? 'Sem localização' }}
                        </div>

                        <small class="text-muted d-block mt-2">
                            {{ $ultimaLocalizacao ? $ultimaLocalizacao->created_at->format('H:i') : '' }}
                        </small>

                        @php
                            $lat = $ultimaLocalizacao->lat ?? null;
                            $lng = $ultimaLocalizacao->lng ?? null;
                        @endphp

                        <div class="mt-3">
                            @if($lat && $lng)
                                <a class="btn btn-outline-primary btn-sm"
                                   target="_blank"
                                   href="https://www.google.com/maps?q={{ $lat }},{{ $lng }}">
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

            <!-- MEDICAMENTO -->
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-body p-4 text-center">
                        <div class="fs-2 mb-2 text-warning">
                            <i class="bi bi-capsule"></i>
                        </div>

                        <div class="text-muted small">
                            {{ $proximoMedicamento && !$proximoMedicamento->tomado ? 'Próximo medicamento' : 'Medicamento atual' }}
                        </div>

                        <div class="fw-semibold mt-1">
                            {{ $proximoMedicamento->nome ?? 'Nenhum' }}
                        </div>

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

                        <div class="mt-3">
                            @if($proximoMedicamento)
                                @if(!$proximoMedicamento->tomado)
                                    <form action="{{ route('medicamentos.toggleTomado', [$idoso->id, $proximoMedicamento->id]) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-outline-warning btn-sm rounded-3">
                                            <i class="bi bi-check2-circle me-1"></i> Marcar como tomado
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-outline-secondary btn-sm rounded-3" disabled>
                                        <i class="bi bi-check2-circle me-1"></i> Já marcado como tomado
                                    </button>
                                @endif
                            @else
                                <button class="btn btn-outline-secondary btn-sm rounded-3" disabled>
                                    <i class="bi bi-check2-circle me-1"></i> Sem agendamentos
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- ÚLTIMOS EVENTOS --}}
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-primary text-white rounded-top-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <span class="fw-bold">
                    <i class="bi bi-bell me-1"></i> Últimos eventos
                </span>
                <small class="opacity-75">Registros recentes</small>
            </div>

            <div class="card-body">

                @if($ultimosEventos->isEmpty())
                    <div class="text-muted">
                        Nenhum evento registrado.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Tipo</th>
                                    <th>Descrição</th>
                                    <th class="d-none d-md-table-cell">Gravidade</th>
                                    <th class="text-end">Hora</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ultimosEventos as $evento)

                                @php
                                    $isAlta = ($evento->gravidade ?? '') === 'alta';
                                    $badge = $isAlta ? 'bg-danger' : 'bg-secondary';

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

                                    <tr class="{{ $isAlta ? 'table-danger' : '' }}">
                                        <td class="fw-semibold">
                                            <i class="bi {{ $icone }} me-1"></i>
                                            {{ ucfirst($evento->tipo) }}
                                        </td>

                                        <td class="text-muted">
                                            {{ $evento->descricao }}
                                        </td>

                                        <td class="d-none d-md-table-cell">
                                            <span class="badge {{ $badge }}">
                                                {{ ucfirst($evento->gravidade ?? 'normal') }}
                                            </span>
                                        </td>

                                        <td class="text-end text-muted">
                                            {{ $evento->created_at->format('H:i') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3 d-flex justify-content-end">
                        <a href="{{ route('eventos.index', ['idoso' => $idoso->id]) }}#historico-eventos" 
                        class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-list-ul me-1"></i> Ver histórico completo
                        </a>
                    </div>
                @endif

            </div>
        </div>

        {{-- AÇÕES RÁPIDAS --}}
        <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-header bg-danger text-white rounded-top-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <span class="fw-bold">
                    <i class="bi bi-lightning-charge me-1"></i> Ações rápidas
                </span>
                <small class="opacity-75">
                    Atalhos do tutor para o(a) acompanhado(a) selecionado(a)
                </small>
            </div>

            <div class="card-body">
                <div class="row g-3 text-center">

                    {{-- Ligar para o idoso --}}
                    <div class="col-md-3">
                        <a href="{{ $idoso->telefone ? 'tel:'.$idoso->telefone : '#' }}"
                        class="btn btn-primary w-100 {{ $idoso->telefone ? '' : 'disabled' }}">
                            <i class="bi bi-telephone me-1"></i> Ligar
                        </a>
                    </div>

                    {{-- Medicamentos --}}
                    <div class="col-md-3">
                        <a href="{{ route('medicamentos.index', $idoso->id) }}"
                        class="btn btn-outline-warning w-100">
                            <i class="bi bi-capsule me-1"></i> Medicamentos
                        </a>
                    </div>

                    {{-- Eventos --}}
                    <div class="col-md-3">
                        <a href="{{ route('eventos.index', $idoso->id) }}"
                        class="btn btn-outline-primary w-100">
                            <i class="bi bi-bell me-1"></i> Eventos
                        </a>
                    </div>

                    {{-- Contatos (tutores + emergência) --}}
                    <div class="col-md-3">
                        <a href="{{ route('contatos.index', $idoso->id) }}"
                        class="btn btn-outline-secondary w-100">
                            <i class="bi bi-telephone-forward me-1"></i> Contatos
                        </a>
                    </div>

                </div>
            </div>
        </div>

        {{-- ✅ NAVEGAÇÃO ENTRE TUTORADOS (RODAPÉ) --}}
        @if(isset($idosos) && $idosos->count() > 1 && $idoso)

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-people me-2"></i>Pessoas acompanhadas
                    </h5>
                </div>

                <div class="d-flex flex-nowrap gap-3 overflow-auto pb-2">
                    @foreach($idosos as $idoso)
                        @php
                            $ativo = isset($idosoSelecionado) && $idosoSelecionado && $idosoSelecionado->id === $idoso->id;
                            $idade = \Carbon\Carbon::parse($idoso->data_nascimento)->age;
                        @endphp

                        <a href="{{ route('dashboard', ['idoso' => $idoso->id]) }}"
                        class="card border-0 shadow-sm text-decoration-none flex-shrink-0 rounded-4 {{ $ativo ? 'bg-primary text-white' : 'bg-white text-dark' }}"
                        style="width: 240px; min-width: 240px;">

                            <div class="card-body d-flex align-items-center gap-3 p-3">

                                <div class="rounded-circle d-flex align-items-center justify-content-center overflow-hidden {{ $ativo ? 'bg-white text-primary' : 'bg-primary-subtle text-primary' }}"
                                    style="width: 52px; height: 52px; min-width: 52px;">
                                    @if(!empty($idoso->foto))
                                        <img src="{{ asset('storage/' . $idoso->foto) }}"
                                            alt="{{ $idoso->nome }}"
                                            class="w-100 h-100 object-fit-cover">
                                    @else
                                        <span class="fw-bold fs-5">
                                            {{ strtoupper(mb_substr($idoso->nome, 0, 1)) }}
                                        </span>
                                    @endif
                                </div>

                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="fw-bold text-truncate">
                                        {{ $idoso->nome }}
                                    </div>

                                    <div class="small {{ $ativo ? 'text-white-50' : 'text-muted' }}">
                                        {{ $idade }} anos
                                    </div>
                                </div>

                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

    @endif



</div>

@endsection
