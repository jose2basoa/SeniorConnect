<section>
    <div class="mb-4">
        <h4 class="fw-bold text-danger mb-1">Excluir conta</h4>
        <p class="text-muted mb-0">
            Esta ação removerá permanentemente sua conta e os dados associados a ela.
            Antes de continuar, confirme se realmente deseja prosseguir.
        </p>
    </div>

    <button class="btn btn-danger rounded-3" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
        <i class="bi bi-trash me-1"></i> Excluir conta
    </button>

    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-4 border-0 shadow">
                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')

                    <div class="modal-header border-0">
                        <h5 class="modal-title text-danger fw-bold">
                            Confirmar exclusão
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <p class="mb-3">
                            Tem certeza que deseja excluir sua conta?
                            Esta ação é <strong>irreversível</strong>.
                        </p>

                        <div class="mb-3">
                            <label for="delete_password" class="form-label fw-bold">
                                Digite sua senha para confirmar
                            </label>
                            <input
                                id="delete_password"
                                name="password"
                                type="password"
                                class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                                placeholder="Senha"
                                autocomplete="current-password"
                            >

                            @error('password', 'userDeletion')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">
                            Cancelar
                        </button>

                        <button type="submit" class="btn btn-danger rounded-3">
                            <i class="bi bi-trash me-1"></i> Excluir conta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>