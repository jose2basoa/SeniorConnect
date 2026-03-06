<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">

        <a class="navbar-brand fw-bold d-flex align-items-center gap-2"
           href="{{ auth()->check() ? route('dashboard') : route('public.index') }}">
            <i class="bi bi-shield-check"></i>
            <span>Sênior Conecta</span>
        </a>

        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">

            @auth
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active fw-semibold' : '' }}"
                           href="{{ route('dashboard') }}">
                            Painel
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('idosos.*') ? 'active fw-semibold' : '' }}"
                           href="{{ route('idosos.gerenciar') }}">
                            Pessoas acompanhadas
                        </a>
                    </li>

                    @if(auth()->user()->is_admin)
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.*') ? 'active fw-semibold' : '' }}"
                               href="{{ route('admin.dashboard') }}">
                                Admin
                            </a>
                        </li>
                    @endif
                </ul>

                <div class="d-flex align-items-center gap-2 flex-column flex-lg-row mt-3 mt-lg-0">
                    <span class="text-white-50 small d-none d-lg-inline">
                        {{ auth()->user()->nome_completo ?? auth()->user()->name }}
                    </span>

                    <a href="{{ route('profile.edit') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-person-circle me-1"></i> Perfil
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm">
                            <i class="bi bi-box-arrow-right me-1"></i> Sair
                        </button>
                    </form>
                </div>
            @else
                <div class="ms-auto d-flex gap-2 mt-3 mt-lg-0">
                    <a href="{{ route('login') }}" class="btn btn-light btn-sm">
                        Entrar
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-sm">
                        Criar conta
                    </a>
                </div>
            @endauth

        </div>
    </div>
</nav>