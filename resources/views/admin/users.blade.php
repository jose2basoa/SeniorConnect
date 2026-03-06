@extends('layouts.app')

@section('content')
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Usuários Cadastrados</h2>
        <span class="badge bg-primary fs-6">Total: {{ $users->count() }}</span>
    </div>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

    <div class="card shadow-sm">
        <div class="card-body">

            @if($users->isEmpty())
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle me-1"></i> Novo usuário
                </a>

                <div class="alert alert-info mt-2">Nenhum usuário cadastrado.</div>
            @else

                <div class="d-flex gap-2 flex-wrap mb-3 align-items-center">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Novo usuário
                    </a>

                    <button id="btnToggleSelectUser" class="btn btn-outline-primary btn-sm" type="button">
                        <i class="bi bi-check2-square me-1"></i> Selecionar
                    </button>

                    <button id="btnSelectAllUsers" class="btn btn-outline-secondary btn-sm d-none" type="button">
                        Selecionar todos
                    </button>

                    <button id="btnClearUsers" class="btn btn-outline-secondary btn-sm d-none" type="button">
                        Limpar seleção
                    </button>
                        <div class="d-flex align-items-center gap-2 flex-wrap ms-auto">
                            <input
                                type="text"
                                id="searchUsers"
                                class="form-control form-control-sm"
                                placeholder="Pesquisar usuário..."
                                style="width: 220px;"
                            >

                            <select id="filterTypeUsers" class="form-select form-select-sm" style="width: 140px;">
                                <option value="all" selected>Todos</option>
                                <option value="admin">Admins</option>
                                <option value="tutor">Tutores</option>
                            </select>

                            <div class="d-flex align-items-center gap-2">
                                <label class="small text-muted mb-0">Linhas:</label>
                                <select id="rowsPerPageUsers" class="form-select form-select-sm" style="width: 85px;">
                                    <option value="10" selected>10</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                        </div>

                    <button id="btnDeleteUsers"
                        class="btn btn-outline-danger btn-sm d-none"
                        disabled
                        data-bs-toggle="modal"
                        data-bs-target="#modalDeleteUsers">
                        <i class="bi bi-trash me-1"></i> Apagar selecionados
                    </button>
                </div>

                <div class="small text-muted mb-3">
                    Se apagar o usuário logado, você será deslogado automaticamente.
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                    <small class="text-muted" id="tableInfoUsers">Mostrando 0 de 0 registros</small>

                    <nav aria-label="Paginação de usuários">
                        <ul class="pagination pagination-sm mb-0" id="paginationUsers"></ul>
                    </nav>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center js-col-select d-none" style="width: 40px;">
                                    <input class="form-check-input" type="checkbox" id="chkAllUsers">
                                </th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>CPF</th>
                                <th>Qtd. Idosos</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyUsers">
                            @foreach($users as $u)
                                <tr class="js-user-row" data-type="{{ $u->is_admin ? 'admin' : 'tutor' }}" data-search="{{ strtolower($u->name . ' ' . $u->email . ' ' . $u->cpf) }}">
                                    <td class="text-center js-col-select d-none">
                                        <input class="form-check-input js-user-check"
                                            type="checkbox"
                                            value="{{ $u->id }}"
                                            data-is-admin="{{ $u->is_admin ? 1 : 0 }}"
                                            data-name="{{ $u->name }}">
                                    </td>
                                    <td>{{ $u->name }}</td>
                                    <td>{{ $u->email }}</td>
                                    <td>{{ $u->cpf }}</td>
                                    <td>{{ $u->idosos_count ?? $u->idosos->count() }}</td>
                                    <td>
                                        @if($u->is_admin)
                                            <span class="badge bg-danger">Admin</span>
                                        @else
                                            <span class="badge bg-success">Tutor</span>
                                        @endif
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

<div class="modal fade" id="modalDeleteUsers" tabindex="-1" aria-hidden="true">
<div class="modal-dialog">
    <form id="deleteUsersForm" method="POST" action="{{ route('admin.users.destroyBulk') }}">
        @csrf
        @method('DELETE')

        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title fw-bold">Apagar usuários</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
            <div class="alert alert-warning mb-2">
            Você está prestes a apagar <strong><span id="usersCount">0</span></strong> usuário(s).
            Essa ação não pode ser desfeita.
            </div>

            <div id="adminPasswordWrap" class="mt-3" style="display:none;">
                <label class="form-label fw-bold">Confirme sua senha (obrigatório para apagar administradores)</label>
                <input type="password" name="password" class="form-control" autocomplete="current-password">
                <div class="form-text">Senha do usuário logado.</div>
            </div>

            <div id="usersHiddenInputs"></div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-danger">
            <i class="bi bi-trash me-1"></i> Apagar
            </button>
        </div>
        </div>
    </form>
</div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const btnToggle = document.getElementById('btnToggleSelectUser');
        const btnAll = document.getElementById('btnSelectAllUsers');
        const btnClear = document.getElementById('btnClearUsers');
        const btnDelete = document.getElementById('btnDeleteUsers');

        const colSelect = document.querySelectorAll('.js-col-select');
        const chkAll = document.getElementById('chkAllUsers');
        const rowsSelect = document.getElementById('rowsPerPageUsers');
        const pagination = document.getElementById('paginationUsers');
        const tableInfo = document.getElementById('tableInfoUsers');

        const searchInput = document.getElementById('searchUsers');
        const filterType = document.getElementById('filterTypeUsers');

        const modal = document.getElementById('modalDeleteUsers');
        const countEl = document.getElementById('usersCount');
        const adminWrap = document.getElementById('adminPasswordWrap');
        const hiddenWrap = document.getElementById('usersHiddenInputs');

        const rows = Array.from(document.querySelectorAll('.js-user-row'));
        const checks = () => Array.from(document.querySelectorAll('.js-user-check'));

        let selectMode = false;
        let currentPage = 1;
        let rowsPerPage = parseInt(rowsSelect.value, 10);

        function getFilteredRows() {
            const search = (searchInput.value || '').trim().toLowerCase();
            const type = filterType.value;

            return rows.filter(row => {
                const rowType = row.dataset.type;
                const rowSearch = row.dataset.search || '';

                const matchesType =
                    type === 'all' ||
                    (type === 'admin' && rowType === 'admin') ||
                    (type === 'tutor' && rowType === 'tutor');

                const matchesSearch =
                    search === '' || rowSearch.includes(search);

                return matchesType && matchesSearch;
            });
        }

        function getPageRows(filteredRows) {
            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            return filteredRows.slice(start, end);
        }

        function renderPagination(totalPages) {
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
                    updateTable();
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
                        updateTable();
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
                    updateTable();
                }
            });
            pagination.appendChild(next);
        }

        function updateDeleteState() {
            const selected = checks().filter(c => c.checked);
            btnDelete.disabled = selected.length === 0;

            const filteredRows = getFilteredRows();
            const pageRows = getPageRows(filteredRows);

            const pageChecks = pageRows
                .map(row => row.querySelector('.js-user-check'))
                .filter(Boolean);

            if (chkAll) {
                chkAll.checked = pageChecks.length > 0 && pageChecks.every(c => c.checked);
            }
        }

        function updateTable() {
            rowsPerPage = parseInt(rowsSelect.value, 10);

            const filteredRows = getFilteredRows();
            const totalRows = filteredRows.length;
            const totalPages = Math.max(1, Math.ceil(totalRows / rowsPerPage));

            if (currentPage > totalPages) currentPage = totalPages;

            rows.forEach(row => row.classList.add('d-none'));

            const pageRows = getPageRows(filteredRows);
            pageRows.forEach(row => row.classList.remove('d-none'));

            const start = totalRows === 0 ? 0 : ((currentPage - 1) * rowsPerPage) + 1;
            const end = Math.min(currentPage * rowsPerPage, totalRows);

            tableInfo.textContent = `Mostrando ${start} até ${end} de ${totalRows} registros`;
            renderPagination(totalPages);
            updateDeleteState();
        }

        function setSelectMode(on) {
            selectMode = on;

            colSelect.forEach(el => el.classList.toggle('d-none', !on));
            btnAll.classList.toggle('d-none', !on);
            btnClear.classList.toggle('d-none', !on);
            btnDelete.classList.toggle('d-none', !on);

            btnToggle.classList.toggle('btn-outline-primary', !on);
            btnToggle.classList.toggle('btn-primary', on);

            btnToggle.innerHTML = on
                ? '<i class="bi bi-x-lg me-1"></i> Cancelar seleção'
                : '<i class="bi bi-check2-square me-1"></i> Selecionar';

            if (!on) {
                checks().forEach(c => c.checked = false);
                if (chkAll) chkAll.checked = false;
                btnDelete.disabled = true;
            } else {
                updateDeleteState();
            }
        }

        btnToggle?.addEventListener('click', () => setSelectMode(!selectMode));

        btnAll?.addEventListener('click', () => {
            const filteredRows = getFilteredRows();
            const pageRows = getPageRows(filteredRows);

            pageRows.forEach(row => {
                const check = row.querySelector('.js-user-check');
                if (check) check.checked = true;
            });

            updateDeleteState();
        });

        btnClear?.addEventListener('click', () => {
            checks().forEach(c => c.checked = false);
            if (chkAll) chkAll.checked = false;
            updateDeleteState();
        });

        chkAll?.addEventListener('change', () => {
            const filteredRows = getFilteredRows();
            const pageRows = getPageRows(filteredRows);

            pageRows.forEach(row => {
                const check = row.querySelector('.js-user-check');
                if (check) check.checked = chkAll.checked;
            });

            updateDeleteState();
        });

        rowsSelect?.addEventListener('change', () => {
            currentPage = 1;
            updateTable();
        });

        searchInput?.addEventListener('input', () => {
            currentPage = 1;
            updateTable();
        });

        filterType?.addEventListener('change', () => {
            currentPage = 1;
            updateTable();
        });

        document.addEventListener('change', (e) => {
            if (e.target.classList?.contains('js-user-check')) {
                updateDeleteState();
            }
        });

        modal?.addEventListener('show.bs.modal', () => {
            const selected = checks().filter(c => c.checked);

            countEl.textContent = String(selected.length);

            hiddenWrap.innerHTML = '';
            selected.forEach(c => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = c.value;
                hiddenWrap.appendChild(input);
            });

            const hasAdmin = selected.some(c => c.dataset.isAdmin === '1');
            adminWrap.style.display = hasAdmin ? '' : 'none';

            const pwd = adminWrap.querySelector('input[name="password"]');
            if (pwd) pwd.value = '';
        });

        setSelectMode(false);
        updateTable();
    });
</script>
@endpush

@endsection