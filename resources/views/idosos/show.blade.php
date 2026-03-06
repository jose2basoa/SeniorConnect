@extends('layouts.app')

@section('content')
<div class="container py-5">

    @if(session('success'))
        <div class="alert alert-success rounded-4">{{ session('success') }}</div>
    @endif

    @if(session('erro'))
        <div class="alert alert-danger rounded-4">{{ session('erro') }}</div>
    @endif

    @php
        $idade = $idoso->data_nascimento ? \Carbon\Carbon::parse($idoso->data_nascimento)->age : null;
    @endphp

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Perfil</h3>
            <small class="text-muted">Informações completas da pessoa acompanhada</small>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('idosos.edit', $idoso->id) }}" class="btn btn-primary rounded-3">
                <i class="bi bi-pencil-square me-1"></i> Editar
            </a>
            <a href="{{ route('dashboard', ['idoso' => $idoso->id]) }}" class="btn btn-outline-secondary rounded-3">
                <i class="bi bi-arrow-left me-1"></i> Voltar ao painel
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center fw-bold"
                     style="width: 64px; height: 64px; font-size: 1.35rem;">
                    {{ strtoupper(mb_substr($idoso->nome, 0, 1)) }}
                </div>

                <div>
                    <h4 class="fw-bold mb-1">{{ $idoso->nome }}</h4>
                    <div class="text-muted">
                        {{ $idade ? $idade . ' anos' : 'Idade não informada' }}
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('medicamentos.index', $idoso->id) }}" class="btn btn-outline-warning rounded-3">
                    <i class="bi bi-capsule me-1"></i> Medicamentos
                </a>
                <a href="{{ route('eventos.index', $idoso->id) }}" class="btn btn-outline-primary rounded-3">
                    <i class="bi bi-bell me-1"></i> Eventos
                </a>
                <a href="{{ route('contatos.index', $idoso->id) }}" class="btn btn-outline-secondary rounded-3">
                    <i class="bi bi-telephone-forward me-1"></i> Contatos
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">

        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-header bg-light fw-bold rounded-top-4">
                    <i class="bi bi-person-lines-fill me-1"></i> Dados pessoais
                </div>
                <div class="card-body">
                    <div class="mb-2"><span class="text-muted">Nome:</span> <span class="fw-semibold">{{ $idoso->nome }}</span></div>
                    <div class="mb-2"><span class="text-muted">Nascimento:</span> <span class="fw-semibold">{{ \Carbon\Carbon::parse($idoso->data_nascimento)->format('d/m/Y') }}</span></div>
                    <div class="mb-2"><span class="text-muted">Sexo:</span> <span class="fw-semibold">{{ $idoso->sexo ?? '—' }}</span></div>
                    <div class="mb-2"><span class="text-muted">CPF:</span> <span class="fw-semibold">{{ $idoso->cpf ?? '—' }}</span></div>
                    <div class="mb-2"><span class="text-muted">Telefone:</span> <span class="fw-semibold">{{ $idoso->telefone ?? '—' }}</span></div>

                    <div class="mt-3">
                        <div class="text-muted mb-1">Observações</div>
                        <div class="fw-semibold">{{ $idoso->observacoes ?: '—' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-header bg-light fw-bold rounded-top-4">
                    <i class="bi bi-geo-alt me-1"></i> Endereço
                </div>
                <div class="card-body">
                    @if($idoso->endereco)
                        <div class="mb-2"><span class="text-muted">CEP:</span> <span class="fw-semibold">{{ $idoso->endereco->cep ?? '—' }}</span></div>
                        <div class="mb-2"><span class="text-muted">Logradouro:</span> <span class="fw-semibold">{{ $idoso->endereco->logradouro ?? '—' }}</span></div>
                        <div class="mb-2"><span class="text-muted">Número:</span> <span class="fw-semibold">{{ $idoso->endereco->numero ?? '—' }}</span></div>
                        <div class="mb-2"><span class="text-muted">Complemento:</span> <span class="fw-semibold">{{ $idoso->endereco->complemento ?? '—' }}</span></div>
                        <div class="mb-2"><span class="text-muted">Bairro:</span> <span class="fw-semibold">{{ $idoso->endereco->bairro ?? '—' }}</span></div>
                        <div class="mb-2"><span class="text-muted">Cidade/UF:</span> <span class="fw-semibold">{{ ($idoso->endereco->cidade ?? '—') . '/' . ($idoso->endereco->estado ?? '—') }}</span></div>
                    @else
                        <div class="text-muted">Sem endereço cadastrado.</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-header bg-light fw-bold rounded-top-4">
                    <i class="bi bi-heart-pulse me-1"></i> Dados clínicos
                </div>
                <div class="card-body">
                    @if($idoso->dadosClinico)
                        <div class="mb-2"><span class="text-muted">Cartão SUS:</span> <span class="fw-semibold">{{ $idoso->dadosClinico->cartao_sus ?? '—' }}</span></div>
                        <div class="mb-2"><span class="text-muted">Plano de saúde:</span> <span class="fw-semibold">{{ $idoso->dadosClinico->plano_saude ?? '—' }}</span></div>
                        <div class="mb-2"><span class="text-muted">Número do plano:</span> <span class="fw-semibold">{{ $idoso->dadosClinico->numero_plano ?? '—' }}</span></div>
                        <div class="mb-2"><span class="text-muted">Tipo sanguíneo:</span> <span class="fw-semibold">{{ $idoso->dadosClinico->tipo_sanguineo ?? '—' }}</span></div>

                        <div class="mt-3">
                            <div class="text-muted mb-1">Alergias</div>
                            <div class="fw-semibold">{{ $idoso->dadosClinico->alergias ?: '—' }}</div>
                        </div>

                        <div class="mt-3">
                            <div class="text-muted mb-1">Doenças crônicas</div>
                            <div class="fw-semibold">{{ $idoso->dadosClinico->doencas_cronicas ?: '—' }}</div>
                        </div>

                        <div class="mt-3">
                            <div class="text-muted mb-1">Restrições</div>
                            <div class="fw-semibold">{{ $idoso->dadosClinico->restricoes ?: '—' }}</div>
                        </div>
                    @else
                        <div class="text-muted">Sem dados clínicos cadastrados.</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-header bg-light fw-bold rounded-top-4 d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-telephone-plus me-1"></i> Contatos de emergência</span>
                    <span class="badge bg-primary rounded-pill">{{ $idoso->contatosEmergencia->count() }}</span>
                </div>
                <div class="card-body">
                    @if($idoso->contatosEmergencia && $idoso->contatosEmergencia->isNotEmpty())
                        <div class="d-flex flex-column gap-3">
                            @foreach($idoso->contatosEmergencia->sortBy('prioridade') as $c)
                                <div class="border rounded-4 p-3">
                                    <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
                                        <div>
                                            <div class="fw-semibold">
                                                {{ $c->nome }}
                                                @if(($c->prioridade ?? 0) == 1)
                                                    <span class="badge bg-success ms-2">Principal</span>
                                                @endif
                                            </div>

                                            <div class="text-muted small mt-1">
                                                {{ $c->telefone ?? '—' }}
                                                •
                                                {{ $c->parentesco ?? 'Parentesco não informado' }}
                                            </div>
                                        </div>

                                        <span class="badge bg-light text-dark border rounded-pill">
                                            Prioridade {{ $c->prioridade }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-muted">Sem contatos cadastrados.</div>
                    @endif
                </div>
            </div>
        </div>

    </div>

</div>
@endsection