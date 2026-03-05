@extends('layouts.app')

@section('content')

<div class="container py-5">

    <h3 class="mb-4">Gerenciar Idosos</h3>

    <div class="mb-4">
        <a href="{{ route('idosos.cadastrar') }}" class="btn btn-primary">
            Vincular Idoso
        </a>
    </div>

    <div class="card">
        <div class="card-body">

            @forelse($idosos as $idoso)

                <div class="d-flex justify-content-between align-items-center border-bottom py-2">

                    <div>
                        <strong>{{ $idoso->nome }}</strong><br>
                        <small class="text-muted">{{ $idoso->cpf }}</small>
                    </div>

                    <form method="POST" action="{{ route('idosos.desvincular', $idoso->id) }}">
                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger btn-sm"
                            onclick="return confirm('Deseja realmente desvincular este idoso?')">
                            Desvincular
                        </button>
                    </form>

                </div>

            @empty

                <p class="text-muted">Nenhum idoso vinculado.</p>

            @endforelse

        </div>
    </div>

</div>

@endsection
