@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">

            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-4 p-md-5">

                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-primary mb-2">Entrar no Sênior Conecta</h3>
                        <p class="text-muted mb-0">
                            Acesse sua conta para acompanhar alertas, rotina e informações importantes.
                        </p>
                    </div>

                    @if(session('status'))
                        <div class="alert alert-success rounded-3">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">E-mail</label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control rounded-3 @error('email') is-invalid @enderror"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="nome@dominio.com"
                            >

                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label for="password" class="form-label fw-bold">Senha</label>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                class="form-control rounded-3 @error('password') is-invalid @enderror"
                                required
                                autocomplete="current-password"
                                placeholder="Digite sua senha"
                            >

                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-end mb-3">
                            <a href="{{ route('password.request') }}" class="text-decoration-none small">
                                Esqueci minha senha
                            </a>
                        </div>

                        <div class="form-check mb-4">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="remember"
                                id="remember"
                                {{ old('remember') ? 'checked' : '' }}
                            >
                            <label class="form-check-label" for="remember">
                                Lembrar de mim
                            </label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg rounded-3">
                                Entrar
                            </button>
                        </div>

                        <div class="text-center mt-4 d-flex justify-content-between flex-wrap gap-2">
                            <a href="{{ route('public.index') }}" class="text-decoration-none">
                                Voltar ao início
                            </a>
                            <a href="{{ route('register') }}" class="text-decoration-none">
                                Criar conta
                            </a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection