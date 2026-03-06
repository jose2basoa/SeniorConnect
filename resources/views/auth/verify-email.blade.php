@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">

            <div class="card shadow border-0 rounded-4">
                <div class="card-header bg-primary text-white rounded-top-4 text-center">
                    <h5 class="mb-0">Verificação de e-mail</h5>
                </div>

                <div class="card-body p-4 p-md-5">
                    <p class="text-muted text-center mb-4">
                        Obrigado por se cadastrar. Antes de começar, confirme seu endereço de e-mail clicando no link que enviamos para sua caixa de entrada.
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <div class="alert alert-success rounded-3">
                            Um novo link de verificação foi enviado para o e-mail informado no cadastro.
                        </div>
                    @endif

                    <div class="d-grid gap-3">
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    Reenviar e-mail de verificação
                                </button>
                            </div>
                        </form>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <div class="d-grid">
                                <button type="submit" class="btn btn-outline-secondary">
                                    Sair da conta
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="mt-4 text-center">
                        <small class="text-muted">
                            Confira também a caixa de spam ou lixo eletrônico.
                        </small>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection