@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Idosos Cadastrados</h2>
        <span class="badge bg-primary fs-6">
            Total: {{ $idosos->count() }}
        </span>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            @if($idosos->isEmpty())
                <div class="alert alert-info">
                    Nenhum idoso cadastrado.
                </div>
            @else

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nome</th>
                            <th>Data Nasc.</th>
                            <th>Tutor</th>
                            <th>Email Tutor</th>
                            <th>Cadastrado em</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($idosos as $idoso)
                            <tr>
                                <td>{{ $idoso->nome }}</td>

                                <td>
                                    {{ \Carbon\Carbon::parse($idoso->data_nascimento)->format('d/m/Y') }}
                                </td>

                                <td>
                                    @if($idoso->users->isNotEmpty())
                                        {{ $idoso->users->pluck('name')->join(', ') }}
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>
                                    @if($idoso->users->isNotEmpty())
                                        {{ $idoso->users->pluck('email')->join(', ') }}
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>
                                    {{ $idoso->created_at->format('d/m/Y H:i') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @endif

        </div>
    </div>

</div>

@endsection
