<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm fixed-top py-2">
    <div class="container">

        <a class="navbar-brand fw-bold d-flex align-items-center gap-2"
           href="{{ request()->routeIs('dashboard') ? route('public.index') : (auth()->check() ? route('dashboard') : route('public.index')) }}">
            <i class="bi bi-shield-check"></i>
            Sênior Conecta
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">

            {{-- MENU CENTRAL --}}
            <ul class="navbar-nav mx-auto">

                {{-- LANDING PAGE --}}
                @if(request()->routeIs('public.index'))

                    <li class="nav-item">
                        <a class="nav-link text-white" href="#beneficios">Benefícios</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="#funcionalidades">Funcionalidades</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="#como-funciona">Como funciona</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="#depoimentos">Relatos</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="#faq">Dúvidas</a>
                    </li>

                {{-- SISTEMA --}}
                @elseif(auth()->check())

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

                @endif

            </ul>


            {{-- BOTÕES DIREITA --}}
            <div class="d-flex align-items-center gap-2">

                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.comentarios.index') }}"
                        class="btn btn-sm
                        {{ request()->routeIs('admin.comentarios.*')
                                ? 'btn-light text-primary fw-semibold'
                                : 'btn-outline-light' }}">

                            <i class="bi bi-chat-left-text me-1"></i> Comentários
                        </a>
                    @endif

                    <a href="{{ route('dashboard') }}"
                    class="btn btn-sm
                    {{ request()->routeIs('dashboard')
                            ? 'btn-light text-primary fw-semibold'
                            : 'btn-outline-light' }}">

                        <i class="bi bi-speedometer2 me-1"></i> Painel
                    </a>

                    <a href="{{ route('profile.edit') }}"
                       class="btn btn-light btn-sm d-flex align-items-center gap-2">
                        <i class="bi bi-person-circle"></i>
                        <span class="d-none d-lg-inline">
                            {{ auth()->user()->name }}
                        </span>
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button class="btn btn-light btn-sm">
                            Sair
                        </button>
                    </form>

                @else

                    <a href="{{ route('login') }}" class="btn btn-light btn-sm">
                        Entrar
                    </a>

                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-sm">
                        Criar conta
                    </a>

                @endauth

            </div>

        </div>
    </div>
</nav>