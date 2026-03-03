@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- Título -->
            <div class="text-center mb-4">
                <h3 class="mb-1">Cadastro de Idoso</h3>
                <small class="text-muted">
                    Etapa {{ $step }} de 4
                </small>
            </div>

            <!-- Barra de progresso -->
            <div class="progress mb-4" style="height: 10px;">
                <div class="progress-bar bg-primary"
                     role="progressbar"
                     style="width: {{ ($step / 4) * 100 }}%;">
                </div>
            </div>

            <!-- Card Principal -->
            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-4">
                    
                    @yield('wizard-content')

                </div>
            </div>

        </div>
    </div>

</div>

@endsection