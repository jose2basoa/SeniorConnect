@extends('layouts.app')

@section('content')

<div class="container py-5">

    <h2 class="fw-bold mb-4">Painel Administrativo</h2>

    <!-- Cards Resumo -->
    <div class="row g-4 mb-5">

        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-primary text-white">
                <div class="card-body">
                    <h6>Total Usuários</h6>
                    <h3>{{ $totalUsers }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-success text-white">
                <div class="card-body">
                    <h6>Total Idosos</h6>
                    <h3>{{ $totalIdosos }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-danger text-white">
                <div class="card-body">
                    <h6>Total Admins</h6>
                    <h3>{{ $totalAdmins }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-warning text-dark">
                <div class="card-body">
                    <h6>Total Tutores</h6>
                    <h3>{{ $totalTutores }}</h3>
                </div>
            </div>
        </div>

    </div>

    <!-- Últimos usuários -->
    <div class="card shadow-sm">
        <div class="card-header bg-light fw-bold">
            Últimos Usuários Cadastrados
        </div>
        <div class="card-body">

            @if($ultimosUsuarios->isEmpty())
                <div class="alert alert-info">
                    Nenhum usuário encontrado.
                </div>
            @else

            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>CPF</th>
                        <th>Tipo</th>
                        <th>Data Cadastro</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ultimosUsuarios as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->cpf }}</td>
                            <td>
                                @if($user->is_admin)
                                    <span class="badge bg-danger">Admin</span>
                                @else
                                    <span class="badge bg-success">Tutor</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @endif

        </div>
    </div>

</div>

@endsection
