@extends('layouts.app')

@section('content')
<div class="container py-4 py-md-5">

    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Cadastros de pessoas acompanhadas</h2>
            <small class="text-muted">Gerencie vínculos, acompanhe tutores e organize os registros do sistema.</small>
        </div>

        <div class="d-grid d-sm-flex gap-2 w-100 w-lg-auto">
            <span class="badge bg-primary fs-6 px-3 py-2 text-center">Total: {{ $idosos->count() }}</span>
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
                    <a href="{{ route('admin.idosos.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Novo cadastro
                    </a>

                    @if($idosos->isNotEmpty())
                        <button id="btnToggleSelectIdoso" class="btn btn-outline-primary btn-sm" type="button">
                            <i class="bi bi-check2-square me-1"></i> Selecionar
                        </button>

                        <button id="btnSelectAllIdosos" class="btn btn-outline-secondary btn-sm d-none" type="button">
                            Selecionar todos
                        </button>

                        <button id="btnClearIdosos" class="btn btn-outline-secondary btn-sm d-none" type="button">
                            Limpar seleção
                        </button>

                        <button id="btnDeleteIdosos"
                                class="btn btn-outline-danger btn-sm d-none"
                                type="button"
                                disabled
                                data-bs-toggle="modal"
                                data-bs-target="#modalDeleteIdosos">
                            <i class="bi bi-person-dash me-1"></i> Remover selecionados
                        </button>
                    @endif
                </div>

                <div class="row g-2">
                    <div class="col-12 col-md-6 col-xl-4">
                        <input
                            type="text"
                            id="searchIdosos"
                            class="form-control form-control-sm"
                            placeholder="Pesquisar por nome, CPF, tutor..."
                        >
                    </div>

                    <div class="col-12 col-sm-6 col-xl-3">
                        <select id="filterVinculoIdosos" class="form-select form-select-sm">
                            <option value="all" selected>Todos</option>
                            <option value="vinculado">Vinculados</option>
                            <option value="nao-vinculado">Não vinculados</option>
                        </select>
                    </div>

                    <div class="col-12 col-sm-6 col-xl-3">
                        <select id="filterStatusIdosos" class="form-select form-select-sm">
                            <option value="all" selected>Todos status</option>
                            <option value="ativo">Ativos</option>
                            <option value="removido">Removidos</option>
                        </select>
                    </div>

                    <div class="col-12 col-sm-6 col-xl-2">
                        <div class="d-flex align-items-center gap-2">
                            <label class="small text-muted mb-0">Linhas:</label>
                            <select id="rowsPerPageIdosos" class="form-select form-select-sm">
                                <option value="10" selected>10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            @if($idosos->isEmpty())
                <div class="alert alert-info rounded-4 mb-0">
                    Nenhum cadastro encontrado no sistema.
                </div>
            @else
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2 mb-3">
                    <small class="text-muted" id="tableInfoIdosos">Mostrando 0 de 0 registros</small>

                    <nav aria-label="Paginação de cadastros">
                        <ul class="pagination pagination-sm mb-0 flex-wrap" id="paginationIdosos"></ul>
                    </nav>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center js-col-select d-none" style="width: 40px;">
                                    <input class="form-check-input" type="checkbox" id="chkAllIdosos">
                                </th>
                                <th>Nome</th>
                                <th class="d-none d-md-table-cell">Nascimento</th>
                                <th class="d-none d-lg-table-cell">CPF</th>
                                <th>Tutores</th>
                                <th class="d-none d-xl-table-cell">Emails</th>
                                <th>Status</th>
                                <th class="text-end js-actions-col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($idosos as $i)
                                <tr class="js-idoso-row"
                                    data-vinculo="{{ $i->users->isNotEmpty() ? 'vinculado' : 'nao-vinculado' }}"
                                    data-status="{{ $i->trashed() ? 'removido' : 'ativo' }}"
                                    data-search="{{ strtolower($i->nome . ' ' . ($i->cpf ?? '') . ' ' . $i->users->pluck('name')->join(' ') . ' ' . $i->users->pluck('email')->join(' ')) }}">
                                    <td class="text-center js-col-select d-none">
                                        <input class="form-check-input js-idoso-check"
                                               type="checkbox"
                                               value="{{ $i->id }}"
                                               data-name="{{ $i->nome }}"
                                               @disabled($i->trashed())>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $i->nome }}</div>
                                        @if($i->telefone)
                                            <small class="text-muted">{{ $i->telefone }}</small>
                                        @endif
                                    </td>
                                    <td class="d-none d-md-table-cell">{{ \Carbon\Carbon::parse($i->data_nascimento)->format('d/m/Y') }}</td>
                                    <td class="d-none d-lg-table-cell">{{ $i->cpf }}</td>
                                    <td>
                                        {{ $i->users->isNotEmpty() ? $i->users->pluck('name')->join(', ') : '—' }}
                                    </td>
                                    <td class="d-none d-xl-table-cell">
                                        {{ $i->users->isNotEmpty() ? $i->users->pluck('email')->join(', ') : '—' }}
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column gap-1">
                                            @if($i->users->isNotEmpty())
                                                <span class="badge bg-success">Vinculado</span>
                                            @else
                                                <span class="badge bg-secondary">Sem vínculo</span>
                                            @endif

                                            @if($i->trashed())
                                                <span class="badge bg-dark">Removido</span>
                                            @else
                                                <span class="badge bg-primary">Ativo</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-end js-actions-col">
                                        @if($i->trashed())
                                            <div class="d-inline-flex gap-2 flex-wrap justify-content-end">
                                                <form method="POST" action="{{ route('admin.idosos.restore', $i->id) }}" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-outline-success btn-sm">
                                                        <i class="bi bi-arrow-counterclockwise me-1"></i> Restaurar
                                                    </button>
                                                </form>

                                                <form method="POST" action="{{ route('admin.idosos.forceDelete', $i->id) }}" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="btn btn-outline-dark btn-sm"
                                                            onclick="return confirm('Deseja excluir definitivamente este cadastro? Essa ação não poderá ser desfeita.');">
                                                        <i class="bi bi-trash3 me-1"></i> Excluir definitivo
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <form method="POST" action="{{ route('admin.idosos.destroy', $i->id) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-outline-danger btn-sm"
                                                        onclick="return confirm('Deseja remover este cadastro da lista ativa? Ele poderá ser restaurado depois.');">
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

@if($idosos->isNotEmpty())
<div class="modal fade" id="modalDeleteIdosos" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.idosos.destroyBulk') }}">
            @csrf
            @method('DELETE')

            <div class="modal-content rounded-4 border-0">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Remover cadastros</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="alert alert-warning mb-2">
                        Você está prestes a remover <strong><span id="idososCount">0</span></strong> cadastro(s).
                        Os registros serão retirados da lista ativa e poderão ser restaurados depois.
                    </div>

                    <div id="idososHiddenInputs"></div>
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
    const btnToggle = document.getElementById('btnToggleSelectIdoso');
    const btnAll = document.getElementById('btnSelectAllIdosos');
    const btnClear = document.getElementById('btnClearIdosos');
    const btnDelete = document.getElementById('btnDeleteIdosos');

    const colSelect = document.querySelectorAll('.js-col-select');
    const actionCols = document.querySelectorAll('.js-actions-col');
    const chkAll = document.getElementById('chkAllIdosos');
    const rowsSelect = document.getElementById('rowsPerPageIdosos');
    const pagination = document.getElementById('paginationIdosos');
    const tableInfo = document.getElementById('tableInfoIdosos');

    const searchInput = document.getElementById('searchIdosos');
    const filterVinculo = document.getElementById('filterVinculoIdosos');
    const filterStatus = document.getElementById('filterStatusIdosos');

    const modal = document.getElementById('modalDeleteIdosos');
    const countEl = document.getElementById('idososCount');
    const hiddenWrap = document.getElementById('idososHiddenInputs');

    const rows = Array.from(document.querySelectorAll('.js-idoso-row'));
    const checks = () => Array.from(document.querySelectorAll('.js-idoso-check'));

    if (!rows.length) return;

    let selectMode = false;
    let currentPage = 1;
    let rowsPerPage = parseInt(rowsSelect.value, 10);

    function getFilteredRows() {
        const search = (searchInput.value || '').trim().toLowerCase();
        const vinculo = filterVinculo.value;
        const status = filterStatus.value;

        return rows.filter(row => {
            const matchesVinculo = vinculo === 'all' || row.dataset.vinculo === vinculo;
            const matchesStatus = status === 'all' || row.dataset.status === status;
            const matchesSearch = search === '' || (row.dataset.search || '').includes(search);
            return matchesVinculo && matchesStatus && matchesSearch;
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
            .map(row => row.querySelector('.js-idoso-check'))
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
            const check = row.querySelector('.js-idoso-check');
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
            const check = row.querySelector('.js-idoso-check');
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

    filterVinculo?.addEventListener('change', () => {
        currentPage = 1;
        updateTable();
    });

    filterStatus?.addEventListener('change', () => {
        currentPage = 1;
        updateTable();
    });

    document.addEventListener('change', (e) => {
        if (e.target.classList?.contains('js-idoso-check')) {
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
    });

    setSelectMode(false);
    updateTable();
});
</script>
@endpush
@endsection