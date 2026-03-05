@extends('layouts.app')

@section('content')

@php
    $hoje = \Carbon\Carbon::now()->format('d/m/Y');
    $horaAgora = \Carbon\Carbon::now()->format('H:i');
@endphp

<div class="container py-5">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
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

                <a href="{{ route('idosos.gerenciar') }}" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-gear me-1"></i> Gerenciar
                </a>
            @else
                <a href="{{ route('idosos.cadastrar') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle me-1"></i> Cadastrar pessoa acompanhada
                </a>
            @endif

        </div>
    </div>

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
                        <div class="fs-2 mb-2 text-danger">
                            <i class="bi bi-exclamation-triangle"></i>
                        </div>
                        <div class="text-muted small">Alertas ativos</div>
                        <div class="fw-bold fs-3 text-danger">{{ $alertas }}</div>

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
                            // Se você tiver lat/lng na tabela, use:
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
                        <div class="text-muted small">Próximo medicamento</div>

                        <div class="fw-semibold">
                            {{ $proximoMedicamento->nome ?? 'Nenhum' }}
                        </div>

                        <small class="text-muted d-block mt-2">
                            {{ $proximoMedicamento->horario ?? '' }}
                        </small>

                        <div class="mt-3">
                            @if($proximoMedicamento)
                                {{-- Troque por sua rota real depois --}}
                                <a href="#" class="btn btn-outline-warning btn-sm">
                                    <i class="bi bi-check2-circle me-1"></i> Marcar como tomado
                                </a>
                            @else
                                <button class="btn btn-outline-secondary btn-sm" disabled>
                                    <i class="bi bi-check2-circle me-1"></i> Sem agendamentos
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- AÇÕES RÁPIDAS (com mais utilidade) --}}
        <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-header bg-danger text-white rounded-top-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <span class="fw-bold">
                    <i class="bi bi-lightning-charge me-1"></i> Ações rápidas
                </span>
                <small class="opacity-75">
                    Use em caso de urgência / necessidade imediata
                </small>
            </div>

            <div class="card-body">
                <div class="row g-3 text-center">

                    <div class="col-md-3">
                        <a href="tel:192" class="btn btn-danger w-100">
                            <i class="bi bi-ambulance me-1"></i> SAMU (192)
                        </a>
                    </div>

                    <div class="col-md-3">
                        <a href="tel:190" class="btn btn-dark w-100">
                            <i class="bi bi-shield me-1"></i> Polícia (190)
                        </a>
                    </div>

                    <div class="col-md-3">
                        <a href="tel:193" class="btn btn-warning w-100">
                            <i class="bi bi-fire me-1"></i> Bombeiros (193)
                        </a>
                    </div>

                    <div class="col-md-3">
                        {{-- se você tiver telefone do idoso, troque o href --}}
                        <a href="{{ $idoso->telefone ? 'tel:'.$idoso->telefone : '#' }}"
                           class="btn btn-primary w-100 {{ $idoso->telefone ? '' : 'disabled' }}">
                            <i class="bi bi-telephone me-1"></i> Ligar
                        </a>
                    </div>

                    <div class="col-md-3">
                        {{-- WhatsApp (se tiver telefone) --}}
                        @php
                            $whats = $idoso->telefone ? preg_replace('/\D/', '', $idoso->telefone) : null;
                        @endphp
                        <a href="{{ $whats ? 'https://wa.me/55'.$whats : '#' }}"
                           target="_blank"
                           class="btn btn-outline-success w-100 {{ $whats ? '' : 'disabled' }}">
                            <i class="bi bi-whatsapp me-1"></i> WhatsApp
                        </a>
                    </div>

                    <div class="col-md-3">
                        <a href="{{ route('idosos.gerenciar') }}" class="btn btn-outline-primary w-100">
                            <i class="bi bi-person-gear me-1"></i> Dados do perfil
                        </a>
                    </div>

                    <div class="col-md-3">
                        {{-- Ajuste para sua rota real de medicamentos --}}
                        <a href="#" class="btn btn-outline-warning w-100">
                            <i class="bi bi-capsule me-1"></i> Medicamentos
                        </a>
                    </div>

                    <div class="col-md-3">
                        {{-- Ajuste para sua rota real de histórico --}}
                        <a href="#" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-clock-history me-1"></i> Histórico
                        </a>
                    </div>

                </div>
            </div>
        </div>

        {{-- ÚLTIMOS EVENTOS (mais legível e com ícones) --}}
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

                                        // Ícones por tipo (personalize depois)
                                        $icone = match($evento->tipo) {
                                            'queda' => 'bi-person-falling',
                                            'alerta' => 'bi-exclamation-triangle',
                                            'localizacao' => 'bi-geo-alt',
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
                        {{-- Ajuste para sua rota real de eventos --}}
                        <a href="#" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-list-ul me-1"></i> Ver histórico completo
                        </a>
                    </div>
                @endif

            </div>
        </div>

    @endif

</div>

@endsection