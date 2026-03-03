@extends('layouts.app')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">

            <div class="card shadow border-0 rounded-4">

                <div class="card-header bg-primary text-white rounded-top-4">
                    Cadastrar Idoso
                </div>

                <div class="card-body p-4">

                    <form method="POST" action="{{ route('idosos.store') }}">
                        @csrf

                        <!-- Nome -->
                        <div class="mb-3">
                            <label class="form-label">Nome Completo</label>
                            <input type="text"
                                   name="nome"
                                   value="{{ old('nome') }}"
                                   class="form-control @error('nome') is-invalid @enderror"
                                   required>

                            @error('nome')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Data -->
                        <div class="mb-3">
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

                        <!-- Telefone -->
                        <div class="mb-3">
                            <label class="form-label">Telefone</label>
                            <input type="text"
                                   name="telefone"
                                   value="{{ old('telefone') }}"
                                   class="form-control">
                        </div>

                        <!-- Observações -->
                        <div class="mb-4">
                            <label class="form-label">Observações</label>
                            <textarea name="observacoes"
                                      class="form-control"
                                      rows="3">{{ old('observacoes') }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between">

                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                                ← Voltar
                            </a>

                            <button type="submit" class="btn btn-primary">
                                Cadastrar Idoso
                            </button>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection