<section>
    <div class="mb-4">
        <h4 class="fw-bold mb-1">Atualizar senha</h4>
        <p class="text-muted mb-0">
            Utilize uma senha segura para proteger sua conta e seus dados.
        </p>
    </div>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('PUT')

        <div class="row g-3">
            <div class="col-md-4">
                <label for="current_password" class="form-label fw-bold">
                    Senha atual
                </label>
                <input
                    id="current_password"
                    name="current_password"
                    type="password"
                    class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                    autocomplete="current-password"
                >
                @error('current_password', 'updatePassword')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="password" class="form-label fw-bold">
                    Nova senha
                </label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                    autocomplete="new-password"
                >
                @error('password', 'updatePassword')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="password_confirmation" class="form-label fw-bold">
                    Confirmar nova senha
                </label>
                <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                    autocomplete="new-password"
                >
                @error('password_confirmation', 'updatePassword')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="d-flex align-items-center gap-3 mt-4 flex-wrap">
            <button type="submit" class="btn btn-primary rounded-3">
                <i class="bi bi-shield-lock me-1"></i> Salvar nova senha
            </button>

            @if (session('status') === 'password-updated')
                <span class="text-success fw-semibold">
                    <i class="bi bi-check-circle me-1"></i> Senha atualizada com sucesso!
                </span>
            @endif
        </div>
    </form>
</section>