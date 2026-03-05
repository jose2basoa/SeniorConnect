@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h4 class="mb-4 text-center fw-bold">
                        Vincular Idoso
                    </h4>

                    <p class="text-muted text-center mb-4">
                        Informe o CPF e a data de nascimento do idoso para realizar a vinculação.
                    </p>

                    @if(session('erro'))
                        <div class="alert alert-danger">
                            {{ session('erro') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('idosos.vincular.buscar') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">CPF</label>
                            <input
                                type="text"
                                name="cpf"
                                class="form-control"
                                placeholder="000.000.000-00"
                                required
                            >
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Data de Nascimento</label>
                            <input
                                type="date"
                                name="data_nascimento"
                                class="form-control"
                                required
                            >
                        </div>

                        <div class="d-grid">
                            <button class="btn btn-primary btn-lg">
                                Buscar e Vincular
                            </button>
                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
