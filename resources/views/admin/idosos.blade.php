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

                    <button id="btnToggleSelectIdoso" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-check2-square me-1"></i> Selecionar
                    </button>

                    <button id="btnSelectAllIdosos" class="btn btn-outline-secondary btn-sm d-none" type="button">
                        Selecionar todos
                    </button>

                    <button id="btnClearIdosos" class="btn btn-outline-secondary btn-sm d-none" type="button">
                        Limpar seleção
                    </button>

                    <button id="btnDeleteIdosos" class="btn btn-outline-danger btn-sm ms-auto" disabled
                            data-bs-toggle="modal" data-bs-target="#modalDeleteIdosos">
                        <i class="bi bi-trash me-1"></i> Apagar selecionados
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
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
                        <tbody>
                            @foreach($idosos as $i)
                                <tr>
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

{{-- Modal apagar idosos (lote) --}}
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
    const checks = () => Array.from(document.querySelectorAll('.js-idoso-check'));
    const chkAll = document.getElementById('chkAllIdosos');

    const modal = document.getElementById('modalDeleteIdosos');
    const countEl = document.getElementById('idososCount');
    const hiddenWrap = document.getElementById('idososHiddenInputs');

    let selectMode = false;

    function setSelectMode(on) {
        selectMode = on;

        colSelect.forEach(el => el.classList.toggle('d-none', !on));
        btnAll.classList.toggle('d-none', !on);
        btnClear.classList.toggle('d-none', !on);

        btnToggle.classList.toggle('btn-outline-primary', !on);
        btnToggle.classList.toggle('btn-primary', on);
        btnToggle.innerHTML = on
            ? '<i class="bi bi-x-lg me-1"></i> Cancelar seleção'
            : '<i class="bi bi-check2-square me-1"></i> Selecionar';

        if (!on) {
            checks().forEach(c => c.checked = false);
            if (chkAll) chkAll.checked = false;
            btnDelete.disabled = true;
        }
    }

    function updateDeleteState() {
        const selected = checks().filter(c => c.checked);
        btnDelete.disabled = selected.length === 0;
        if (chkAll) chkAll.checked = selected.length > 0 && selected.length === checks().length;
    }

    btnToggle?.addEventListener('click', () => setSelectMode(!selectMode));

    btnAll?.addEventListener('click', () => {
        checks().forEach(c => c.checked = true);
        updateDeleteState();
    });

    btnClear?.addEventListener('click', () => {
        checks().forEach(c => c.checked = false);
        if (chkAll) chkAll.checked = false;
        updateDeleteState();
    });

    chkAll?.addEventListener('change', () => {
        checks().forEach(c => c.checked = chkAll.checked);
        updateDeleteState();
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
});
</script>
@endpush

@endsection
