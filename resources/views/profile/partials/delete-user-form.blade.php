<section>

    <div class="mb-4">
        <h4 class="fw-bold text-danger">
            Excluir Conta
        </h4>
        <p class="text-muted mb-0">
            Após excluir sua conta, todos os dados serão permanentemente removidos.
            Antes de continuar, certifique-se de salvar qualquer informação importante.
        </p>
    </div>

    <!-- Botão que abre o modal -->
    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
        Excluir Conta
    </button>

    <!-- Modal Bootstrap -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')

                    <div class="modal-header">
                        <h5 class="modal-title text-danger">
                            Confirmar Exclusão
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <p>
                            Tem certeza que deseja excluir sua conta?
                            Esta ação é <strong>irreversível</strong>.
                        </p>

                        <div class="mb-3">
                            <label for="delete_password" class="form-label">
                                Digite sua senha para confirmar
                            </label>
                            <input
                                id="delete_password"
                                name="password"
                                type="password"
                                class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                                placeholder="Senha"
                            >

                            @error('password', 'userDeletion')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancelar
                        </button>

                        <button type="submit" class="btn btn-danger">
                            Excluir Conta
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

</section>
