@extends('layouts.app')

@section('content')
{{-- EDITAR CADASTRO (APIMORADO) - copiar e colar --}}
<div class="container py-5">

  {{-- Cabeçalho --}}
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
    <div>
      <h3 class="fw-bold mb-1">Editar cadastro</h3>
      <small class="text-muted">
        Atualize as informações por seção. Cada bloco salva separadamente.
      </small>
    </div>

    <div class="d-flex gap-2">
      <a href="{{ route('idosos.show', $idoso->id) }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Voltar ao perfil
      </a>
    </div>
  </div>

  {{-- Alertas de sucesso --}}
  @if(session('success_step1')) <div class="alert alert-success"><i class="bi bi-check-circle me-1"></i>{{ session('success_step1') }}</div> @endif
  @if(session('success_step2')) <div class="alert alert-success"><i class="bi bi-check-circle me-1"></i>{{ session('success_step2') }}</div> @endif
  @if(session('success_step3')) <div class="alert alert-success"><i class="bi bi-check-circle me-1"></i>{{ session('success_step3') }}</div> @endif
  @if(session('success_step4')) <div class="alert alert-success"><i class="bi bi-check-circle me-1"></i>{{ session('success_step4') }}</div> @endif

  <div class="row g-4">

    {{-- Sidebar / Índice (desktop) --}}
    <div class="col-lg-3 d-none d-lg-block">
      <div class="card shadow-sm border-0 rounded-4 position-sticky" style="top: 90px;">
        <div class="card-body p-3">
          <div class="fw-bold mb-2">Seções</div>

          <div class="list-group list-group-flush small">
            <a class="list-group-item list-group-item-action" href="#card-pessoais">
              <i class="bi bi-1-circle me-1"></i> Dados pessoais
            </a>
            <a class="list-group-item list-group-item-action" href="#card-endereco">
              <i class="bi bi-2-circle me-1"></i> Endereço
            </a>
            <a class="list-group-item list-group-item-action" href="#card-clinico">
              <i class="bi bi-3-circle me-1"></i> Dados clínicos
            </a>
            <a class="list-group-item list-group-item-action" href="#card-contatos">
              <i class="bi bi-4-circle me-1"></i> Contatos
            </a>
          </div>

          <hr class="my-3">

          <button type="button" id="btnTop" class="btn btn-outline-secondary w-100">
            <i class="bi bi-arrow-up"></i> Topo
          </button>
        </div>
      </div>
    </div>

    {{-- Conteúdo --}}
    <div class="col-lg-9">

      {{-- =========================
          CARD 1 - DADOS PESSOAIS
      ========================== --}}
      <div id="card-pessoais" class="card shadow-sm border-0 rounded-4 mb-4 js-card">
        <div class="card-header bg-light fw-bold rounded-top-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
          <div class="d-flex align-items-center gap-2">
            <span><i class="bi bi-1-circle me-1"></i> Dados pessoais</span>
            <span class="badge text-bg-secondary fw-normal js-status">Sem alterações</span>
          </div>
          <a href="#card-endereco" class="small text-decoration-none">Ir para endereço ↓</a>
        </div>

        <div class="card-body p-4">
          <form method="POST" action="{{ route('idosos.update.step1', $idoso->id) }}" id="form-step1">
            @csrf
            @method('PUT')

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Nome *</label>
                <input type="text"
                       name="nome"
                       id="idoso_nome"
                       value="{{ old('nome', $idoso->nome) }}"
                       class="form-control @error('nome') is-invalid @enderror"
                       placeholder="Ex: Maria Aparecida da Silva"
                       required>
                @error('nome') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-md-3">
                <label class="form-label">Nascimento *</label>
                <input type="date"
                       name="data_nascimento"
                       value="{{ old('data_nascimento', $idoso->data_nascimento) }}"
                       class="form-control @error('data_nascimento') is-invalid @enderror"
                       required>
                @error('data_nascimento') <div class="invalid-feedback">{{ $message }}</div> @enderror
                <small class="text-muted">Use a data do documento.</small>
              </div>

              <div class="col-md-3">
                <label class="form-label">Sexo</label>
                <select name="sexo" class="form-select @error('sexo') is-invalid @enderror">
                  <option value="">Selecione</option>
                  <option value="Masculino" @selected(old('sexo', $idoso->sexo) === 'Masculino')>Masculino</option>
                  <option value="Feminino" @selected(old('sexo', $idoso->sexo) === 'Feminino')>Feminino</option>
                  <option value="Outro" @selected(old('sexo', $idoso->sexo) === 'Outro')>Outro</option>
                </select>
                @error('sexo') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-md-4">
                <label class="form-label">CPF</label>
                <input type="text"
                       name="cpf"
                       id="cpf"
                       inputmode="numeric"
                       autocomplete="off"
                       value="{{ old('cpf', $idoso->cpf) }}"
                       class="form-control @error('cpf') is-invalid @enderror"
                       placeholder="000.000.000-00">
                @error('cpf') <div class="invalid-feedback">{{ $message }}</div> @enderror
                <div class="text-danger small d-none" id="cpfClientError">CPF inválido. Confira e tente novamente.</div>
              </div>

              <div class="col-md-4">
                <label class="form-label">Telefone</label>
                <input type="text"
                       name="telefone"
                       id="telefone"
                       inputmode="numeric"
                       autocomplete="off"
                       value="{{ old('telefone', $idoso->telefone) }}"
                       class="form-control @error('telefone') is-invalid @enderror"
                       placeholder="(00) 00000-0000">
                @error('telefone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                <div class="form-text">Se tiver mais de um, use o principal.</div>
              </div>

              <div class="col-12">
                <label class="form-label">Observações</label>
                <textarea name="observacoes"
                          rows="4"
                          class="form-control @error('observacoes') is-invalid @enderror"
                          placeholder="Ex: rotina, cuidados, limitações, preferências...">{{ old('observacoes', $idoso->observacoes) }}</textarea>
                @error('observacoes') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-check2-circle me-1"></i> Salvar dados pessoais
              </button>
            </div>
          </form>
        </div>
      </div>

      {{-- =========================
          CARD 2 - ENDEREÇO
      ========================== --}}
      <div id="card-endereco" class="card shadow-sm border-0 rounded-4 mb-4 js-card">
        <div class="card-header bg-light fw-bold rounded-top-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
          <div class="d-flex align-items-center gap-2">
            <span><i class="bi bi-2-circle me-1"></i> Endereço</span>
            <span class="badge text-bg-secondary fw-normal js-status">Sem alterações</span>
          </div>
          <a href="#card-clinico" class="small text-decoration-none">Ir para dados clínicos ↓</a>
        </div>

        <div class="card-body p-4">
          @php $e = $idoso->endereco; @endphp

          <form method="POST" action="{{ route('idosos.update.step2', $idoso->id) }}">
            @csrf
            @method('PUT')

            <div class="row g-3">
              <div class="col-md-3">
                <label class="form-label">CEP</label>
                <input type="text"
                       name="cep"
                       id="cep"
                       value="{{ old('cep', $e->cep ?? '') }}"
                       class="form-control @error('cep') is-invalid @enderror"
                       placeholder="00000-000">
                @error('cep') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-md-6">
                <label class="form-label">Rua</label>
                <input type="text" name="rua" id="rua"
                       value="{{ old('rua', $e->rua ?? '') }}"
                       class="form-control"
                       placeholder="Ex: Av. Brasil">
              </div>

              <div class="col-md-3">
                <label class="form-label">Número</label>
                <input type="text" name="numero"
                       value="{{ old('numero', $e->numero ?? '') }}"
                       class="form-control"
                       placeholder="Ex: 123">
              </div>

              <div class="col-md-6">
                <label class="form-label">Complemento</label>
                <input type="text" name="complemento"
                       value="{{ old('complemento', $e->complemento ?? '') }}"
                       class="form-control"
                       placeholder="Ex: Apto 12 / Casa dos fundos">
              </div>

              <div class="col-md-6">
                <label class="form-label">Bairro</label>
                <input type="text" name="bairro" id="bairro"
                       value="{{ old('bairro', $e->bairro ?? '') }}"
                       class="form-control"
                       placeholder="Ex: Centro">
              </div>

              <div class="col-md-6">
                <label class="form-label">Cidade</label>
                <input type="text" name="cidade" id="cidade"
                       value="{{ old('cidade', $e->cidade ?? '') }}"
                       class="form-control"
                       placeholder="Ex: Guararapes">
              </div>

              <div class="col-md-2">
                <label class="form-label">UF</label>
                <select name="estado" id="estado"
                        class="form-select @error('estado') is-invalid @enderror">
                  <option value="">UF</option>
                  @php $uf = old('estado', $e->estado ?? ''); @endphp
                  @foreach(['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'] as $u)
                    <option value="{{ $u }}" @selected($uf === $u)>{{ $u }}</option>
                  @endforeach
                </select>
                @error('estado') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-check2-circle me-1"></i> Salvar endereço
              </button>
            </div>
          </form>
        </div>
      </div>

      {{-- =========================
          CARD 3 - DADOS CLÍNICOS
      ========================== --}}
      <div id="card-clinico" class="card shadow-sm border-0 rounded-4 mb-4 js-card">
        <div class="card-header bg-light fw-bold rounded-top-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
          <div class="d-flex align-items-center gap-2">
            <span><i class="bi bi-3-circle me-1"></i> Dados clínicos</span>
            <span class="badge text-bg-secondary fw-normal js-status">Sem alterações</span>
          </div>
          <a href="#card-contatos" class="small text-decoration-none">Ir para contatos ↓</a>
        </div>

        <div class="card-body p-4">
          @php $c = $idoso->dadosClinico; @endphp

          <form method="POST" action="{{ route('idosos.update.step3', $idoso->id) }}">
            @csrf
            @method('PUT')

            <div class="row g-3">

              <div class="col-md-4">
                <label class="form-label">Cartão SUS</label>
                <input type="text"
                       name="cartao_sus"
                       id="cartao_sus"
                       inputmode="numeric"
                       autocomplete="off"
                       placeholder="000 0000 0000 0000"
                       value="{{ old('cartao_sus', $c->cartao_sus ?? '') }}"
                       class="form-control @error('cartao_sus') is-invalid @enderror">
                @error('cartao_sus') <div class="invalid-feedback">{{ $message }}</div> @enderror
                <small class="text-muted">Formato: 15 dígitos.</small>
              </div>

              <div class="col-md-4">
                <label class="form-label">Plano de saúde</label>

                @php
                  $planosFamosos = [
                    'Unimed','Bradesco Saúde','SulAmérica','Amil',
                    'Hapvida NotreDame Intermédica','Porto Saúde','São Cristóvão Saúde',
                    'Prevent Senior','Assim Saúde','BlueMed',
                  ];

                  $planoAtual = old('plano_saude', $c->plano_saude ?? '');
                  $isOutro = $planoAtual && !in_array($planoAtual, $planosFamosos) && $planoAtual !== 'Não possui';
                @endphp

                <select name="plano_saude" id="plano_saude_select"
                        class="form-select @error('plano_saude') is-invalid @enderror">
                  <option value="">Selecione</option>
                  <option value="Não possui" @selected($planoAtual === 'Não possui')>Não possui</option>

                  <optgroup label="Planos mais comuns">
                    @foreach($planosFamosos as $p)
                      <option value="{{ $p }}" @selected($planoAtual === $p)>{{ $p }}</option>
                    @endforeach
                  </optgroup>

                  <option value="__outro__" @selected($isOutro)>Outro plano</option>
                </select>

                @error('plano_saude') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-md-4" id="wrap_outro_plano">
                <label class="form-label">Qual plano?</label>
                <input type="text"
                       id="outro_plano_input"
                       class="form-control"
                       placeholder="Digite o nome do plano"
                       value="{{ $isOutro ? $planoAtual : '' }}">
                <small class="text-muted">Será salvo como “Plano de saúde”.</small>
              </div>

              <div class="col-md-4" id="wrap_numero_plano">
                <label class="form-label">Número do plano</label>
                <input type="text"
                       name="numero_plano"
                       id="numero_plano"
                       value="{{ old('numero_plano', $c->numero_plano ?? '') }}"
                       class="form-control @error('numero_plano') is-invalid @enderror"
                       placeholder="Carteirinha / matrícula / código">
                @error('numero_plano') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-md-3">
                <label class="form-label">Tipo sanguíneo</label>
                <select name="tipo_sanguineo" class="form-select @error('tipo_sanguineo') is-invalid @enderror">
                  @php $ts = old('tipo_sanguineo', $c->tipo_sanguineo ?? ''); @endphp
                  <option value="">Selecione</option>
                  <option value="A+" @selected($ts==='A+')>A+</option>
                  <option value="A-" @selected($ts==='A-')>A-</option>
                  <option value="B+" @selected($ts==='B+')>B+</option>
                  <option value="B-" @selected($ts==='B-')>B-</option>
                  <option value="AB+" @selected($ts==='AB+')>AB+</option>
                  <option value="AB-" @selected($ts==='AB-')>AB-</option>
                  <option value="O+" @selected($ts==='O+')>O+</option>
                  <option value="O-" @selected($ts==='O-')>O-</option>
                  <option value="Não sabe" @selected($ts==='Não sabe')>Não sabe</option>
                </select>
                @error('tipo_sanguineo') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-12">
                <label class="form-label">Alergias</label>
                <textarea name="alergias" class="form-control" rows="3"
                          placeholder="Ex: dipirona, poeira, frutos do mar...">{{ old('alergias', $c->alergias ?? '') }}</textarea>
              </div>

              <div class="col-12">
                <label class="form-label">Doenças crônicas</label>
                <textarea name="doencas_cronicas" class="form-control" rows="3"
                          placeholder="Ex: hipertensão, diabetes, asma...">{{ old('doencas_cronicas', $c->doencas_cronicas ?? '') }}</textarea>
              </div>

              <div class="col-12">
                <label class="form-label">Restrições</label>
                <textarea name="restricoes" class="form-control" rows="3"
                          placeholder="Ex: não pode ficar sozinho, restrição alimentar...">{{ old('restricoes', $c->restricoes ?? '') }}</textarea>
              </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-check2-circle me-1"></i> Salvar dados clínicos
              </button>
            </div>
          </form>
        </div>
      </div>

      {{-- =========================
          CARD 4 - CONTATOS
      ========================== --}}
      <div id="card-contatos" class="card shadow-sm border-0 rounded-4 mb-4 js-card">
        <div class="card-header bg-light fw-bold rounded-top-4">
          <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
              <span><i class="bi bi-4-circle me-1"></i> Contatos de emergência</span>
              <span class="badge text-bg-secondary fw-normal js-status">Sem alterações</span>
            </div>
          </div>
        </div>

        <div class="card-body p-4">
          <form method="POST" action="{{ route('idosos.update.step4', $idoso->id) }}">
            @csrf
            @method('PUT')

            <div id="contatos-wrapper">
              @php
                $contatos = old('contatos', $idoso->contatosEmergencia->toArray());
                $principalIndex = old('principal', 0);
              @endphp

              @forelse($contatos as $i => $ct)
                <div class="border rounded-4 p-3 mb-3 contato-item js-contato" data-index="{{ $i }}">
                  <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-2">
                    <strong class="d-flex align-items-center gap-2">
                      Contato #{{ $i+1 }}
                      <span class="badge text-bg-success {{ ((int)$principalIndex === (int)$i) ? '' : 'd-none' }} js-badge-principal">Principal</span>
                    </strong>

                    <div class="d-flex align-items-center gap-2">
                      <div class="form-check form-check-inline m-0">
                        <input class="form-check-input js-radio-principal"
                               type="radio"
                               name="principal"
                               value="{{ $i }}"
                               @checked((int)$principalIndex === (int)$i)>
                        <label class="form-check-label small">Definir como principal</label>
                      </div>

                      <button type="button" class="btn btn-outline-danger btn-sm btn-remove-contato">
                        <i class="bi bi-x-circle me-1"></i> Remover
                      </button>
                    </div>
                  </div>

                  <div class="row g-3">
                    <div class="col-md-6">
                      <label class="form-label">Nome *</label>
                      <input type="text"
                             name="contatos[{{ $i }}][nome]"
                             value="{{ $ct['nome'] ?? '' }}"
                             class="form-control"
                             required>
                    </div>

                    <div class="col-md-4">
                      <label class="form-label">Telefone *</label>
                      <input type="text"
                             name="contatos[{{ $i }}][telefone]"
                             value="{{ $ct['telefone'] ?? '' }}"
                             class="form-control js-phone"
                             inputmode="numeric"
                             placeholder="(00) 00000-0000"
                             required>
                    </div>

                    <div class="col-md-2">
                      <label class="form-label">Parentesco</label>
                      <input type="text"
                             name="contatos[{{ $i }}][parentesco]"
                             value="{{ $ct['parentesco'] ?? '' }}"
                             class="form-control"
                             placeholder="Ex: Filho(a)">
                    </div>
                  </div>
                </div>
              @empty
                <div class="border rounded-4 p-3 mb-3 contato-item js-contato" data-index="0">
                  <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-2">
                    <strong class="d-flex align-items-center gap-2">
                      Contato #1
                      <span class="badge text-bg-success js-badge-principal">Principal</span>
                    </strong>

                    <div class="form-check form-check-inline m-0">
                      <input class="form-check-input js-radio-principal" type="radio" name="principal" value="0" checked>
                      <label class="form-check-label small">Definir como principal</label>
                    </div>
                  </div>

                  <div class="row g-3">
                    <div class="col-md-6">
                      <label class="form-label">Nome *</label>
                      <input type="text" name="contatos[0][nome]" class="form-control" placeholder="Ex: Ana Silva" required>
                    </div>

                    <div class="col-md-4">
                      <label class="form-label">Telefone *</label>
                      <input type="text" name="contatos[0][telefone]" class="form-control js-phone" inputmode="numeric" placeholder="(00) 00000-0000" required>
                    </div>

                    <div class="col-md-2">
                      <label class="form-label">Parentesco</label>
                      <input type="text" name="contatos[0][parentesco]" class="form-control" placeholder="Ex: Filha">
                    </div>
                  </div>
                </div>
              @endforelse
            </div>

            {{-- Template para adicionar contato --}}
            <template id="tpl-contato">
              <div class="border rounded-4 p-3 mb-3 contato-item js-contato" data-index="__i__">
                <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-2">
                  <strong class="d-flex align-items-center gap-2">
                    Contato #__n__
                    <span class="badge text-bg-success d-none js-badge-principal">Principal</span>
                  </strong>

                  <div class="d-flex align-items-center gap-2">
                    <div class="form-check form-check-inline m-0">
                      <input class="form-check-input js-radio-principal" type="radio" name="principal" value="__i__">
                      <label class="form-check-label small">Definir como principal</label>
                    </div>

                    <button type="button" class="btn btn-outline-danger btn-sm btn-remove-contato">
                      <i class="bi bi-x-circle me-1"></i> Remover
                    </button>
                  </div>
                </div>

                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="form-label">Nome *</label>
                    <input type="text" name="contatos[__i__][nome]" class="form-control" required>
                  </div>

                  <div class="col-md-4">
                    <label class="form-label">Telefone *</label>
                    <input type="text" name="contatos[__i__][telefone]" class="form-control js-phone" inputmode="numeric" placeholder="(00) 00000-0000" required>
                  </div>

                  <div class="col-md-2">
                    <label class="form-label">Parentesco</label>
                    <input type="text" name="contatos[__i__][parentesco]" class="form-control" placeholder="Ex: Irmão/Filho">
                  </div>
                </div>
              </div>
            </template>

            @error('contatos') <div class="text-danger mb-2">{{ $message }}</div> @enderror

            <div class="d-flex justify-content-between flex-wrap gap-2 mt-3">
              <button type="button" id="btn-add-contato" class="btn btn-outline-primary">
                <i class="bi bi-plus-circle me-1"></i> Adicionar contato
              </button>

              <button type="submit" class="btn btn-primary">
                <i class="bi bi-check2-circle me-1"></i> Salvar contatos
              </button>
            </div>
          </form>
        </div>
      </div>

    </div>{{-- /col-lg-9 --}}
  </div>{{-- /row --}}
</div>{{-- /container --}}

{{-- CSS opcional (deixa mais “premium”) --}}
@push('styles')
<style>
  .card { transition: box-shadow .15s ease, transform .15s ease; }
  .card:focus-within { box-shadow: 0 .75rem 1.5rem rgba(0,0,0,.08) !important; }
  .list-group-item { border: 0; border-radius: .75rem; }
  .list-group-item:hover { background: rgba(13,110,253,.06); }
  .form-control:focus, .form-select:focus {
    box-shadow: 0 0 0 .2rem rgba(13,110,253,.15);
    border-color: rgba(13,110,253,.35);
  }
  .contato-item { background: #fff; }
</style>
@endpush

{{-- Scripts (scroll, máscaras, status, contatos, viaCEP) --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {

    // =========================
    // HELPERS
    // =========================
    const onlyDigits = (v) => (v || '').replace(/\D/g, '');

    // =========================
    // STEP 2 - CEP VIA VIACEP
    // =========================
    const cep    = document.getElementById('cep');
    const rua    = document.getElementById('rua');
    const bairro = document.getElementById('bairro');
    const cidade = document.getElementById('cidade');
    const estado = document.getElementById('estado');

    let timerCep = null;

    if (cep) {
        cep.addEventListener('input', () => {
            clearTimeout(timerCep);

            let v = onlyDigits(cep.value).slice(0, 8);
            cep.value = (v.length >= 6) ? v.replace(/^(\d{5})(\d{1,3})$/, '$1-$2') : v;

            timerCep = setTimeout(async () => {
                const cepLimpo = onlyDigits(cep.value);
                if (cepLimpo.length !== 8) return;

                try {
                    const res = await fetch(`https://viacep.com.br/ws/${cepLimpo}/json/`);
                    const data = await res.json();
                    if (data.erro) return;

                    if (rua) rua.value = data.logradouro || '';
                    if (bairro) bairro.value = data.bairro || '';
                    if (cidade) cidade.value = data.localidade || '';
                    if (estado) estado.value = data.uf || '';
                } catch (e) {
                    // silencioso
                }
            }, 400);
        });
    }

    // =========================
    // STEP 3 - CARTÃO SUS MÁSCARA
    // =========================
    const sus = document.getElementById('cartao_sus');

    function formatSUS(v) {
        v = onlyDigits(v).slice(0, 15); // 15 dígitos
        const p1 = v.slice(0,3);
        const p2 = v.slice(3,7);
        const p3 = v.slice(7,11);
        const p4 = v.slice(11,15);
        return [p1, p2, p3, p4].filter(Boolean).join(' ');
    }

    if (sus) {
        sus.value = formatSUS(sus.value);

        sus.addEventListener('input', () => {
            const pos = sus.selectionStart;
            const old = sus.value;

            sus.value = formatSUS(sus.value);

            if (pos && old.length < sus.value.length) {
                sus.selectionEnd = pos + 1;
            }
        });
    }

    // =========================
    // STEP 3 - PLANO DE SAÚDE UI
    // =========================
    const selectPlano = document.getElementById('plano_saude_select');
    const wrapOutro   = document.getElementById('wrap_outro_plano');
    const outroInput  = document.getElementById('outro_plano_input');

    const wrapNumero  = document.getElementById('wrap_numero_plano');
    const numeroPlano = document.getElementById('numero_plano');

    function applyPlanoUI() {
        if (!selectPlano) return;

        const val = selectPlano.value || '';
        const isNaoPossui = (val === 'Não possui');
        const isOutro = (val === '__outro__');
        const hasPlano = (!!val && !isNaoPossui);

        if (wrapOutro)  wrapOutro.classList.toggle('d-none', !isOutro);
        if (wrapNumero) wrapNumero.classList.toggle('d-none', !hasPlano);

        if (isNaoPossui) {
            if (numeroPlano) numeroPlano.value = '';
            if (outroInput) outroInput.value = '';
        }

        if (!isOutro && outroInput) {
            outroInput.value = '';
        }
    }

    if (selectPlano) {
        applyPlanoUI();
        selectPlano.addEventListener('change', applyPlanoUI);

        // antes de enviar: "Outro" vira texto real em plano_saude
        const formClinico = selectPlano.closest('form');

        if (formClinico) {
            formClinico.addEventListener('submit', () => {
                const oldHidden = formClinico.querySelector('input[name="plano_saude"][data-hidden="1"]');
                if (oldHidden) oldHidden.remove();

                if (selectPlano.value === '__outro__') {
                    const nomeOutro = (outroInput?.value || '').trim();

                    const hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = 'plano_saude';
                    hidden.value = nomeOutro;
                    hidden.setAttribute('data-hidden', '1');
                    formClinico.appendChild(hidden);

                    selectPlano.name = 'plano_saude_fake';
                } else {
                    selectPlano.name = 'plano_saude';
                }
            });
        }
    }

    // =========================
    // STEP 1 + STEP 4 - TELEFONE BR MÁSCARA
    // =========================
    function formatPhoneBR(v) {
        v = onlyDigits(v).slice(0, 11);

        if (v.length <= 10) {
            const a = v.slice(0,2);
            const b = v.slice(2,6);
            const c = v.slice(6,10);
            if (!a) return v;
            return `(${a}) ${b}${c ? '-' + c : ''}`.trim();
        } else {
            const a = v.slice(0,2);
            const b = v.slice(2,7);
            const c = v.slice(7,11);
            return `(${a}) ${b}${c ? '-' + c : ''}`;
        }
    }

    function maskPhone(input) {
        if (!input) return;
        input.value = formatPhoneBR(input.value);

        input.addEventListener('input', () => {
            const pos = input.selectionStart;
            const old = input.value;

            input.value = formatPhoneBR(input.value);

            if (pos && old.length < input.value.length) {
                input.selectionEnd = pos + 1;
            }
        });
    }

    // telefone do idoso (se existir na tela)
    maskPhone(document.getElementById('telefone'));

    function maskAllPhonesInContacts() {
        document.querySelectorAll('#contatos-wrapper input[name*="[telefone]"]').forEach(maskPhone);
    }
    maskAllPhonesInContacts();

    // =========================
    // STEP 1 - CPF MÁSCARA + VALIDAÇÃO (client-side)
    // =========================
    const cpfInput = document.getElementById('cpf');
    const formStep1 = document.getElementById('form-step1'); // se você tiver esse id no form
    const cpfClientError = document.getElementById('cpfClientError'); // opcional

    function formatCPF(v) {
        v = onlyDigits(v).slice(0, 11);
        const p1 = v.slice(0,3);
        const p2 = v.slice(3,6);
        const p3 = v.slice(6,9);
        const p4 = v.slice(9,11);

        let out = p1;
        if (p2) out += '.' + p2;
        if (p3) out += '.' + p3;
        if (p4) out += '-' + p4;
        return out;
    }

    function isValidCPF(cpf) {
        cpf = onlyDigits(cpf);
        if (cpf.length !== 11) return false;
        if (/^(\d)\1+$/.test(cpf)) return false;

        let sum = 0;
        for (let i = 0; i < 9; i++) sum += parseInt(cpf.charAt(i)) * (10 - i);
        let d1 = 11 - (sum % 11);
        if (d1 >= 10) d1 = 0;

        sum = 0;
        for (let i = 0; i < 10; i++) sum += parseInt(cpf.charAt(i)) * (11 - i);
        let d2 = 11 - (sum % 11);
        if (d2 >= 10) d2 = 0;

        return d1 === parseInt(cpf.charAt(9)) && d2 === parseInt(cpf.charAt(10));
    }

    function setCpfInvalid(isInvalid) {
        if (!cpfInput) return;
        cpfInput.classList.toggle('is-invalid', isInvalid);
        if (cpfClientError) cpfClientError.classList.toggle('d-none', !isInvalid);
    }

    if (cpfInput) {
        cpfInput.value = formatCPF(cpfInput.value);

        cpfInput.addEventListener('input', () => {
            cpfInput.value = formatCPF(cpfInput.value);
            setCpfInvalid(false);
        });

        cpfInput.addEventListener('blur', () => {
            const v = onlyDigits(cpfInput.value);
            if (!v) return setCpfInvalid(false); // cpf opcional
            setCpfInvalid(!isValidCPF(v));
        });
    }

    // se você quiser bloquear submit quando CPF inválido:
    if (formStep1 && cpfInput) {
        formStep1.addEventListener('submit', (e) => {
            const v = onlyDigits(cpfInput.value);
            if (!v) return;
            if (!isValidCPF(v)) {
                e.preventDefault();
                setCpfInvalid(true);
                cpfInput.focus();
            }
        });
    }

    // =========================
    // STEP 4 - CONTATOS: add/remove dinâmico + reindex
    // =========================
    const wrapper = document.getElementById('contatos-wrapper');
    const btnAdd = document.getElementById('btn-add-contato');

    function reindex() {
        if (!wrapper) return;

        const items = wrapper.querySelectorAll('.contato-item');
        items.forEach((item, index) => {
            const strong = item.querySelector('strong');
            if (strong) {
                strong.innerHTML = `Contato #${index + 1} ${index === 0 ? '<span class="badge bg-success ms-2">Principal</span>' : ''}`;
            }

            item.querySelectorAll('input').forEach(inp => {
                inp.name = inp.name.replace(/contatos\[\d+\]/, `contatos[${index}]`);
            });
        });

        maskAllPhonesInContacts();
    }

    if (wrapper) {
        wrapper.addEventListener('click', (e) => {
            if (e.target.closest('.btn-remove-contato')) {
                const items = wrapper.querySelectorAll('.contato-item');
                if (items.length <= 1) {
                    alert('É obrigatório manter pelo menos 1 contato.');
                    return;
                }
                e.target.closest('.contato-item').remove();
                reindex();
            }
        });
    }

    if (btnAdd && wrapper) {
        btnAdd.addEventListener('click', () => {
            const index = wrapper.querySelectorAll('.contato-item').length;

            const div = document.createElement('div');
            div.className = 'border rounded-4 p-3 mb-3 contato-item';
            div.innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <strong>Contato #${index + 1} ${index === 0 ? '<span class="badge bg-success ms-2">Principal</span>' : ''}</strong>
                    <button type="button" class="btn btn-outline-danger btn-sm btn-remove-contato">
                        <i class="bi bi-x-circle me-1"></i> Remover
                    </button>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nome *</label>
                        <input type="text" name="contatos[${index}][nome]" class="form-control" placeholder="Ex: Ana Silva" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Telefone *</label>
                        <input type="text" name="contatos[${index}][telefone]" class="form-control" inputmode="numeric" placeholder="(00) 00000-0000" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Parentesco</label>
                        <input type="text" name="contatos[${index}][parentesco]" class="form-control" placeholder="Ex: Filha">
                    </div>
                </div>
            `;

            wrapper.appendChild(div);
            reindex();
        });
    }

});
</script>
@endpush
@endsection