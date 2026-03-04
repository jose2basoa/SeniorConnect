<section>

    <div class="mb-4">
        <h4 class="fw-bold">
            Informações do Perfil
        </h4>
        <p class="text-muted mb-0">
            Atualize as informações da sua conta e endereço de e-mail.
        </p>
    </div>

    <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PATCH')

        <!-- Nome -->
        <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input
                id="name"
                name="name"
                type="text"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $user->name) }}"
                required
                autofocus
            >
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input
                id="email"
                name="email"
                type="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email', $user->email) }}"
                required
            >
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="alert alert-warning">
                Seu e-mail ainda não foi verificado.

                <button form="send-verification" class="btn btn-sm btn-outline-dark ms-2">
                    Reenviar verificação
                </button>

                @if (session('status') === 'verification-link-sent')
                    <div class="mt-2 text-success">
                        Novo link de verificação enviado.
                    </div>
                @endif
            </div>
        @endif

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">
                Salvar
            </button>

            @if (session('status') === 'profile-updated')
                <span class="text-success">
                    ✔ Salvo com sucesso!
                </span>
            @endif
        </div>

    </form>

</section>
