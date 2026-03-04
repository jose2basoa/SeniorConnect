@extends('layouts.app')

@section('content')

<div class="container py-5">

    <h2 class="mb-4 fw-bold">
        Perfil
    </h2>

    <div class="row g-4">

        <!-- Atualizar Informações -->
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
        </div>

        <!-- Atualizar Senha -->
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        <!-- Deletar Conta -->
        <div class="col-12">
            <div class="card shadow-sm border-danger">
                <div class="card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>

    </div>

</div>

@endsection
