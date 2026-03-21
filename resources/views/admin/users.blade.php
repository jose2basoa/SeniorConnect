@extends('layouts.app')

@section('content')
<div class="container py-4 py-md-5">

    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Usuários cadastrados</h2>
            <small class="text-muted">Gerencie administradores e tutores vinculados ao sistema.</small>
        </div>

        <div class="d-grid d-sm-flex gap-2 w-100 w-lg-auto">
            <span class="badge bg-primary fs-6 px-3 py-2 text-center">Total: {{ $users->count() }}</span>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Voltar ao painel
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-4">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger rounded-4">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger rounded-4">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-3 p-md-4">

            <div class="d-flex flex-column gap-3 mb-3">
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Novo usuário
                    </a>

                    @if($users->isNotEmpty())
                        <button id="btnToggleSelectUser" class="btn btn-outline-primary btn-sm" type="button">
                            <i class="bi bi-check2-square me-1"></i> Selecionar
                        </button>

                        <button id="btnSelectAllUsers" class="btn btn-outline-secondary btn-sm d-none" type="button">
                            Selecionar todos
                        </button>

                        <button id="btnClearUsers" class="btn btn-outline-secondary btn-sm d-none" type="button">
                            Limpar seleção
                        </button>

                        <button id="btnDeleteUsers"
                                class="btn btn-outline-danger btn-sm d-none"
                                disabled
                                data-bs-toggle="modal"
                                data-bs-target="#modalDeleteUsers">
                            <i class="bi bi-person-dash me-1"></i> Remover selecionados
                        </button>
                    @endif
                </div>

                <div class="row g-2">
                    <div class="col-12 col-md-6 col-xl-4">
                        <input
                            type="text"
                            id="searchUsers"
                            class="form-control form-control-sm"
                            placeholder="Pesquisar usuário..."
                        >
                    </div>

                    <div class="col-12 col-sm-6 col-xl-3">
                        <select id="filterTypeUsers" class="form-select form-select-sm">
                            <option value="all" selected>Todos</option>
                            <option value="admin">Admins</option>
                            <option value="tutor">Tutores</option>
                        </select>
                    </div>

                    <div class="col-12 col-sm-6 col-xl-3">
                        <select id="filterStatusUsers" class="form-select form-select-sm">
                            <option value="all" selected>Todos status</option>
                            <option value="ativo">Ativos</option>
                            <option value="removido">Removidos</option>
                        </select>
                    </div>

                    <div class="col-12 col-sm-6 col-xl-2">
                        <div class="d-flex align-items-center gap-2">
                            <label class="small text-muted mb-0">Linhas:</label>
                            <select id="rowsPerPageUsers" class="form-select form-select-sm">
                                <option value="10" selected>10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            @if($users->isEmpty())
                <div class="alert alert-info rounded-4 mb-0">
                    Nenhum usuário cadastrado até o momento.
                </div>
            @else
                <div class="small text-muted mb-3">
                    Se o usuário logado for removido, a sessão será encerrada automaticamente.
                </div>

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2 mb-3">
                    <small class="text-muted" id="tableInfoUsers">Mostrando 0 de 0 registros</small>

                    <nav aria-label="Paginação de usuários">
                        <ul class="pagination pagination-sm mb-0 flex-wrap" id="paginationUsers"></ul>
                    </nav>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center js-col-select d-none" style="width: 40px;">
                                    <input class="form-check-input" type="checkbox" id="chkAllUsers">
                                </th>
                                <th>Nome</th>
                                <th class="d-none d-md-table-cell">Email</th>
                                <th class="d-none d-lg-table-cell">CPF</th>
                                <th class="d-none d-xl-table-cell">Qtd. acompanhados</th>
                                <th>Status</th>
                                <th class="text-end js-actions-col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $u)
                                <tr class="js-user-row"
                                    data-type="{{ $u->is_admin ? 'admin' : 'tutor' }}"
                                    data-status="{{ $u->trashed() ? 'removido' : 'ativo' }}"
                                    data-search="{{ strtolower(($u->nome_completo ?? $u->name) . ' ' . $u->email . ' ' . $u->cpf) }}">
                                    <td class="text-center js-col-select d-none">
                                        <input class="form-check-input js-user-check"
                                               type="checkbox"
                                               value="{{ $u->id }}"
                                               data-is-admin="{{ $u->is_admin ? 1 : 0 }}"
                                               data-name="{{ $u->name }}"
                                               @disabled($u->trashed())>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $u->nome_completo ?? $u->name }}</div>
                                        @if(!empty($u->telefone))
                                            <small class="text-muted">{{ $u->telefone }}</small>
                                        @endif
                                    </td>
                                    <td class="d-none d-md-table-cell">{{ $u->email }}</td>
                                    <td class="d-none d-lg-table-cell">{{ $u->cpf }}</td>
                                    <td class="d-none d-xl-table-cell">{{ $u->idosos_count ?? 0 }}</td>
                                    <td>
                                        <div class="d-flex flex-column gap-1">
                                            @if($u->is_admin)
                                                <span class="badge bg-danger">Admin</span>
                                            @else
                                                <span class="badge bg-success">Tutor</span>
                                            @endif

                                            @if($u->trashed())
                                                <span class="badge bg-secondary">Removido</span>
                                            @else
                                                <span class="badge bg-primary">Ativo</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-end js-actions-col">
                                        @if($u->trashed())
                                            <div class="d-inline-flex gap-2 flex-wrap justify-content-end">
                                                <form method="POST" action="{{ route('admin.users.restore', $u->id) }}" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-outline-success btn-sm">
                                                        <i class="bi bi-arrow-counterclockwise me-1"></i> Restaurar
                                                    </button>
                                                </form>

                                                <form method="POST" action="{{ route('admin.users.forceDelete', $u->id) }}" class="d-inline js-force-delete-user-form">
                                                    @csrf
                                                    @method('DELETE')

                                                    @if($u->is_admin)
                                                        <input type="hidden" name="password" value="">
                                                    @endif

                                                    <button type="submit"
                                                            class="btn btn-outline-dark btn-sm js-btn-force-delete-user"
                                                            data-user-name="{{ $u->nome_completo ?? $u->name }}"
                                                            data-is-admin="{{ $u->is_admin ? 1 : 0 }}">
                                                        <i class="bi bi-trash3 me-1"></i> Excluir definitivo
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}" class="d-inline js-form-remove-user">
                                                @csrf
                                                @method('DELETE')

                                                @if($u->is_admin)
                                                    <input type="hidden" name="password" value="">
                                                @endif

                                                <button type="submit"
                                                        class="btn btn-outline-danger btn-sm js-btn-remove-user"
                                                        data-user-name="{{ $u->nome_completo ?? $u->name }}"
                                                        data-is-admin="{{ $u->is_admin ? 1 : 0 }}">
                                                    <i class="bi bi-person-dash me-1"></i> Remover
                                                </button>
                                            </form>
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

@if($users->isNotEmpty())
<div class="modal fade" id="modalDeleteUsers" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.users.destroyBulk') }}">
            @csrf
            @method('DELETE')

            <div class="modal-content rounded-4 border-0">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Remover usuários</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="alert alert-warning mb-2">
                        Você está prestes a remover <strong><span id="usersCount">0</span></strong> usuário(s).
                        Os registros serão retirados da lista ativa e poderão ser restaurados depois.
                    </div>

                    <div id="adminPasswordWrap" class="mt-3" style="display:none;">
                        <label class="form-label fw-bold">Confirme sua senha</label>
                        <input type="password" name="password" class="form-control" autocomplete="current-password">
                        <div class="form-text">Obrigatório quando houver administrador entre os selecionados.</div>
                    </div>

                    <div id="usersHiddenInputs"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-person-dash me-1"></i> Remover
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endif

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const btnToggle = document.getElementById('btnToggleSelectUser');
    const btnAll = document.getElementById('btnSelectAllUsers');
    const btnClear = document.getElementById('btnClearUsers');
    const btnDelete = document.getElementById('btnDeleteUsers');

    const colSelect = document.querySelectorAll('.js-col-select');
    const actionCols = document.querySelectorAll('.js-actions-col');
    const chkAll = document.getElementById('chkAllUsers');
    const rowsSelect = document.getElementById('rowsPerPageUsers');
    const pagination = document.getElementById('paginationUsers');
    const tableInfo = document.getElementById('tableInfoUsers');

    const searchInput = document.getElementById('searchUsers');
    const filterType = document.getElementById('filterTypeUsers');
    const filterStatus = document.getElementById('filterStatusUsers');

    const modal = document.getElementById('modalDeleteUsers');
    const countEl = document.getElementById('usersCount');
    const adminWrap = document.getElementById('adminPasswordWrap');
    const hiddenWrap = document.getElementById('usersHiddenInputs');

    const rows = Array.from(document.querySelectorAll('.js-user-row'));
    const checks = () => Array.from(document.querySelectorAll('.js-user-check'));

    if (!rows.length) return;

    let selectMode = false;
    let currentPage = 1;
    let rowsPerPage = parseInt(rowsSelect.value, 10);

    function getFilteredRows() {
        const search = (searchInput.value || '').trim().toLowerCase();
        const type = filterType.value;
        const status = filterStatus.value;

        return rows.filter(row => {
            const matchesType = type === 'all' || row.dataset.type === type;
            const matchesStatus = status === 'all' || row.dataset.status === status;
            const matchesSearch = search === '' || (row.dataset.search || '').includes(search);
            return matchesType && matchesStatus && matchesSearch;
        });
    }

    function getPageRows(filteredRows) {
        const start = (currentPage - 1) * rowsPerPage;
        return filteredRows.slice(start, start + rowsPerPage);
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
                    updateTable();
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

    function updateDeleteState() {
        const selected = checks().filter(c => c.checked && !c.disabled);
        btnDelete.disabled = selected.length === 0;

        const pageChecks = getPageRows(getFilteredRows())
            .map(row => row.querySelector('.js-user-check'))
            .filter(check => check && !check.disabled);

        if (chkAll) {
            chkAll.checked = pageChecks.length > 0 && pageChecks.every(c => c.checked);
            chkAll.indeterminate = pageChecks.some(c => c.checked) && !pageChecks.every(c => c.checked);
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
        actionCols.forEach(el => el.classList.toggle('d-none', on));
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
            if (chkAll) {
                chkAll.checked = false;
                chkAll.indeterminate = false;
            }
            btnDelete.disabled = true;
        } else {
            updateDeleteState();
        }
    }

    btnToggle?.addEventListener('click', () => setSelectMode(!selectMode));

    btnAll?.addEventListener('click', () => {
        getPageRows(getFilteredRows()).forEach(row => {
            const check = row.querySelector('.js-user-check');
            if (check && !check.disabled) check.checked = true;
        });
        updateDeleteState();
    });

    btnClear?.addEventListener('click', () => {
        checks().forEach(c => c.checked = false);
        if (chkAll) {
            chkAll.checked = false;
            chkAll.indeterminate = false;
        }
        updateDeleteState();
    });

    chkAll?.addEventListener('change', () => {
        getPageRows(getFilteredRows()).forEach(row => {
            const check = row.querySelector('.js-user-check');
            if (check && !check.disabled) check.checked = chkAll.checked;
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

    filterStatus?.addEventListener('change', () => {
        currentPage = 1;
        updateTable();
    });

    document.addEventListener('change', (e) => {
        if (e.target.classList?.contains('js-user-check')) {
            updateDeleteState();
        }
    });

    modal?.addEventListener('show.bs.modal', () => {
        const selected = checks().filter(c => c.checked && !c.disabled);

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

    document.querySelectorAll('.js-btn-remove-user').forEach(button => {
        button.addEventListener('click', (e) => {
            const isAdmin = button.dataset.isAdmin === '1';

            if (!isAdmin) {
                const ok = confirm('Deseja remover este usuário da lista ativa? Ele poderá ser restaurado depois.');
                if (!ok) e.preventDefault();
                return;
            }

            e.preventDefault();

            const senha = prompt('Para remover um administrador, confirme sua senha:');
            if (senha === null || senha.trim() === '') {
                return;
            }

            const form = button.closest('form');
            const hiddenPassword = form.querySelector('input[name="password"]');

            if (hiddenPassword) {
                hiddenPassword.value = senha;
            }

            form.submit();
        });
    });

    document.querySelectorAll('.js-btn-force-delete-user').forEach(button => {
        button.addEventListener('click', (e) => {
            const isAdmin = button.dataset.isAdmin === '1';
            const userName = button.dataset.userName || 'este usuário';

            const confirmacao = confirm(`Deseja excluir definitivamente ${userName}? Essa ação não poderá ser desfeita.`);
            if (!confirmacao) {
                e.preventDefault();
                return;
            }

            if (!isAdmin) {
                return;
            }

            e.preventDefault();

            const senha = prompt('Para excluir definitivamente um administrador, confirme sua senha:');
            if (senha === null || senha.trim() === '') {
                return;
            }

            const form = button.closest('form');
            const hiddenPassword = form.querySelector('input[name="password"]');

            if (hiddenPassword) {
                hiddenPassword.value = senha;
            }

            form.submit();
        });
    });

    setSelectMode(false);
    updateTable();
});
</script>
@endpush
@endsection