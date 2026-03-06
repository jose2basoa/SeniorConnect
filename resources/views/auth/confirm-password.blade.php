@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">

            <div class="card shadow border-0 rounded-4">
                <div class="card-header bg-primary text-white rounded-top-4 text-center">
                    <h5 class="mb-0">Confirmar senha</h5>
                </div>

                <div class="card-body p-4">
                    <p class="text-muted text-center mb-4">
                        Esta é uma área protegida do sistema. Confirme sua senha para continuar.
                    </p>

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Senha</label>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                class="form-control rounded-3 @error('password') is-invalid @enderror"
                                required
                                autocomplete="current-password"
                                autofocus
                            >

                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary rounded-3">
                                Confirmar
                            </button>
                        </div>
                    </form>

                    <div class="mt-4 text-center">
                        <a href="{{ route('dashboard') }}" class="text-decoration-none">
                            ← Voltar ao painel
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection