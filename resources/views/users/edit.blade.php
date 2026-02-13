@extends('layouts.app')

@section('content')

<h2 class="mb-4">Editar Usuário</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <div class="card-body">

        <form method="POST" action="{{ route('users.update', $user->id) }}">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <div class="col">
                    <label class="form-label">Nome</label>
                    <input type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name', $user->name) }}"
                        required>
                </div>

                <div class="col">
                    <label class="form-label">Sobrenome</label>
                    <input type="text"
                        name="sobrenome"
                        class="form-control"
                        value="{{ old('sobrenome', $user->sobrenome) }}"
                        required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">CPF</label>
                <input type="text"
                    name="cpf"
                    class="form-control"
                    value="{{ old('cpf', $user->cpf) }}"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Telefone</label>
                <input type="text"
                    name="telefone"
                    class="form-control"
                    value="{{ old('telefone', $user->telefone) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Data de Nascimento</label>
                <input type="date"
                    name="data_nascimento"
                    class="form-control"
                    value="{{ old('data_nascimento', $user->data_nascimento) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">CEP</label>
                <input type="text"
                    name="cep"
                    class="form-control"
                    value="{{ old('cep', $user->cep) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Endereço</label>
                <input type="text"
                    name="endereco"
                    class="form-control"
                    value="{{ old('endereco', $user->endereco) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email"
                    name="email"
                    class="form-control"
                    value="{{ old('email', $user->email) }}"
                    required>
            </div>

            <button type="submit" class="btn btn-success">Atualizar</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>

        </form>

    </div>
</div>

@endsection
