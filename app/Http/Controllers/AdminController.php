<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Idoso;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsers   = User::count();
        $totalIdosos  = Idoso::count();
        $totalAdmins  = User::where('is_admin', true)->count();
        $totalTutores = User::where('is_admin', false)->count();

        // Idosos vinculados / não vinculados (precisa existir relação users() no model Idoso)
        $idososComTutor  = Idoso::has('users')->count();
        $idososSemTutor  = Idoso::doesntHave('users')->count();

        // Listas (para área dinâmica)
        $ultimosUsuarios = User::orderBy('is_admin', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $ultimosIdosos = Idoso::with('users')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Gráficos: últimos 14 dias
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

        // Preenche dias sem registro com 0
        $usersByDay = $dias->map(fn($d) => (int) ($usersRaw[$d] ?? 0))->values();
        $idososByDay = $dias->map(fn($d) => (int) ($idososRaw[$d] ?? 0))->values();

        // Labels bonitos (dd/mm)
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
        $users = User::with('idosos')
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
}