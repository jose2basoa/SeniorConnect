<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sênior Conecta')</title>

    <link rel="icon" href="data:,">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8fafc;
            padding-top: 88px;
        }

        .navbar-brand {
            letter-spacing: .2px;
        }

        .app-main {
            min-height: calc(100vh - 72px);
        }

        .card {
            border-radius: 1rem;
        }

        .btn {
            border-radius: .75rem;
        }

        .form-control,
        .form-select {
            border-radius: .75rem;
        }

        @media (max-width: 991.98px) {
            body {
                padding-top: 76px;
            }
        }
    </style>

    @stack('styles')
</head>
<body>

    @include('layouts.navigation')

    <main class="app-main">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>