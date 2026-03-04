@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Usuários Cadastrados</h2>
        <span class="badge bg-primary fs-6">
            Total: {{ $users->count() }}
        </span>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            @if($users->isEmpty())
                <div class="alert alert-info">
                    Nenhum usuário cadastrado.
                </div>
            @else

            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>CPF</th>
                        <th>Qtd. Idosos</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->cpf }}</td>
                            <td>{{ $user->idosos->count() }}</td>
                            <td>
                                @if($user->is_admin)
                                    <span class="badge bg-danger">Admin</span>
                                @else
                                    <span class="badge bg-success">Tutor</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @endif

        </div>
    </div>

</div>

@endsection
