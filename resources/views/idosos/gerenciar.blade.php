@extends('layouts.app')

@section('content')
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Gerenciar pessoas acompanhadas</h3>
            <small class="text-muted">
                Consulte perfis, edite informações e gerencie vínculos com facilidade.
            </small>
        </div>

        <div class="d-flex gap-2 flex-wrap align-items-center">
            <a href="{{ route('idosos.cadastrar') }}" class="btn btn-primary rounded-3">
                <i class="bi bi-plus-circle me-1"></i> Cadastrar
            </a>

            <input
                type="text"
                id="searchIdososCards"
                class="form-control rounded-3"
                placeholder="Pesquisar pessoa..."
                style="width: 240px;"
            >

            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary rounded-3">
                <i class="bi bi-arrow-left me-1"></i> Voltar ao painel
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-4">{{ session('success') }}</div>
    @endif

    @if(session('erro'))
        <div class="alert alert-danger rounded-4">{{ session('erro') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger rounded-4">{{ session('error') }}</div>
    @endif

    @php
        $user = auth()->user();
        $isAdmin = $user && !empty($user->is_admin);
    @endphp

    @if($idosos->isEmpty())
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-5 text-center">
                <div class="display-6 mb-2">👤</div>
                <h4 class="fw-bold mb-2">Nenhuma pessoa vinculada</h4>
                <p class="text-muted mb-4">
                    Cadastre uma nova pessoa ou vincule um cadastro já existente para começar o acompanhamento.
                </p>

                <div class="d-flex justify-content-center gap-2 flex-wrap">
                    <a href="{{ route('idosos.cadastrar') }}" class="btn btn-primary rounded-3">
                        <i class="bi bi-plus-circle me-1"></i> Cadastrar
                    </a>
                    <a href="{{ route('idosos.vincular') }}" class="btn btn-outline-primary rounded-3">
                        <i class="bi bi-link-45deg me-1"></i> Vincular cadastro
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
            <small class="text-muted" id="cardsInfoIdosos">Mostrando 0 de 0 registros</small>
        </div>

        <div class="row g-4" id="idososCardsWrap">
            @foreach($idosos as $idoso)
                @php
                    $temVinculo = $isAdmin
                        ? ($idoso->users?->contains('id', $user->id) ?? false)
                        : true;

                    $idade = $idoso->data_nascimento ? \Carbon\Carbon::parse($idoso->data_nascimento)->age : null;
                @endphp

                <div class="col-md-6 col-lg-4 js-idoso-card"
                     data-search="{{ strtolower($idoso->nome . ' ' . ($idoso->cpf ?? '') . ' ' . ($idoso->telefone ?? '')) }}">

                    <div class="card shadow-sm border-0 rounded-4 h-100">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center fw-bold"
                                         style="width: 52px; height: 52px;">
                                        {{ strtoupper(mb_substr($idoso->nome, 0, 1)) }}
                                    </div>

                                    <div>
                                        <h5 class="fw-bold mb-1">{{ $idoso->nome }}</h5>
                                        <div class="text-muted small">
                                            @if($idade)
                                                {{ $idade }} anos
                                            @else
                                                Idade não informada
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <span class="badge bg-light text-dark border rounded-pill">
                                    Perfil
                                </span>
                            </div>

                            <div class="text-muted small mb-3 d-flex flex-column gap-1">
                                <div><i class="bi bi-calendar3 me-1"></i> {{ \Carbon\Carbon::parse($idoso->data_nascimento)->format('d/m/Y') }}</div>
                                <div><i class="bi bi-card-text me-1"></i> CPF: {{ $idoso->cpf ?? '—' }}</div>
                                <div><i class="bi bi-telephone me-1"></i> Telefone: {{ $idoso->telefone ?? '—' }}</div>
                            </div>

                            <div class="d-flex gap-2 flex-wrap">
                                <a href="{{ route('idosos.show', $idoso->id) }}" class="btn btn-outline-primary btn-sm rounded-3">
                                    Ver perfil
                                </a>

                                @if($isAdmin)
                                    <a href="{{ route('admin.idosos') }}" class="btn btn-outline-secondary btn-sm rounded-3">
                                        <i class="bi bi-people me-1"></i> Vínculos
                                    </a>

                                    @if(!$temVinculo)
                                        <form method="POST" action="{{ route('admin.idosos.vincularAdmin', $idoso->id) }}" class="m-0">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm rounded-3">
                                                <i class="bi bi-link-45deg me-1"></i> Vincular
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('idosos.desvincular', $idoso->id) }}" class="m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-outline-danger btn-sm rounded-3"
                                                    onclick="return confirm('Deseja remover o vínculo com esta pessoa?');">
                                                <i class="bi bi-x-circle me-1"></i> Desvincular
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <form method="POST" action="{{ route('idosos.desvincular', $idoso->id) }}" class="m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm rounded-3"
                                                onclick="return confirm('Deseja remover o vínculo com esta pessoa?');">
                                            <i class="bi bi-x-circle me-1"></i> Desvincular
                                        </button>
                                    </form>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            <nav aria-label="Paginação das pessoas acompanhadas">
                <ul class="pagination mb-0" id="paginationIdososCards"></ul>
            </nav>
        </div>
    @endif

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchIdososCards');
    const pagination = document.getElementById('paginationIdososCards');
    const info = document.getElementById('cardsInfoIdosos');
    const cards = Array.from(document.querySelectorAll('.js-idoso-card'));

    const perPage = 9;
    let currentPage = 1;

    function getFilteredCards() {
        const search = (searchInput?.value || '').trim().toLowerCase();

        return cards.filter(card => {
            const text = card.dataset.search || '';
            return search === '' || text.includes(search);
        });
    }

    function renderPagination(totalPages) {
        pagination.innerHTML = '';
        if (totalPages <= 1) return;

        const delta = 2;
        const range = [];
        const rangeWithDots = [];
        let last;

        function createPageItem(label, page = null, disabled = false, active = false) {
            const li = document.createElement('li');
            li.className = 'page-item';

            if (disabled) li.classList.add('disabled');
            if (active) li.classList.add('active');

            if (page === null || disabled) {
                li.innerHTML = `<span class="page-link">${label}</span>`;
            } else {
                li.innerHTML = `<button class="page-link" type="button">${label}</button>`;
                li.addEventListener('click', () => {
                    currentPage = page;

                    if (typeof updateTable === 'function') {
                        updateTable();
                    } else if (typeof updateCards === 'function') {
                        updateCards();
                    }
                });
            }

            return li;
        }

        pagination.appendChild(
            createPageItem('Anterior', currentPage - 1, currentPage === 1)
        );

        for (let i = 1; i <= totalPages; i++) {
            if (
                i === 1 ||
                i === totalPages ||
                (i >= currentPage - delta && i <= currentPage + delta)
            ) {
                range.push(i);
            }
        }

        for (const page of range) {
            if (last !== undefined) {
                if (page - last === 2) {
                    rangeWithDots.push(last + 1);
                } else if (page - last > 2) {
                    rangeWithDots.push('...');
                }
            }

            rangeWithDots.push(page);
            last = page;
        }

        rangeWithDots.forEach(page => {
            if (page === '...') {
                pagination.appendChild(createPageItem('...', null, true));
            } else {
                pagination.appendChild(
                    createPageItem(String(page), page, false, page === currentPage)
                );
            }
        });

        pagination.appendChild(
            createPageItem('Próximo', currentPage + 1, currentPage === totalPages)
        );
    }

    function updateCards() {
        const filteredCards = getFilteredCards();
        const total = filteredCards.length;
        const totalPages = Math.max(1, Math.ceil(total / perPage));

        if (currentPage > totalPages) currentPage = totalPages;

        cards.forEach(card => card.classList.add('d-none'));

        const start = (currentPage - 1) * perPage;
        const end = start + perPage;

        filteredCards.slice(start, end).forEach(card => {
            card.classList.remove('d-none');
        });

        if (info) {
            if (total === 0) {
                info.textContent = 'Mostrando 0 de 0 registros';
            } else {
                info.textContent = `Mostrando ${start + 1} até ${Math.min(end, total)} de ${total} registros`;
            }
        }

        renderPagination(totalPages);
    }

    searchInput?.addEventListener('input', () => {
        currentPage = 1;
        updateCards();
    });

    updateCards();
});
</script>
@endpush

@endsection