@extends('layouts.app')

@section('content')
<div class="container py-5">

    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Painel Administrativo</h2>
            <small class="text-muted">
                Visão geral do sistema, vínculos e cadastros recentes.
            </small>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="bi bi-person-plus me-1"></i> Novo usuário
            </a>
            <a href="{{ route('admin.idosos.create') }}" class="btn btn-outline-primary">
                <i class="bi bi-person-hearts me-1"></i> Novo cadastro
            </a>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Voltar ao painel
            </a>
        </div>
    </div>

    <div class="row g-4 mb-4">

        <div class="col-md-6 col-xl-3">
            <button type="button"
                    class="card shadow-sm border-0 bg-primary text-white w-100 text-start p-0 js-filter ring-active rounded-4"
                    data-filter="users">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="opacity-75 small">Total de usuários</div>
                            <div class="fs-2 fw-bold">{{ $totalUsers }}</div>
                        </div>
                        <div class="fs-3 opacity-75">
                            <i class="bi bi-people"></i>
                        </div>
                    </div>
                    <small class="opacity-75">Visualizar usuários recentes</small>
                </div>
            </button>
        </div>

        <div class="col-md-6 col-xl-3">
            <button type="button"
                    class="card shadow-sm border-0 bg-warning text-dark w-100 text-start p-0 js-filter rounded-4"
                    data-filter="idosos">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="opacity-75 small">Total de Tutorados</div>
                            <div class="fs-2 fw-bold">{{ $totalIdosos }}</div>
                        </div>
                        <div class="fs-3 opacity-75">
                            <i class="bi bi-person-hearts"></i>
                        </div>
                    </div>
                    <small class="opacity-75">Visualizar tutorados recentes</small>
                </div>
            </button>
        </div>

        <div class="col-md-6 col-xl-3">
            <button type="button"
                    class="card shadow-sm border-0 bg-success text-white w-100 text-start p-0 js-filter rounded-4"
                    data-filter="tutores">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="opacity-75 small">Tutores</div>
                            <div class="fs-2 fw-bold">{{ $totalTutores }}</div>
                        </div>
                        <div class="fs-3 opacity-75">
                            <i class="bi bi-person-check"></i>
                        </div>
                    </div>
                    <small class="opacity-75">Usuários sem privilégio admin</small>
                </div>
            </button>
        </div>

        <div class="col-md-6 col-xl-3">
            <button type="button"
                    class="card shadow-sm border-0 bg-danger text-white w-100 text-start p-0 js-filter rounded-4"
                    data-filter="admins">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="opacity-75 small">Administradores</div>
                            <div class="fs-2 fw-bold">{{ $totalAdmins }}</div>
                        </div>
                        <div class="fs-3 opacity-75">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                    </div>
                    <small class="opacity-75">Usuários com acesso total</small>
                </div>
            </button>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted">Cadastros vinculados</div>
                        <div class="fs-2 fw-bold">{{ $idososComTutor ?? 0 }}</div>
                        <small class="text-muted">Com pelo menos 1 tutor associado</small>
                    </div>
                    <div class="fs-1 text-success">
                        <i class="bi bi-link-45deg"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted">Cadastros sem vínculo</div>
                        <div class="fs-2 fw-bold">{{ $idososSemTutor ?? 0 }}</div>
                        <small class="text-muted">Sem tutor associado</small>
                    </div>
                    <div class="fs-1 text-danger">
                        <i class="bi bi-unlink"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-header bg-light rounded-top-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <div class="fw-bold" id="list-title">Usuários recentes</div>
                <small class="text-muted">Listagem dinâmica por categoria</small>
            </div>

            <div class="d-flex align-items-center gap-2 flex-wrap">
                <label class="small text-muted mb-0">Linhas:</label>
                <select id="rowsPerPage" class="form-select form-select-sm" style="width: 85px;">
                    <option value="10" selected>10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>

                <span class="badge bg-secondary" id="list-count">{{ $ultimosUsuarios->count() }}</span>

                <a href="{{ route('admin.users') }}" class="btn btn-sm btn-outline-secondary" id="link-users">
                    Gerenciar usuários
                </a>

                <a href="{{ route('admin.idosos') }}" class="btn btn-sm btn-outline-secondary d-none" id="link-idosos">
                    Gerenciar tutorados
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <small class="text-muted" id="table-info">Mostrando 0 de 0 registros</small>
                <nav aria-label="Paginação da tabela">
                    <ul class="pagination pagination-sm mb-0" id="table-pagination"></ul>
                </nav>
            </div>

            <div id="table-users" class="table-responsive">
                @if($ultimosUsuarios->isEmpty())
                    <div class="alert alert-info mb-0">
                        Nenhum usuário encontrado.
                    </div>
                @else
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nome</th>
                                <th class="d-none d-md-table-cell">Email</th>
                                <th class="d-none d-lg-table-cell">CPF</th>
                                <th>Tipo</th>
                                <th class="d-none d-md-table-cell">Cadastro</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ultimosUsuarios as $user)
                                <tr data-is-admin="{{ $user->is_admin ? 1 : 0 }}">
                                    <td>
                                        <div class="fw-semibold">{{ $user->nome_completo ?? $user->name }}</div>
                                        @if(!empty($user->telefone))
                                            <small class="text-muted">{{ $user->telefone }}</small>
                                        @endif
                                    </td>
                                    <td class="d-none d-md-table-cell">{{ $user->email }}</td>
                                    <td class="d-none d-lg-table-cell">{{ $user->cpf }}</td>
                                    <td>
                                        @if($user->is_admin)
                                            <span class="badge bg-danger">Admin</span>
                                        @else
                                            <span class="badge bg-success">Tutor</span>
                                        @endif
                                    </td>
                                    <td class="d-none d-md-table-cell">{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <div id="table-idosos" class="table-responsive d-none">
                @if(($ultimosIdosos ?? collect())->isEmpty())
                    <div class="alert alert-info mb-0">
                        Nenhum cadastro encontrado.
                    </div>
                @else
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nome</th>
                                <th class="d-none d-md-table-cell">Nascimento</th>
                                <th class="d-none d-lg-table-cell">CPF</th>
                                <th class="d-none d-md-table-cell">Tutores</th>
                                <th>Status de vínculo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(($ultimosIdosos ?? collect()) as $idoso)
                                <tr>
                                    <td class="fw-semibold">{{ $idoso->nome }}</td>
                                    <td class="d-none d-md-table-cell">{{ \Carbon\Carbon::parse($idoso->data_nascimento)->format('d/m/Y') }}</td>
                                    <td class="d-none d-lg-table-cell">{{ $idoso->cpf }}</td>
                                    <td class="d-none d-md-table-cell">
                                        @if($idoso->users->isNotEmpty())
                                            {{ $idoso->users->pluck('name')->join(', ') }}
                                        @else
                                            <span class="text-muted">Nenhum tutor</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($idoso->users->isNotEmpty())
                                            <span class="badge bg-success">Vinculado</span>
                                        @else
                                            <span class="badge bg-secondary">Sem vínculo</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="fw-bold mb-0">Cadastros de usuários</h5>
                        <small class="text-muted">Últimos 14 dias</small>
                    </div>
                    <canvas id="chartUsers" height="140"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="fw-bold mb-0">Cadastros de idosos</h5>
                        <small class="text-muted">Últimos 14 dias</small>
                    </div>
                    <canvas id="chartIdosos" height="140"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('.js-filter');
    const title = document.getElementById('list-title');
    const countBadge = document.getElementById('list-count');

    const tableUsers = document.getElementById('table-users');
    const tableIdosos = document.getElementById('table-idosos');

    const linkUsers = document.getElementById('link-users');
    const linkIdosos = document.getElementById('link-idosos');

    const rowsSelect = document.getElementById('rowsPerPage');
    const pagination = document.getElementById('table-pagination');
    const tableInfo = document.getElementById('table-info');

    const userRows = tableUsers ? Array.from(tableUsers.querySelectorAll('tbody tr')) : [];
    const idosoRows = tableIdosos ? Array.from(tableIdosos.querySelectorAll('tbody tr')) : [];

    let currentFilter = 'users';
    let currentPage = 1;
    let rowsPerPage = parseInt(rowsSelect.value, 10);

    function setActive(btn) {
        buttons.forEach(b => b.classList.remove('ring-active'));
        btn.classList.add('ring-active');
    }

    function getCurrentRows() {
        if (currentFilter === 'idosos') return idosoRows;
        if (currentFilter === 'admins') return userRows.filter(row => row.dataset.isAdmin === '1');
        if (currentFilter === 'tutores') return userRows.filter(row => row.dataset.isAdmin === '0');
        return userRows;
    }

    function hideAllRows() {
        [...userRows, ...idosoRows].forEach(row => row.classList.add('d-none'));
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

    function updateTable() {
        rowsPerPage = parseInt(rowsSelect.value, 10);
        const rows = getCurrentRows();
        const totalRows = rows.length;
        const totalPages = Math.max(1, Math.ceil(totalRows / rowsPerPage));

        if (currentPage > totalPages) currentPage = totalPages;

        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;

        hideAllRows();
        rows.slice(start, end).forEach(row => row.classList.remove('d-none'));

        countBadge.textContent = totalRows;
        tableInfo.textContent = totalRows === 0
            ? 'Mostrando 0 de 0 registros'
            : `Mostrando ${start + 1} até ${Math.min(end, totalRows)} de ${totalRows} registros`;

        renderPagination(totalPages);
    }

    function showUsers(mode) {
        currentFilter = mode;
        currentPage = 1;

        tableIdosos.classList.add('d-none');
        tableUsers.classList.remove('d-none');
        linkIdosos.classList.add('d-none');
        linkUsers.classList.remove('d-none');

        if (mode === 'admins') title.textContent = 'Administradores recentes';
        else if (mode === 'tutores') title.textContent = 'Tutores recentes';
        else title.textContent = 'Usuários recentes';

        updateTable();
    }

    function showIdosos() {
        currentFilter = 'idosos';
        currentPage = 1;

        tableUsers.classList.add('d-none');
        tableIdosos.classList.remove('d-none');
        linkUsers.classList.add('d-none');
        linkIdosos.classList.remove('d-none');
        title.textContent = 'Cadastros recentes';

        updateTable();
    }

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            setActive(btn);
            const filter = btn.dataset.filter;
            filter === 'idosos' ? showIdosos() : showUsers(filter);
        });
    });

    rowsSelect.addEventListener('change', () => {
        currentPage = 1;
        updateTable();
    });

    const labels = @json($labels ?? []);
    const users = @json($usersByDay ?? []);
    const idosos = @json($idososByDay ?? []);

    const common = {
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: { beginAtZero: true, ticks: { precision: 0 } }
        }
    };

    const elUsers = document.getElementById('chartUsers');
    const elIdosos = document.getElementById('chartIdosos');

    if (elUsers && labels.length) {
        new Chart(elUsers, {
            type: 'line',
            data: {
                labels,
                datasets: [{
                    label: 'Usuários',
                    data: users,
                    tension: 0.35,
                    fill: true
                }]
            },
            options: common
        });
    }

    if (elIdosos && labels.length) {
        new Chart(elIdosos, {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: 'Cadastros',
                    data: idosos,
                    borderWidth: 1
                }]
            },
            options: common
        });
    }

    showUsers('users');
});
</script>

<style>
.js-filter{
    border-radius: 1rem;
    transition: all .18s ease;
    cursor: pointer;
}
.js-filter:hover{
    transform: translateY(-4px);
    filter: brightness(1.04);
    box-shadow: 0 8px 18px rgba(0,0,0,0.12);
}
.ring-active{
    transform: translateY(-2px);
    filter: brightness(1.1);
    box-shadow: 0 10px 22px rgba(0,0,0,0.18);
    outline: 3px solid rgba(255,255,255,.55);
}
.bg-warning.ring-active{
    outline: 3px solid rgba(0,0,0,.18);
}
.js-filter:active{
    transform: scale(.98);
}
</style>
@endpush
@endsection