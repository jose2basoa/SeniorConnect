@extends('layouts.app')

@section('content')
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Idosos Cadastrados</h2>
        <span class="badge bg-primary fs-6">Total: {{ $idosos->count() }}</span>
    </div>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

    <div class="card shadow-sm">
        <div class="card-body">

            @if($idosos->isEmpty())
                <a href="{{ route('admin.idosos.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle me-1"></i> Novo idoso
                </a>

                <div class="alert alert-info mt-2">Nenhum idoso cadastrado.</div>
            @else

                <div class="d-flex gap-2 flex-wrap mb-3 align-items-center">
                    <a href="{{ route('admin.idosos.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Novo idoso
                    </a>

                    <button id="btnToggleSelectIdoso" class="btn btn-outline-primary btn-sm" type="button">
                        <i class="bi bi-check2-square me-1"></i> Selecionar
                    </button>

                    <button id="btnSelectAllIdosos" class="btn btn-outline-secondary btn-sm d-none" type="button">
                        Selecionar todos
                    </button>

                    <button id="btnClearIdosos" class="btn btn-outline-secondary btn-sm d-none" type="button">
                        Limpar seleção
                    </button>

                    <div class="d-flex align-items-center gap-2 flex-wrap ms-auto">
                        <input
                            type="text"
                            id="searchIdosos"
                            class="form-control form-control-sm"
                            placeholder="Pesquisar idoso..."
                            style="width: 220px;"
                        >

                        <select id="filterVinculoIdosos" class="form-select form-select-sm" style="width: 160px;">
                            <option value="all" selected>Todos</option>
                            <option value="vinculado">Vinculados</option>
                            <option value="nao-vinculado">Não vinculados</option>
                        </select>

                        <div class="d-flex align-items-center gap-2">
                            <label class="small text-muted mb-0">Linhas:</label>
                            <select id="rowsPerPageIdosos" class="form-select form-select-sm" style="width: 85px;">
                                <option value="10" selected>10</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>

                    <button id="btnDeleteIdosos" class="btn btn-outline-danger btn-sm d-none" type="button" disabled
                            data-bs-toggle="modal" data-bs-target="#modalDeleteIdosos">
                        <i class="bi bi-trash me-1"></i> Apagar selecionados
                    </button>
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                    <small class="text-muted" id="tableInfoIdosos">Mostrando 0 de 0 registros</small>

                    <nav aria-label="Paginação de idosos">
                        <ul class="pagination pagination-sm mb-0" id="paginationIdosos"></ul>
                    </nav>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center js-col-select d-none" style="width: 40px;">
                                    <input class="form-check-input" type="checkbox" id="chkAllIdosos">
                                </th>
                                <th>Nome</th>
                                <th>Data Nasc.</th>
                                <th>Tutor</th>
                                <th>Email Tutor</th>
                                <th>Cadastrado em</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyIdosos">
                            @foreach($idosos as $i)
                                <tr class="js-idoso-row"
                                    data-vinculo="{{ $i->users->isNotEmpty() ? 'vinculado' : 'nao-vinculado' }}"
                                    data-search="{{ strtolower($i->nome . ' ' . ($i->cpf ?? '') . ' ' . $i->users->pluck('name')->join(' ') . ' ' . $i->users->pluck('email')->join(' ')) }}">
                                    <td class="text-center js-col-select d-none">
                                        <input class="form-check-input js-idoso-check"
                                            type="checkbox"
                                            value="{{ $i->id }}"
                                            data-name="{{ $i->nome }}">
                                    </td>
                                    <td>{{ $i->nome }}</td>
                                    <td>{{ \Carbon\Carbon::parse($i->data_nascimento)->format('d/m/Y') }}</td>
                                    <td>{{ $i->users->isNotEmpty() ? $i->users->pluck('name')->join(', ') : '-' }}</td>
                                    <td>{{ $i->users->isNotEmpty() ? $i->users->pluck('email')->join(', ') : '-' }}</td>
                                    <td>{{ $i->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            @endif
        </div>
    </div>
</div>

<div class="modal fade" id="modalDeleteIdosos" tabindex="-1" aria-hidden="true">
<div class="modal-dialog">
    <form id="deleteIdososForm" method="POST" action="{{ route('admin.idosos.destroyBulk') }}">
        @csrf
        @method('DELETE')

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Apagar cadastros</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="alert alert-warning mb-2">
                    Você está prestes a apagar <strong><span id="idososCount">0</span></strong> cadastro(s).
                    Essa ação não pode ser desfeita.
                </div>

                <div id="idososHiddenInputs"></div>
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
        const btnToggle = document.getElementById('btnToggleSelectIdoso');
        const btnAll = document.getElementById('btnSelectAllIdosos');
        const btnClear = document.getElementById('btnClearIdosos');
        const btnDelete = document.getElementById('btnDeleteIdosos');

        const colSelect = document.querySelectorAll('.js-col-select');
        const chkAll = document.getElementById('chkAllIdosos');
        const rowsSelect = document.getElementById('rowsPerPageIdosos');
        const pagination = document.getElementById('paginationIdosos');
        const tableInfo = document.getElementById('tableInfoIdosos');

        const searchInput = document.getElementById('searchIdosos');
        const filterVinculo = document.getElementById('filterVinculoIdosos');

        const modal = document.getElementById('modalDeleteIdosos');
        const countEl = document.getElementById('idososCount');
        const hiddenWrap = document.getElementById('idososHiddenInputs');

        const rows = Array.from(document.querySelectorAll('.js-idoso-row'));
        const checks = () => Array.from(document.querySelectorAll('.js-idoso-check'));

        let selectMode = false;
        let currentPage = 1;
        let rowsPerPage = parseInt(rowsSelect.value, 10);

        function getFilteredRows() {
            const search = (searchInput.value || '').trim().toLowerCase();
            const vinculo = filterVinculo.value;

            return rows.filter(row => {
                const rowVinculo = row.dataset.vinculo;
                const rowSearch = row.dataset.search || '';

                const matchesVinculo =
                    vinculo === 'all' ||
                    (vinculo === 'vinculado' && rowVinculo === 'vinculado') ||
                    (vinculo === 'nao-vinculado' && rowVinculo === 'nao-vinculado');

                const matchesSearch =
                    search === '' || rowSearch.includes(search);

                return matchesVinculo && matchesSearch;
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
                .map(row => row.querySelector('.js-idoso-check'))
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
                const check = row.querySelector('.js-idoso-check');
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
                const check = row.querySelector('.js-idoso-check');
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

        filterVinculo?.addEventListener('change', () => {
            currentPage = 1;
            updateTable();
        });

        document.addEventListener('change', (e) => {
            if (e.target.classList?.contains('js-idoso-check')) {
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
        });

        setSelectMode(false);
        updateTable();
    });
</script>
@endpush

@endsection