@extends('layouts.app')

@section('content')
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Contatos</h3>
            <small class="text-muted">
                Referente a: <span class="fw-semibold">{{ $idoso->nome }}</span>
            </small>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('dashboard', ['idoso' => $idoso->id]) }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Voltar ao painel
            </a>
            <a href="{{ route('idosos.show', $idoso->id) }}" class="btn btn-primary">
                <i class="bi bi-person-badge me-1"></i> Ver perfil
            </a>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body p-4 text-center">
                    <div class="fs-2 text-primary mb-2">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="text-muted small">Tutores vinculados</div>
                    <div class="fw-bold fs-3">{{ $tutores->count() }}</div>
                    <small class="text-muted">Pessoas com acesso ao acompanhamento</small>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body p-4 text-center">
                    <div class="fs-2 text-danger mb-2">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <div class="text-muted small">Contatos de emergência</div>
                    <div class="fw-bold fs-3">{{ $contatosEmergencia->count() }}</div>
                    <small class="text-muted">Rede de apoio para situações urgentes</small>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body p-4 text-center">
                    <div class="fs-2 text-success mb-2">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div class="text-muted small">Contato principal</div>
                    <div class="fw-bold">
                        {{ optional($contatosEmergencia->sortBy('prioridade')->first())->nome ?? 'Não definido' }}
                    </div>
                    <small class="text-muted">Primeira referência em caso de emergência</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">

        {{-- TUTORES --}}
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-header bg-primary text-white rounded-top-4 d-flex justify-content-between align-items-center">
                    <span class="fw-bold">
                        <i class="bi bi-people me-1"></i> Tutores vinculados
                    </span>
                    <span class="badge bg-light text-primary">
                        {{ $tutores->count() }}
                    </span>
                </div>

                <div class="card-body">
                    @if($tutores->isEmpty())
                        <div class="text-center py-4">
                            <div class="fs-3 mb-2">👥</div>
                            <div class="fw-semibold mb-1">Nenhum tutor encontrado</div>
                            <div class="text-muted small">
                                Ainda não há pessoas vinculadas como tutores deste cadastro.
                            </div>
                        </div>
                    @else
                        <div class="d-flex flex-column gap-3">
                            @foreach($tutores as $tutor)
                                @php
                                    $tel = $tutor->telefone ?? null;
                                    $telLimpo = $tel ? preg_replace('/\D/', '', $tel) : null;
                                @endphp

                                <div class="border rounded-4 p-3">
                                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                                        <div>
                                            <div class="fw-bold">{{ $tutor->nome_completo ?? $tutor->name }}</div>

                                            @if(!empty($tutor->email))
                                                <div class="text-muted small">
                                                    <i class="bi bi-envelope me-1"></i>{{ $tutor->email }}
                                                </div>
                                            @endif

                                            <div class="text-muted small mt-1">
                                                <i class="bi bi-telephone me-1"></i>
                                                {{ $tel ?? 'Sem telefone cadastrado' }}
                                            </div>
                                        </div>

                                        <div class="d-flex gap-2">
                                            <a class="btn btn-sm btn-outline-primary {{ $tel ? '' : 'disabled' }}"
                                               href="{{ $tel ? 'tel:'.$tel : '#' }}">
                                                <i class="bi bi-telephone me-1"></i>Ligar
                                            </a>

                                            <a class="btn btn-sm btn-outline-success {{ $telLimpo ? '' : 'disabled' }}"
                                               target="_blank"
                                               href="{{ $telLimpo ? 'https://wa.me/55'.$telLimpo : '#' }}">
                                                <i class="bi bi-whatsapp me-1"></i>WhatsApp
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- CONTATOS DE EMERGÊNCIA --}}
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-header bg-danger text-white rounded-top-4 d-flex justify-content-between align-items-center">
                    <span class="fw-bold">
                        <i class="bi bi-exclamation-triangle me-1"></i> Contatos de emergência
                    </span>
                    <span class="badge bg-light text-danger">
                        {{ $contatosEmergencia->count() }}
                    </span>
                </div>

                <div class="card-body">
                    @if($contatosEmergencia->isEmpty())
                        <div class="text-center py-4">
                            <div class="fs-3 mb-2">🚨</div>
                            <div class="fw-semibold mb-1">Nenhum contato de emergência cadastrado</div>
                            <div class="text-muted small">
                                Cadastre pelo menos um contato para fortalecer a rede de apoio.
                            </div>
                        </div>
                    @else
                        <div class="d-flex flex-column gap-3">
                            @foreach($contatosEmergencia->sortBy('prioridade') as $c)
                                @php
                                    $tel = $c->telefone ?? null;
                                    $telLimpo = $tel ? preg_replace('/\D/', '', $tel) : null;
                                    $principal = ($c->prioridade ?? 1) == 1;
                                @endphp

                                <div class="border rounded-4 p-3 {{ $principal ? 'border-danger-subtle bg-danger-subtle' : '' }}">
                                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                                        <div>
                                            <div class="fw-bold d-flex align-items-center flex-wrap gap-2">
                                                {{ $c->nome }}

                                                @if($principal)
                                                    <span class="badge bg-danger">Principal</span>
                                                @else
                                                    <span class="badge bg-light text-dark border">
                                                        Prioridade {{ $c->prioridade }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="text-muted small mt-1">
                                                <i class="bi bi-people me-1"></i>
                                                {{ $c->parentesco ?: 'Parentesco não informado' }}
                                            </div>

                                            <div class="text-muted small mt-1">
                                                <i class="bi bi-telephone me-1"></i>
                                                {{ $tel ?? 'Sem telefone cadastrado' }}
                                            </div>
                                        </div>

                                        <div class="d-flex gap-2">
                                            <a class="btn btn-sm btn-outline-danger {{ $tel ? '' : 'disabled' }}"
                                               href="{{ $tel ? 'tel:'.$tel : '#' }}">
                                                <i class="bi bi-telephone me-1"></i>Ligar
                                            </a>

                                            <a class="btn btn-sm btn-outline-success {{ $telLimpo ? '' : 'disabled' }}"
                                               target="_blank"
                                               href="{{ $telLimpo ? 'https://wa.me/55'.$telLimpo : '#' }}">
                                                <i class="bi bi-whatsapp me-1"></i>WhatsApp
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

</div>
@endsection