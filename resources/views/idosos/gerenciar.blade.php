@extends('layouts.app')

@section('content')
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Gerenciar pessoas acompanhadas</h3>
            <small class="text-muted">Acesse o perfil, edite dados e gerencie vínculos.</small>
        </div>

        <div class="d-flex gap-2 flex-wrap align-items-center">
            <a href="{{ route('idosos.cadastrar') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Cadastrar
            </a>

            <input
                type="text"
                id="searchIdososCards"
                class="form-control"
                placeholder="Pesquisar pessoa..."
                style="width: 240px;"
            >

            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Voltar ao painel
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('erro'))
        <div class="alert alert-danger">{{ session('erro') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
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
                <p class="text-muted mb-0">
                    Cadastre uma pessoa acompanhada ou vincule um cadastro já existente.
                </p>
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
                @endphp

                <div class="col-md-6 col-lg-4 js-idoso-card"
                     data-search="{{ strtolower($idoso->nome . ' ' . ($idoso->cpf ?? '') . ' ' . ($idoso->telefone ?? '')) }}">

                    <div class="card shadow-sm border-0 rounded-4 h-100">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h5 class="fw-bold mb-1">{{ $idoso->nome }}</h5>
                                    <div class="text-muted small">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        {{ \Carbon\Carbon::parse($idoso->data_nascimento)->format('d/m/Y') }}
                                    </div>
                                </div>
                                <span class="badge bg-light text-dark border">
                                    <i class="bi bi-person-vcard me-1"></i> Perfil
                                </span>
                            </div>

                            <div class="text-muted small mb-3">
                                <div><i class="bi bi-card-text me-1"></i> CPF: {{ $idoso->cpf ?? '—' }}</div>
                                <div><i class="bi bi-telephone me-1"></i> Telefone: {{ $idoso->telefone ?? '—' }}</div>
                            </div>

                            <div class="d-flex gap-2 flex-wrap">
                                <a href="{{ route('idosos.show', $idoso->id) }}" class="btn btn-outline-primary btn-sm">
                                    Ver perfil
                                </a>

                                @if($isAdmin && !$temVinculo)
                                    <a href="{{ route('admin.idosos') }}" class="btn btn-outline-secondary btn-sm">
                                        <i class="bi bi-people me-1"></i> Vínculos
                                    </a>

                                    <form method="POST" action="{{ route('idosos.vincular.admin', $idoso->id) }}" class="m-0">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="bi bi-link-45deg me-1"></i> Vincular
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('admin.idosos') }}" class="btn btn-outline-secondary btn-sm">
                                        <i class="bi bi-people me-1"></i> Vínculos
                                    </a>

                                    <form method="POST" action="{{ route('idosos.desvincular', $idoso->id) }}" class="m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm"
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
            if (!pagination) return;

            pagination.innerHTML = '';
            if (totalPages <= 1) return;

            const items = [];

            if (totalPages <= 7) {
                for (let i = 1; i <= totalPages; i++) items.push(i);
            } else if (currentPage <= 3) {
                items.push(1, 2, 3, '...', totalPages);
            } else if (currentPage >= totalPages - 2) {
                items.push(1, '...', totalPages - 2, totalPages - 1, totalPages);
            } else {
                items.push(1, '...', currentPage - 1, currentPage, currentPage + 1, '...', totalPages);
            }

            const prev = document.createElement('li');
            prev.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
            prev.innerHTML = `<button class="page-link" type="button">Anterior</button>`;
            prev.addEventListener('click', () => {
                if (currentPage > 1) {
                    currentPage--;
                    updateCards();
                }
            });
            pagination.appendChild(prev);

            items.forEach(item => {
                const li = document.createElement('li');

                if (item === '...') {
                    li.className = 'page-item disabled';
                    li.innerHTML = `<span class="page-link">...</span>`;
                } else {
                    li.className = `page-item ${item === currentPage ? 'active' : ''}`;
                    li.innerHTML = `<button class="page-link" type="button">${item}</button>`;
                    li.addEventListener('click', () => {
                        currentPage = item;
                        updateCards();
                    });
                }

                pagination.appendChild(li);
            });

            const next = document.createElement('li');
            next.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
            next.innerHTML = `<button class="page-link" type="button">Próxima</button>`;
            next.addEventListener('click', () => {
                if (currentPage < totalPages) {
                    currentPage++;
                    updateCards();
                }
            });
            pagination.appendChild(next);
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