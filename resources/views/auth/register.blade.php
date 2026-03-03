@extends('layouts.app')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">

            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-5">

                    <h3 class="text-center mb-4 text-primary">
                        Criar Conta - Tutor
                    </h3>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row">
                            <!-- Nome -->
                            <div class="col-md-6 mb-3">
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

                            <!-- Sobrenome -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sobrenome</label>
                                <input type="text"
                                       name="sobrenome"
                                       value="{{ old('sobrenome') }}"
                                       class="form-control @error('sobrenome') is-invalid @enderror"
                                       required>

                                @error('sobrenome')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- CPF -->
                        <div class="mb-3">
                            <label class="form-label">CPF</label>
                            <input type="text"
                                   name="cpf"
                                   value="{{ old('cpf') }}"
                                   class="form-control @error('cpf') is-invalid @enderror"
                                   required>

                            @error('cpf')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="row">
                            <!-- Telefone -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Telefone</label>
                                <input type="text"
                                       name="telefone"
                                       value="{{ old('telefone') }}"
                                       class="form-control @error('telefone') is-invalid @enderror"
                                       required>

                                @error('telefone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Data Nascimento -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Data de Nascimento</label>
                                <input type="date"
                                       name="data_nascimento"
                                       value="{{ old('data_nascimento') }}"
                                       class="form-control @error('data_nascimento') is-invalid @enderror"
                                       required>

                                @error('data_nascimento')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- CEP -->
                        <div class="mb-3">
                            <label class="form-label">CEP</label>
                            <input type="text"
                                   name="cep"
                                   value="{{ old('cep') }}"
                                   class="form-control @error('cep') is-invalid @enderror"
                                   required>

                            @error('cep')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Endereço -->
                        <div class="mb-3">
                            <label class="form-label">Endereço</label>
                            <input type="text"
                                   name="endereco"
                                   value="{{ old('endereco') }}"
                                   class="form-control @error('endereco') is-invalid @enderror"
                                   required>

                            @error('endereco')
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
                        <div class="mb-4">
                            <label class="form-label">Confirmar Senha</label>
                            <input type="password"
                                   name="password_confirmation"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
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