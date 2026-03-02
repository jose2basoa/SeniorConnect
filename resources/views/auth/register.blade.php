@extends('layouts.app')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">

            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-4">

                    <h3 class="text-center mb-4 text-primary">Criar Conta</h3>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Nome -->
                        <div class="mb-3">
                            <label class="form-label">Nome</label>
                            <input type="text"
                                   name="name"
                                   value="{{ old('name') }}"
                                   class="form-control @error('name') is-invalid @enderror"
                                   required>

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label">E-mail</label>
                            <input type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   class="form-control @error('email') is-invalid @enderror"
                                   required>

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Senha -->
                        <div class="mb-3">
                            <label class="form-label">Senha</label>
                            <input type="password"
                                   name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   required>

                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Confirmar Senha -->
                        <div class="mb-3">
                            <label class="form-label">Confirmar Senha</label>
                            <input type="password"
                                   name="password_confirmation"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                Registrar
                            </button>
                        </div>

                        <div class="text-center mt-3">
                            <a href="{{ route('login') }}">
                                Já possui conta? Entrar
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection
