@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">

            <div class="card shadow border-0 rounded-4">
                <div class="card-header bg-primary text-white rounded-top-4 text-center">
                    <h5 class="mb-0">Esqueci minha senha</h5>
                </div>

                <div class="card-body p-4">
                    <p class="text-muted text-center mb-4">
                        Informe seu e-mail para receber o link de redefinição de senha.
                    </p>

                    @if(session('status'))
                        <div class="alert alert-success rounded-3">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">E-mail</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control rounded-3 @error('email') is-invalid @enderror"
                                required
                                autofocus
                                autocomplete="email"
                                placeholder="nome@dominio.com"
                            >

                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary rounded-3">
                                Enviar link de redefinição
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