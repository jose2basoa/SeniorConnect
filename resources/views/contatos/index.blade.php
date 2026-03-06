@extends('layouts.app')

@section('content')
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Contatos</h3>
            <small class="text-muted">
                Referente a: <span class="fw-semibold">{{ $idoso->nome }}</span>
            </small>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('dashboard', ['idoso' => $idoso->id]) }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Voltar ao painel
            </a>
            <a href="{{ route('idosos.show', $idoso->id) }}" class="btn btn-primary">
                <i class="bi bi-person-badge"></i> Ver perfil
            </a>
        </div>
    </div>

    <div class="row g-4">

        {{-- TUTORES --}}
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-header bg-primary text-white rounded-top-4">
                    <span class="fw-bold">
                        <i class="bi bi-people me-1"></i> Tutores
                    </span>
                </div>

                <div class="card-body">
                    @if($tutores->isEmpty())
                        <div class="text-muted">Nenhum tutor encontrado.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nome</th>
                                        <th>Contato</th>
                                        <th class="text-end">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tutores as $tutor)
                                        @php
                                            $tel = $tutor->telefone ?? null;
                                            $telLimpo = $tel ? preg_replace('/\D/', '', $tel) : null;
                                        @endphp

                                        <tr>
                                            <td class="fw-semibold">{{ $tutor->name }}</td>
                                            <td class="text-muted">
                                                {{ $tel ?? 'Sem telefone' }}
                                            </td>
                                            <td class="text-end">
                                                <a class="btn btn-sm btn-outline-primary {{ $tel ? '' : 'disabled' }}"
                                                   href="{{ $tel ? 'tel:'.$tel : '#' }}">
                                                    <i class="bi bi-telephone"></i>
                                                </a>

                                                <a class="btn btn-sm btn-outline-success {{ $telLimpo ? '' : 'disabled' }}"
                                                   target="_blank"
                                                   href="{{ $telLimpo ? 'https://wa.me/55'.$telLimpo : '#' }}">
                                                    <i class="bi bi-whatsapp"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- CONTATOS DE EMERGÊNCIA --}}
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-header bg-danger text-white rounded-top-4">
                    <span class="fw-bold">
                        <i class="bi bi-exclamation-triangle me-1"></i> Contatos de emergência
                    </span>
                </div>

                <div class="card-body">
                    @if($contatosEmergencia->isEmpty())
                        <div class="text-muted">Nenhum contato de emergência cadastrado.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nome</th>
                                        <th>Parentesco</th>
                                        <th>Telefone</th>
                                        <th class="text-end">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($contatosEmergencia as $c)
                                        @php
                                            $tel = $c->telefone ?? null;
                                            $telLimpo = $tel ? preg_replace('/\D/', '', $tel) : null;
                                        @endphp

                                        <tr>
                                            <td class="fw-semibold">
                                                {{ $c->nome }}
                                                @if(($c->prioridade ?? 1) == 1)
                                                    <span class="badge bg-success ms-2">Principal</span>
                                                @endif
                                            </td>
                                            <td class="text-muted">{{ $c->parentesco ?? '-' }}</td>
                                            <td class="text-muted">{{ $tel ?? '—' }}</td>
                                            <td class="text-end">
                                                <a class="btn btn-sm btn-outline-danger {{ $tel ? '' : 'disabled' }}"
                                                   href="{{ $tel ? 'tel:'.$tel : '#' }}">
                                                    <i class="bi bi-telephone"></i>
                                                </a>

                                                <a class="btn btn-sm btn-outline-success {{ $telLimpo ? '' : 'disabled' }}"
                                                   target="_blank"
                                                   href="{{ $telLimpo ? 'https://wa.me/55'.$telLimpo : '#' }}">
                                                    <i class="bi bi-whatsapp"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
