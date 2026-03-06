<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Idoso;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    private function onlyDigits(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $digits = preg_replace('/\D/', '', $value);

        return $digits !== '' ? $digits : null;
    }

    public function index()
    {
        $totalUsers   = User::count();
        $totalIdosos  = Idoso::count();
        $totalAdmins  = User::where('is_admin', true)->count();
        $totalTutores = User::where('is_admin', false)->count();

        $idososComTutor = Idoso::has('users')->count();
        $idososSemTutor = Idoso::doesntHave('users')->count();

        $ultimosUsuarios = User::withTrashed()
            ->withCount('idosos')
            ->orderByRaw('deleted_at IS NOT NULL')
            ->orderBy('is_admin', 'desc')
            ->orderByDesc('created_at')
            ->get();

        $ultimosIdosos = Idoso::withTrashed()
            ->with('users')
            ->orderByRaw('deleted_at IS NOT NULL')
            ->orderByDesc('created_at')
            ->get();

        $dias = collect(range(13, 0))->map(
            fn ($i) => Carbon::today()->subDays($i)->format('Y-m-d')
        );

        $usersRaw = User::selectRaw('DATE(created_at) as dia, COUNT(*) as total')
            ->where('created_at', '>=', Carbon::today()->subDays(13)->startOfDay())
            ->groupBy('dia')
            ->orderBy('dia')
            ->pluck('total', 'dia');

        $idososRaw = Idoso::selectRaw('DATE(created_at) as dia, COUNT(*) as total')
            ->where('created_at', '>=', Carbon::today()->subDays(13)->startOfDay())
            ->groupBy('dia')
            ->orderBy('dia')
            ->pluck('total', 'dia');

        $usersByDay = $dias->map(fn ($d) => (int) ($usersRaw[$d] ?? 0))->values();
        $idososByDay = $dias->map(fn ($d) => (int) ($idososRaw[$d] ?? 0))->values();
        $labels = $dias->map(fn ($d) => Carbon::parse($d)->format('d/m'))->values();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalIdosos',
            'totalAdmins',
            'totalTutores',
            'idososComTutor',
            'idososSemTutor',
            'ultimosUsuarios',
            'ultimosIdosos',
            'labels',
            'usersByDay',
            'idososByDay'
        ));
    }

    public function users()
    {
        $users = User::withTrashed()
            ->withCount('idosos')
            ->orderByRaw('deleted_at IS NOT NULL')
            ->orderBy('is_admin', 'desc')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.users', compact('users'));
    }

    public function idosos()
    {
        $idosos = Idoso::withTrashed()
            ->with('users')
            ->orderByRaw('deleted_at IS NOT NULL')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.idosos', compact('idosos'));
    }

    public function destroyUser(Request $request, User $user)
    {
        if ($user->trashed()) {
            return back()->with('error', 'Este usuário já está removido.');
        }

        if ($user->is_admin) {
            $request->validate([
                'password' => ['required', 'string'],
            ], [
                'password.required' => 'Informe sua senha para remover um administrador.',
            ]);

            if (!Hash::check($request->password, Auth::user()->password)) {
                return back()->with('error', 'Senha incorreta.');
            }

            $totalAdminsAtivos = User::where('is_admin', true)->count();

            if ($totalAdminsAtivos <= 1) {
                return back()->with('error', 'Não é possível remover o último administrador.');
            }
        }

        $isSelf = $user->id === Auth::id();

        $user->delete();

        if ($isSelf) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('success', 'Seu usuário foi removido.');
        }

        return back()->with('success', 'Usuário removido com sucesso.');
    }

    public function restoreUser($id)
    {
        $user = User::withTrashed()->findOrFail($id);

        if (!$user->trashed()) {
            return back()->with('error', 'Este usuário já está ativo.');
        }

        $user->restore();

        return back()->with('success', 'Usuário restaurado com sucesso.');
    }

    public function forceDeleteUser(Request $request, $id)
    {
        $user = User::withTrashed()->findOrFail($id);

        if (!$user->trashed()) {
            return back()->with('error', 'Só é possível excluir definitivamente usuários já removidos.');
        }

        if ($user->is_admin) {
            $request->validate([
                'password' => ['required', 'string'],
            ], [
                'password.required' => 'Informe sua senha para excluir definitivamente um administrador.',
            ]);

            if (!Hash::check($request->password, Auth::user()->password)) {
                return back()->with('error', 'Senha incorreta.');
            }

            $totalAdminsRemanescentes = User::where('is_admin', true)
                ->whereNull('deleted_at')
                ->count();

            if ($totalAdminsRemanescentes <= 0) {
                return back()->with('error', 'Não é possível excluir definitivamente este administrador nessa condição.');
            }
        }

        $user->forceDelete();

        return back()->with('success', 'Usuário excluído definitivamente com sucesso.');
    }

    public function destroyIdoso(Request $request, Idoso $idoso)
    {
        if ($idoso->trashed()) {
            return back()->with('error', 'Este cadastro já está removido.');
        }

        $idoso->delete();

        return back()->with('success', 'Cadastro removido com sucesso.');
    }

    public function restoreIdoso($id)
    {
        $idoso = Idoso::withTrashed()->findOrFail($id);

        if (!$idoso->trashed()) {
            return back()->with('error', 'Este cadastro já está ativo.');
        }

        $idoso->restore();

        return back()->with('success', 'Cadastro restaurado com sucesso.');
    }

    public function forceDeleteIdoso($id)
    {
        $idoso = Idoso::withTrashed()->findOrFail($id);

        if (!$idoso->trashed()) {
            return back()->with('error', 'Só é possível excluir definitivamente cadastros já removidos.');
        }

        $idoso->forceDelete();

        return back()->with('success', 'Cadastro excluído definitivamente com sucesso.');
    }

    public function destroyUsersBulk(Request $request)
    {
        $ids = $request->input('ids', []);

        if (!is_array($ids) || count($ids) === 0) {
            return back()->with('error', 'Selecione pelo menos 1 usuário.');
        }

        $users = User::withTrashed()->whereIn('id', $ids)->get();
        $usersAtivos = $users->filter(fn ($u) => !$u->trashed());

        if ($usersAtivos->isEmpty()) {
            return back()->with('error', 'Nenhum usuário ativo foi selecionado.');
        }

        $temAdminSelecionado = $usersAtivos->contains(fn ($u) => (bool) $u->is_admin);

        if ($temAdminSelecionado) {
            $request->validate([
                'password' => ['required', 'string'],
            ], [
                'password.required' => 'Informe sua senha para remover administradores.',
            ]);

            if (!Hash::check($request->password, Auth::user()->password)) {
                return back()->with('error', 'Senha incorreta.');
            }

            $adminsSelecionados = $usersAtivos->where('is_admin', true)->count();
            $totalAdminsAtivos = User::where('is_admin', true)->count();

            if (($totalAdminsAtivos - $adminsSelecionados) <= 0) {
                return back()->with('error', 'Não é possível remover o último administrador.');
            }
        }

        $isSelf = $usersAtivos->contains(fn ($u) => $u->id === Auth::id());

        User::whereIn('id', $usersAtivos->pluck('id'))->delete();

        if ($isSelf) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('success', 'Seu usuário foi removido.');
        }

        return back()->with('success', 'Usuário(s) removido(s) com sucesso.');
    }

    public function destroyIdososBulk(Request $request)
    {
        $ids = $request->input('ids', []);

        if (!is_array($ids) || count($ids) === 0) {
            return back()->with('error', 'Selecione pelo menos 1 cadastro.');
        }

        $idosos = Idoso::withTrashed()->whereIn('id', $ids)->get();
        $idososAtivos = $idosos->filter(fn ($i) => !$i->trashed());

        if ($idososAtivos->isEmpty()) {
            return back()->with('error', 'Nenhum cadastro ativo foi selecionado.');
        }

        Idoso::whereIn('id', $idososAtivos->pluck('id'))->delete();

        return back()->with('success', 'Cadastro(s) removido(s) com sucesso.');
    }

    public function createUser()
    {
        return view('admin.users-create');
    }

    public function storeUser(Request $request)
    {
        $cpf = $this->onlyDigits($request->cpf);
        $email = $request->email;

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sobrenome' => ['nullable', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->whereNull('deleted_at'),
            ],
            'cpf' => ['required', 'regex:/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/'],
            'telefone' => ['required', 'regex:/^\(\d{2}\)\s\d{4,5}\-\d{4}$/'],
            'data_nascimento' => ['nullable', 'date'],
            'cep' => ['nullable', 'regex:/^\d{5}\-\d{3}$/'],
            'logradouro' => ['nullable', 'string', 'max:255'],
            'numero' => ['nullable', 'string', 'max:20'],
            'bairro' => ['nullable', 'string', 'max:255'],
            'cidade' => ['nullable', 'string', 'max:255'],
            'estado' => ['nullable', 'string', 'size:2'],
            'complemento' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'is_admin' => ['required', 'in:0,1'],
        ], [
            'cpf.regex' => 'Informe um CPF válido no formato 000.000.000-00.',
            'telefone.regex' => 'Informe um telefone válido no formato (00) 00000-0000.',
            'cep.regex' => 'Informe um CEP válido no formato 00000-000.',
        ]);

        if (User::withTrashed()->where('cpf', $cpf)->whereNull('deleted_at')->exists()) {
            return back()
                ->withErrors(['cpf' => 'Este CPF já está em uso por um usuário ativo.'])
                ->withInput();
        }

        if (User::onlyTrashed()->where('email', $email)->exists()) {
            return back()
                ->withErrors(['email' => 'Já existe um usuário removido com este e-mail. Restaure o cadastro existente ou use outro e-mail.'])
                ->withInput();
        }

        if (User::onlyTrashed()->where('cpf', $cpf)->exists()) {
            return back()
                ->withErrors(['cpf' => 'Já existe um usuário removido com este CPF. Restaure o cadastro existente ou use outro CPF.'])
                ->withInput();
        }

        User::create([
            'name' => $request->name,
            'sobrenome' => $request->sobrenome,
            'email' => $email,
            'cpf' => $cpf,
            'telefone' => $this->onlyDigits($request->telefone),
            'data_nascimento' => $request->data_nascimento,
            'cep' => $this->onlyDigits($request->cep),
            'logradouro' => $request->logradouro,
            'numero' => $request->numero,
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
            'estado' => $request->estado ? strtoupper($request->estado) : null,
            'complemento' => $request->complemento,
            'password' => Hash::make($request->password),
            'is_admin' => $request->boolean('is_admin'),
        ]);

        return redirect()->route('admin.users')
            ->with('success', 'Usuário criado com sucesso!');
    }

    public function createIdoso()
    {
        return view('admin.idosos-create');
    }

    public function storeIdoso(Request $request)
    {
        $cpf = $this->onlyDigits($request->cpf);

        $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'data_nascimento' => ['required', 'date'],
            'sexo' => ['nullable', 'in:Masculino,Feminino,Outro'],
            'cpf' => ['required', 'regex:/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/'],
            'telefone' => ['nullable', 'regex:/^\(\d{2}\)\s\d{4,5}\-\d{4}$/'],
            'observacoes' => ['nullable', 'string', 'max:2000'],
        ], [
            'cpf.regex' => 'Informe um CPF válido no formato 000.000.000-00.',
            'telefone.regex' => 'Informe um telefone válido no formato (00) 00000-0000.',
        ]);

        if (Idoso::withTrashed()->where('cpf', $cpf)->whereNull('deleted_at')->exists()) {
            return back()
                ->withErrors(['cpf' => 'Este CPF já está em uso por um cadastro ativo.'])
                ->withInput();
        }

        if (Idoso::onlyTrashed()->where('cpf', $cpf)->exists()) {
            return back()
                ->withErrors(['cpf' => 'Já existe um cadastro removido com este CPF. Restaure o cadastro existente ou use outro CPF.'])
                ->withInput();
        }

        Idoso::create([
            'nome' => $request->nome,
            'data_nascimento' => $request->data_nascimento,
            'sexo' => $request->sexo,
            'cpf' => $cpf,
            'telefone' => $this->onlyDigits($request->telefone),
            'observacoes' => $request->observacoes,
        ]);

        return redirect()
            ->route('admin.idosos')
            ->with('success', 'Cadastro criado com sucesso!');
    }
}