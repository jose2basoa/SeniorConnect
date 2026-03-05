@extends('layouts.app')

@section('content')
<div class="container py-5">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('erro'))
        <div class="alert alert-danger">{{ session('erro') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Perfil</h3>
            <small class="text-muted">Informações completas da pessoa acompanhada</small>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('idosos.edit', $idoso->id) }}" class="btn btn-primary">
                <i class="bi bi-pencil-square me-1"></i> Editar
            </a>
            <a href="{{ route('idosos.gerenciar') }}" class="btn btn-outline-secondary">
                Voltar
            </a>
        </div>
    </div>

    <div class="row g-4">

        <!-- Dados pessoais -->
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
                        <div class="text-muted">Observações</div>
                        <div class="text-muted">{{ $idoso->observacoes ?: '—' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Endereço -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-header bg-light fw-bold rounded-top-4">
                    <i class="bi bi-geo-alt me-1"></i> Endereço
                </div>
                <div class="card-body">
                    @if($idoso->endereco)
                        <div class="mb-2"><span class="text-muted">CEP:</span> <span class="fw-semibold">{{ $idoso->endereco->cep }}</span></div>
                        <div class="mb-2"><span class="text-muted">Rua:</span> <span class="fw-semibold">{{ $idoso->endereco->rua }}</span></div>
                        <div class="mb-2"><span class="text-muted">Número:</span> <span class="fw-semibold">{{ $idoso->endereco->numero ?? '—' }}</span></div>
                        <div class="mb-2"><span class="text-muted">Complemento:</span> <span class="fw-semibold">{{ $idoso->endereco->complemento ?? '—' }}</span></div>
                        <div class="mb-2"><span class="text-muted">Bairro:</span> <span class="fw-semibold">{{ $idoso->endereco->bairro ?? '—' }}</span></div>
                        <div class="mb-2"><span class="text-muted">Cidade/UF:</span> <span class="fw-semibold">{{ $idoso->endereco->cidade ?? '—' }}/{{ $idoso->endereco->estado ?? '—' }}</span></div>
                    @else
                        <div class="text-muted">Sem endereço cadastrado.</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Dados clínicos -->
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
                            <div class="text-muted">Alergias</div>
                            <div class="text-muted">{{ $idoso->dadosClinico->alergias ?: '—' }}</div>
                        </div>
                        <div class="mt-3">
                            <div class="text-muted">Doenças crônicas</div>
                            <div class="text-muted">{{ $idoso->dadosClinico->doencas_cronicas ?: '—' }}</div>
                        </div>
                        <div class="mt-3">
                            <div class="text-muted">Restrições</div>
                            <div class="text-muted">{{ $idoso->dadosClinico->restricoes ?: '—' }}</div>
                        </div>
                    @else
                        <div class="text-muted">Sem dados clínicos cadastrados.</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Contatos -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-header bg-light fw-bold rounded-top-4">
                    <i class="bi bi-telephone-plus me-1"></i> Contatos de emergência
                </div>
                <div class="card-body">
                    @if($idoso->contatosEmergencia && $idoso->contatosEmergencia->isNotEmpty())
                        <ul class="list-group list-group-flush">
                            @foreach($idoso->contatosEmergencia as $c)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-semibold">{{ $c->nome }}</div>
                                        <small class="text-muted">{{ $c->telefone }} • {{ $c->parentesco ?? '—' }}</small>
                                    </div>
                                    <span class="badge bg-primary">#{{ $c->prioridade }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-muted">Sem contatos cadastrados.</div>
                    @endif
                </div>
            </div>
        </div>

    </div>

</div>
@endsection