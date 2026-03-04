@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">

            <div class="card shadow border-0 rounded-4">

                <div class="card-header bg-primary text-white rounded-top-4 text-center">
                    <h5 class="mb-0">Redefinir Senha</h5>
                </div>

                <div class="card-body p-4">

                    <p class="text-muted text-center mb-4">
                        Esqueceu sua senha? Informe seu e-mail e enviaremos um link para redefinição.
                    </p>

                    <!-- Status da Sessão -->
                    <x-auth-session-status class="mb-3" :status="session('status')" />

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email"
                                   class="form-control rounded-3 @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required
                                   autofocus>

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary rounded-3">
                                Enviar Link de Redefinição
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
