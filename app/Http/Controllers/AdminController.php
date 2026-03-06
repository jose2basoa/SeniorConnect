<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Idoso;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsers   = User::count();
        $totalIdosos  = Idoso::count();
        $totalAdmins  = User::where('is_admin', true)->count();
        $totalTutores = User::where('is_admin', false)->count();

        $idososComTutor  = Idoso::has('users')->count();
        $idososSemTutor  = Idoso::doesntHave('users')->count();

        $ultimosUsuarios = User::orderBy('is_admin', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $ultimosIdosos = Idoso::with('users')
            ->orderBy('created_at', 'desc')
            ->get();

        $dias = collect(range(13, 0))->map(fn($i) => Carbon::today()->subDays($i)->format('Y-m-d'));

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

        $usersByDay = $dias->map(fn($d) => (int) ($usersRaw[$d] ?? 0))->values();
        $idososByDay = $dias->map(fn($d) => (int) ($idososRaw[$d] ?? 0))->values();

        $labels = $dias->map(fn($d) => Carbon::parse($d)->format('d/m'))->values();

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
        // Melhor: withCount para não ficar contando relação no blade
        $users = User::withCount('idosos')
            ->orderBy('is_admin', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.users', compact('users'));
    }

    public function idosos()
    {
        $idosos = Idoso::with('users')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.idosos', compact('idosos'));
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE USER (com senha se alvo for admin)
    |--------------------------------------------------------------------------
    */
    public function destroyUser(Request $request, User $user)
    {
        // Se alvo é ADMIN, exige senha do usuário logado
        if ($user->is_admin) {
            $request->validate([
                'password' => ['required', 'string'],
            ], [
                'password.required' => 'Informe sua senha para apagar um administrador.',
            ]);

            if (!Hash::check($request->password, Auth::user()->password)) {
                return back()->with('error', 'Senha incorreta.');
            }
        }

        $isSelf = $user->id === Auth::id();

        // (Opcional, recomendado) impedir apagar o último admin:
        // if ($user->is_admin && User::where('is_admin', true)->count() <= 1) {
        //     return back()->with('error', 'Não é possível apagar o último administrador.');
        // }

        $user->delete();

        // Se apagou o próprio usuário, derruba sessão
        if ($isSelf) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('success', 'Seu usuário foi removido.');
        }

        return back()->with('success', 'Usuário removido com sucesso.');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE IDOSO
    |--------------------------------------------------------------------------
    */
    public function destroyIdoso(Request $request, Idoso $idoso)
    {
        $idoso->delete(); // depende do cascade no banco

        return back()->with('success', 'Cadastro removido com sucesso.');
    }

    public function destroyUsersBulk(Request $request)
    {
        $ids = $request->input('ids', []);

        if (!is_array($ids) || count($ids) === 0) {
            return back()->with('error', 'Selecione pelo menos 1 usuário.');
        }

        $users = User::whereIn('id', $ids)->get();

        // Se qualquer selecionado for admin, exige senha do logado
        $temAdminSelecionado = $users->contains(fn($u) => (bool) $u->is_admin);

        if ($temAdminSelecionado) {
            $request->validate([
                'password' => ['required', 'string'],
            ], [
                'password.required' => 'Informe sua senha para apagar administradores.',
            ]);

            if (!Hash::check($request->password, Auth::user()->password)) {
                return back()->with('error', 'Senha incorreta.');
            }
        }

        $isSelf = $users->contains(fn($u) => $u->id === Auth::id());

        // (Opcional recomendado) impedir apagar o último admin:
        // $adminsSelecionados = $users->where('is_admin', true)->count();
        // $totalAdmins = User::where('is_admin', true)->count();
        // if ($adminsSelecionados > 0 && ($totalAdmins - $adminsSelecionados) <= 0) {
        //     return back()->with('error', 'Não é possível apagar o último administrador.');
        // }

        User::whereIn('id', $users->pluck('id'))->delete();

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

        Idoso::whereIn('id', $ids)->delete(); // depende dos cascades
        return back()->with('success', 'Cadastro(s) removido(s) com sucesso.');
    }

    public function createUser()
    {
        return view('admin.users-create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'cpf' => 'required|string|max:14|unique:users,cpf',
            'password' => 'required|string|min:8|confirmed',

            // agora é obrigatório e só pode ser 0 ou 1
            'is_admin' => 'required|in:0,1',
        ], [
            'password.confirmed' => 'A confirmação da senha não confere.',
            'email.unique' => 'Esse email já está em uso.',
            'cpf.unique' => 'Esse CPF já está em uso.',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'cpf' => $request->cpf,
            'password' => Hash::make($request->password),

            // sempre salva 0 ou 1
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
        $request->validate([
            'nome' => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'sexo' => 'required|in:Masculino,Feminino,Outro',
            'cpf' => ['required', 'regex:/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/'],
            'telefone' => ['nullable', 'regex:/^\(\d{2}\)\s\d{4,5}\-\d{4}$/'],
            'observacoes' => 'nullable|string|max:2000',
        ], [
            'nome.required' => 'Informe o nome.',
            'data_nascimento.required' => 'Informe a data de nascimento.',
            'data_nascimento.date' => 'Informe uma data válida.',

            'sexo.required' => 'Selecione o sexo.',
            'sexo.in' => 'Selecione uma opção válida para o sexo.',

            'cpf.required' => 'Informe o CPF.',
            'cpf.regex' => 'Informe o CPF no formato 000.000.000-00.',

            'telefone.required' => 'Informe o telefone.',
            'telefone.regex' => 'Informe o telefone no formato (00) 00000-0000.',        
        ]);

        Idoso::create([
            'nome' => $request->nome,
            'data_nascimento' => $request->data_nascimento,
            'sexo' => $request->sexo,
            'cpf' => preg_replace('/\D/', '', $request->cpf),
            'telefone' => $request->telefone ? preg_replace('/\D/', '', $request->telefone) : null,
            'observacoes' => $request->observacoes,
        ]);

        return redirect()
            ->route('admin.idosos')
            ->with('success', 'Cadastro criado com sucesso!');
    }
}
