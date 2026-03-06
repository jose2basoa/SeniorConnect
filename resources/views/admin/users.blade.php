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
                <a href="{{ route('admin.idosos.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle me-1"></i> Novo Usuário
                </a>

                <div class="alert alert-info mt-2">Nenhum Usuário cadastrado.</div>
            @else

                {{-- Barra de ações --}}
                <div class="d-flex gap-2 flex-wrap mb-3 align-items-center">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Novo usuário
                    </a>

                    <button id="btnToggleSelectUser" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-check2-square me-1"></i> Selecionar
                    </button>

                    <button id="btnSelectAllUsers" class="btn btn-outline-secondary btn-sm d-none" type="button">
                        Selecionar todos
                    </button>

                    <button id="btnClearUsers" class="btn btn-outline-secondary btn-sm d-none" type="button">
                        Limpar seleção
                    </button>

                    <button id="btnDeleteUsers"
                        class="btn btn-outline-danger btn-sm ms-auto d-none"
                        disabled
                        data-bs-toggle="modal"
                        data-bs-target="#modalDeleteUsers">
                        <i class="bi bi-trash me-1"></i> Apagar selecionados
                    </button>
                </div>

                <div class="small text-muted mb-3">
                    Se apagar o usuário logado, você será deslogado automaticamente.
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
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
                        <tbody>
                            @foreach($users as $u)
                                <tr>
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

{{-- Modal apagar usuários (lote) --}}
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

            {{-- aqui o JS injeta inputs hidden ids[] --}}
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
    const checks = () => Array.from(document.querySelectorAll('.js-user-check'));
    const chkAll = document.getElementById('chkAllUsers');

    const modal = document.getElementById('modalDeleteUsers');
    const countEl = document.getElementById('usersCount');
    const adminWrap = document.getElementById('adminPasswordWrap');
    const hiddenWrap = document.getElementById('usersHiddenInputs');

    let selectMode = false;

    function setSelectMode(on) {
        selectMode = on;

        colSelect.forEach(el => el.classList.toggle('d-none', !on));
        btnAll.classList.toggle('d-none', !on);
        btnClear.classList.toggle('d-none', !on);
        btnDelete.classList.toggle('d-none', !on); // 👈 controla botão apagar

        btnToggle.classList.toggle('btn-outline-primary', !on);
        btnToggle.classList.toggle('btn-primary', on);

        btnToggle.innerHTML = on
            ? '<i class="bi bi-x-lg me-1"></i> Cancelar seleção'
            : '<i class="bi bi-check2-square me-1"></i> Selecionar';

        // Ao sair do modo seleção, limpa tudo
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
        if (e.target.classList?.contains('js-user-check')) {
            updateDeleteState();
        }
    });

    modal?.addEventListener('show.bs.modal', () => {
        const selected = checks().filter(c => c.checked);

        countEl.textContent = String(selected.length);

        // monta ids[] hidden
        hiddenWrap.innerHTML = '';
        selected.forEach(c => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ids[]';
            input.value = c.value;
            hiddenWrap.appendChild(input);
        });

        // se qualquer selecionado for admin → pede senha
        const hasAdmin = selected.some(c => c.dataset.isAdmin === '1');
        adminWrap.style.display = hasAdmin ? '' : 'none';

        // limpa senha sempre ao abrir
        const pwd = adminWrap.querySelector('input[name="password"]');
        if (pwd) pwd.value = '';
    });

    // começa fora do modo seleção
    setSelectMode(false);
});
</script>
@endpush

@endsection
