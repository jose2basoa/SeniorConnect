<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Sênior Conecta') }}</title>

    <link rel="icon" href="data:,">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(180deg, #f8fafc 0%, #eef4ff 100%);
        }

        .guest-shell {
            min-height: 100vh;
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="guest-shell d-flex align-items-center py-4">
        <div class="container">
            <div class="text-center mb-4">
                <a href="{{ route('public.index') }}" class="text-decoration-none text-primary fw-bold fs-4">
                    <i class="bi bi-shield-check me-1"></i> Sênior Conecta
                </a>
            </div>

            {{ $slot }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>