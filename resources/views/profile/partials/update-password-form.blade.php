<section>

    <div class="mb-4">
        <h4 class="fw-bold">
            Atualizar Senha
        </h4>
        <p class="text-muted mb-0">
            Utilize uma senha longa e aleatória para manter sua conta segura.
        </p>
    </div>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('PUT')

        <!-- Senha Atual -->
        <div class="mb-3">
            <label for="current_password" class="form-label">
                Senha Atual
            </label>
            <input
                id="current_password"
                name="current_password"
                type="password"
                class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
            >
            @error('current_password', 'updatePassword')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Nova Senha -->
        <div class="mb-3">
            <label for="password" class="form-label">
                Nova Senha
            </label>
            <input
                id="password"
                name="password"
                type="password"
                class="form-control @error('password', 'updatePassword') is-invalid @enderror"
            >
            @error('password', 'updatePassword')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Confirmar Nova Senha -->
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">
                Confirmar Nova Senha
            </label>
            <input
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
            >
            @error('password_confirmation', 'updatePassword')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">
                Salvar
            </button>

            @if (session('status') === 'password-updated')
                <span class="text-success">
                    ✔ Senha atualizada com sucesso!
                </span>
            @endif
        </div>

    </form>

</section>
