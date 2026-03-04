<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Idoso;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalIdosos = Idoso::count();
        $totalAdmins = User::where('is_admin', true)->count();
        $totalTutores = User::where('is_admin', false)->count();

        $ultimosUsuarios = User::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalIdosos',
            'totalAdmins',
            'totalTutores',
            'ultimosUsuarios'
        ));
    }

    public function users()
    {
        $users = \App\Models\User::with('idosos')->get();
        return view('admin.users', compact('users'));
    }

    public function idosos()
    {
        $idosos = Idoso::with('users')->latest()->get();
        return view('admin.idosos', compact('idosos'));
    }
}
