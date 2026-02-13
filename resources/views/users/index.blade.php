@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h2>Lista de Usuários</h2>
    <a href="{{ route('users.create') }}" class="btn btn-primary">Novo Usuário</a>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Nome</th>
            <th>Sobrenome</th>
            <th>CPF</th>
            <th>Email</th>
            <th width="150">Ações</th>
        </tr>
    </thead>
    <tbody>
        @forelse($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->sobrenome }}</td>
                <td>{{ $user->cpf }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">
                        Editar
                    </a>

                    <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Excluir</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">Nenhum usuário cadastrado.</td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection
