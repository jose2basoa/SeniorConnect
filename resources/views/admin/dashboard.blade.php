@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Painel Administrativo</h2>
            <small class="text-muted">Visão geral do sistema e últimos cadastros</small>
        </div>
    </div>

    <!-- Cards Resumo (clicáveis) -->
    <div class="row g-4 mb-4">

        <div class="col-md-3">
            <button type="button"
                class="card shadow-sm border-0 bg-primary text-white w-100 text-start p-0 js-filter ring-active"
                data-filter="users">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-1 opacity-75">Total Usuários</h6>
                            <h3 class="mb-0">{{ $totalUsers }}</h3>
                        </div>
                        <div class="fs-4 opacity-75">
                            <i class="bi bi-people"></i>
                        </div>
                    </div>
                    <small class="opacity-75">Ver últimos usuários</small>
                </div>
            </button>
        </div>

        <div class="col-md-3">
            <button type="button"
                class="card shadow-sm border-0 bg-warning text-dark w-100 text-start p-0 js-filter"
                data-filter="idosos">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-1 opacity-75">Total Idosos</h6>
                            <h3 class="mb-0">{{ $totalIdosos }}</h3>
                        </div>
                        <div class="fs-4 opacity-75">
                            <i class="bi bi-person-hearts"></i>
                        </div>
                    </div>
                    <small class="opacity-75">Ver últimos idosos</small>
                </div>
            </button>
        </div>

        <div class="col-md-3">
            <button type="button"
                class="card shadow-sm border-0 bg-success text-white w-100 text-start p-0 js-filter"
                data-filter="tutores">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-1 opacity-75">Total Tutores</h6>
                            <h3 class="mb-0">{{ $totalTutores }}</h3>
                        </div>
                        <div class="fs-4 opacity-75">
                            <i class="bi bi-person-check"></i>
                        </div>
                    </div>
                    <small class="opacity-75">Ver últimos tutores</small>
                </div>
            </button>
        </div>

        <div class="col-md-3">
            <button type="button"
                class="card shadow-sm border-0 bg-danger text-white w-100 text-start p-0 js-filter"
                data-filter="admins">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-1 opacity-75">Total Admins</h6>
                            <h3 class="mb-0">{{ $totalAdmins }}</h3>
                        </div>
                        <div class="fs-4 opacity-75">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                    </div>
                    <small class="opacity-75">Ver últimos admins</small>
                </div>
            </button>
        </div>

    </div>

    <!-- Cards extras: vinculação -->
    <div class="row g-4 mb-5">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted">Idosos vinculados</div>
                        <div class="fs-3 fw-bold">{{ $idososComTutor ?? 0 }}</div>
                        <small class="text-muted">Pelo menos 1 tutor associado</small>
                    </div>
                    <div class="fs-2 text-success">
                        <i class="bi bi-link-45deg"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted">Idosos não vinculados</div>
                        <div class="fs-3 fw-bold">{{ $idososSemTutor ?? 0 }}</div>
                        <small class="text-muted">Sem tutor associado</small>
                    </div>
                    <div class="fs-2 text-danger">
                        <i class="bi bi-unlink"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- GRÁFICOS -->
    <div class="row g-4 mb-5">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="fw-bold mb-0">Cadastros de Usuários</h5>
                        <small class="text-muted">últimos 14 dias</small>
                    </div>
                    <canvas id="chartUsers" height="140"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="fw-bold mb-0">Cadastros de Idosos</h5>
                        <small class="text-muted">últimos 14 dias</small>
                    </div>
                    <canvas id="chartIdosos" height="140"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Área dinâmica -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-light fw-bold d-flex align-items-center justify-content-between flex-wrap gap-2 rounded-top-4">
            <span id="list-title">Últimos Usuários Cadastrados</span>

            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-secondary" id="list-count">
                    {{ $ultimosUsuarios->count() }}
                </span>

                <a href="{{ route('admin.users') }}" class="btn btn-sm btn-outline-secondary" id="link-users">
                    Ver todos os usuários
                </a>

                <a href="{{ route('admin.idosos') }}" class="btn btn-sm btn-outline-secondary d-none" id="link-idosos">
                    Ver todos os idosos
                </a>
            </div>
        </div>

        <div class="card-body">

            <!-- TABELA: USUÁRIOS (default) -->
            <div id="table-users" class="table-responsive">
                @if($ultimosUsuarios->isEmpty())
                    <div class="alert alert-info mb-0">
                        Nenhum usuário encontrado.
                    </div>
                @else
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nome</th>
                                <th class="d-none d-md-table-cell">Email</th>
                                <th class="d-none d-lg-table-cell">CPF</th>
                                <th>Tipo</th>
                                <th class="d-none d-md-table-cell">Data Cadastro</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ultimosUsuarios as $user)
                                <tr data-is-admin="{{ $user->is_admin ? 1 : 0 }}">
                                    <td class="fw-semibold">{{ $user->name }}</td>
                                    <td class="d-none d-md-table-cell">{{ $user->email }}</td>
                                    <td class="d-none d-lg-table-cell">{{ $user->cpf }}</td>
                                    <td>
                                        @if($user->is_admin)
                                            <span class="badge bg-danger">
                                                <i class="bi bi-shield-lock me-1"></i>Admin
                                            </span>
                                        @else
                                            <span class="badge bg-success">
                                                <i class="bi bi-person me-1"></i>Tutor
                                            </span>
                                        @endif
                                    </td>
                                    <td class="d-none d-md-table-cell">
                                        {{ $user->created_at->format('d/m/Y H:i') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <!-- TABELA: IDOSOS (hidden) -->
            <div id="table-idosos" class="table-responsive d-none">
                @if(isset($ultimosIdosos) && $ultimosIdosos->isEmpty())
                    <div class="alert alert-info mb-0">
                        Nenhum idoso encontrado.
                    </div>
                @else
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nome</th>
                                <th class="d-none d-md-table-cell">Nascimento</th>
                                <th class="d-none d-lg-table-cell">CPF</th>
                                <th class="d-none d-md-table-cell">Tutor(es)</th>
                                <th>Sexo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(($ultimosIdosos ?? collect()) as $idoso)
                                <tr>
                                    <td class="fw-semibold">{{ $idoso->nome }}</td>

                                    <td class="d-none d-md-table-cell">
                                        {{ \Carbon\Carbon::parse($idoso->data_nascimento)->format('d/m/Y') }}
                                    </td>

                                    <td class="d-none d-lg-table-cell">
                                        {{ $idoso->cpf }}
                                    </td>

                                    <td class="d-none d-md-table-cell">
                                        @if($idoso->users->isNotEmpty())
                                            @foreach($idoso->users as $u)
                                                <span class="badge bg-primary me-1 mb-1">
                                                    <i class="bi bi-person-check me-1"></i>{{ $u->name }}
                                                </span>
                                            @endforeach
                                        @else
                                            <span class="badge bg-secondary">
                                                <i class="bi bi-link-45deg me-1"></i>Não vinculado
                                            </span>
                                        @endif
                                    </td>

                                    <td>{{ $idoso->sexo ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

        </div>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // ====== FILTRO (Cards clicáveis) ======
    const buttons = document.querySelectorAll('.js-filter');
    const title = document.getElementById('list-title');
    const countBadge = document.getElementById('list-count');

    const tableUsers = document.getElementById('table-users');
    const tableIdosos = document.getElementById('table-idosos');

    const linkUsers = document.getElementById('link-users');
    const linkIdosos = document.getElementById('link-idosos');

    const userRows = tableUsers.querySelectorAll('tbody tr');

    function setActive(btn) {
        buttons.forEach(b => b.classList.remove('ring-active'));
        btn.classList.add('ring-active');
    }

    function safeCountRows(container) {
        const tbody = container.querySelector('tbody');
        if (!tbody) return 0;
        return container.querySelectorAll('tbody tr').length;
    }

    function showUsers(mode) {
        tableIdosos.classList.add('d-none');
        tableUsers.classList.remove('d-none');

        linkIdosos.classList.add('d-none');
        linkUsers.classList.remove('d-none');

        // Reset: mostra todos
        userRows.forEach(r => r.classList.remove('d-none'));

        if (mode === 'admins') {
            userRows.forEach(r => {
                if (r.getAttribute('data-is-admin') !== '1') r.classList.add('d-none');
            });
            title.textContent = 'Últimos Admins Cadastrados';
        } else if (mode === 'tutores') {
            userRows.forEach(r => {
                if (r.getAttribute('data-is-admin') !== '0') r.classList.add('d-none');
            });
            title.textContent = 'Últimos Tutores Cadastrados';
        } else {
            title.textContent = 'Últimos Usuários Cadastrados';
        }

        const visible = [...userRows].filter(r => !r.classList.contains('d-none')).length;
        countBadge.textContent = visible;
    }

    function showIdosos() {
        tableUsers.classList.add('d-none');
        tableIdosos.classList.remove('d-none');

        linkUsers.classList.add('d-none');
        linkIdosos.classList.remove('d-none');

        title.textContent = 'Últimos Idosos Cadastrados';
        countBadge.textContent = safeCountRows(tableIdosos);
    }

    // default já fica em users e com ring-active no primeiro
    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            setActive(btn);
            const filter = btn.getAttribute('data-filter');
            if (filter === 'idosos') showIdosos();
            else showUsers(filter);
        });
    });

    // ====== GRÁFICOS ======
    const labels = @json($labels ?? []);
    const users = @json($usersByDay ?? []);
    const idosos = @json($idososByDay ?? []);

    const common = {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: { mode: 'index', intersect: false }
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
                    label: 'Idosos',
                    data: idosos,
                    borderWidth: 1
                }]
            },
            options: common
        });
    }
});
</script>

<style>
/* aparência premium nos cards clicáveis */
.js-filter { border-radius: 1rem; transition: transform .12s ease, filter .12s ease, outline .12s ease; }
.js-filter:hover { transform: translateY(-2px); filter: brightness(1.03); }
.ring-active { outline: 3px solid rgba(255,255,255,.55); }
.bg-warning.ring-active { outline: 3px solid rgba(0,0,0,.20); } /* contraste no amarelo */
</style>
@endpush

@endsection