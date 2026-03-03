@php $step = 4; @endphp
@extends('layouts.wizard')

@section('wizard-content')

<form method="POST" action="{{ route('idosos.store.step4', $idoso->id) }}">
    @csrf

    <div id="contatos-wrapper">

        <!-- Contato 1 -->
        <div class="contato-item border rounded-3 p-3 mb-3">

            <div class="mb-3">
                <label class="form-label">Nome do Contato *</label>
                <input type="text"
                       name="contatos[0][nome]"
                       class="form-control"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Telefone *</label>
                <input type="text"
                       name="contatos[0][telefone]"
                       class="form-control"
                       required>
            </div>

            <div class="mb-2">
                <label class="form-label">Parentesco</label>
                <input type="text"
                       name="contatos[0][parentesco]"
                       class="form-control">
            </div>

        </div>

    </div>

    <!-- Botão adicionar contato -->
    <div class="mb-4">
        <button type="button"
                class="btn btn-outline-primary btn-sm"
                onclick="adicionarContato()">
            + Adicionar outro contato
        </button>
    </div>

    <!-- Botões -->
    <div class="d-flex justify-content-between mt-4">

        <a href="{{ route('idosos.create.step3', $idoso->id) }}"
           class="btn btn-outline-secondary px-4">
            ← Voltar
        </a>

        <button type="submit"
                class="btn btn-success px-4">
            Finalizar Cadastro
        </button>

    </div>

</form>

<!-- Script simples para adicionar múltiplos contatos -->
<script>
    let index = 1;

    function adicionarContato() {

        const wrapper = document.getElementById('contatos-wrapper');

        const html = `
            <div class="contato-item border rounded-3 p-3 mb-3">

                <div class="mb-3">
                    <label class="form-label">Nome do Contato *</label>
                    <input type="text"
                           name="contatos[${index}][nome]"
                           class="form-control"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Telefone *</label>
                    <input type="text"
                           name="contatos[${index}][telefone]"
                           class="form-control"
                           required>
                </div>

                <div class="mb-2">
                    <label class="form-label">Parentesco</label>
                    <input type="text"
                           name="contatos[${index}][parentesco]"
                           class="form-control">
                </div>

            </div>
        `;

        wrapper.insertAdjacentHTML('beforeend', html);
        index++;
    }
</script>

@endsection