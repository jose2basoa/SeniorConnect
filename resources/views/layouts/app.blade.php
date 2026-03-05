<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sênior Conecta</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ auth()->check() ? route('dashboard') : url('/') }}">
                Sênior Conecta
            </a>

            <div class="collapse navbar-collapse justify-content-end">
                @auth
                    <div class="d-flex align-items-center gap-3">

                        {{-- Links Admin --}}
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-sm">
                                Painel Admin
                            </a>

                            <a href="{{ route('admin.users') }}" class="btn btn-outline-light btn-sm">
                                Usuários
                            </a>

                            <a href="{{ route('admin.idosos') }}" class="btn btn-outline-light btn-sm">
                                Idosos
                            </a>
                        @endif

                        <span class="text-white">
                            {{ auth()->user()->name }}
                        </span>

                        <a href="{{ route('profile.edit') }}" class="btn btn-light btn-sm">
                            <i class="bi bi-person-circle"></i>
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-light btn-sm">
                                Sair
                            </button>
                        </form>

                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Conteúdo -->
    <main>
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
