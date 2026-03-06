@extends('layouts.app')
@section('content')
<div class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h3 class="fw-bold mb-1">Medicamentos</h3>
      <small class="text-muted">Referente a: <span class="fw-semibold">{{ $idoso->nome }}</span></small>
    </div>
    <a href="{{ route('dashboard', ['idoso' => $idoso->id]) }}" class="btn btn-outline-secondary">
      <i class="bi bi-arrow-left"></i> Voltar ao painel
    </a>
  </div>

  <div class="alert alert-info border-0 rounded-4">
    Tela em construção. Aqui você vai listar e gerenciar os medicamentos.
  </div>
</div>
@endsection
