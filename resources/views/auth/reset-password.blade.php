@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">

            <div class="card shadow border-0 rounded-4">
                <div class="card-header bg-primary text-white rounded-top-4 text-center">
                    <h5 class="mb-0">Redefinir senha</h5>
                </div>

                <div class="card-body p-4">
                    <p class="text-muted text-center mb-4">
                        Escolha uma nova senha para acessar sua conta.
                    </p>

                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">E-mail</label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email', $request->email) }}"
                                class="form-control rounded-3 @error('email') is-invalid @enderror"
                                required
                                autofocus
                                autocomplete="username"
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Nova senha</label>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                class="form-control rounded-3 @error('password') is-invalid @enderror"
                                required
                                autocomplete="new-password"
                            >
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label fw-bold">Confirmar nova senha</label>
                            <input
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                class="form-control rounded-3 @error('password_confirmation') is-invalid @enderror"
                                required
                                autocomplete="new-password"
                            >
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary rounded-3">
                                Redefinir senha
                            </button>
                        </div>
                    </form>

                    <div class="mt-4 text-center">
                        <a href="{{ route('login') }}" class="text-decoration-none">
                            ← Voltar para login
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection