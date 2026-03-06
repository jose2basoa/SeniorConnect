<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required','string','max:255'],
            'sobrenome' => ['nullable','string','max:255'],

            'cpf' => ['required','string','max:14','unique:users,cpf'],
            'telefone' => ['required','string','max:20'],
            'data_nascimento' => ['nullable','date'],

            'cep' => ['nullable','string','max:9'],
            'logradouro' => ['nullable','string','max:255'],
            'numero' => ['nullable','string','max:20'],
            'bairro' => ['nullable','string','max:255'],
            'cidade' => ['nullable','string','max:255'],
            'estado' => ['nullable','string','max:2'],
            'complemento' => ['nullable','string','max:255'],

            'email' => ['required','string','email','max:255','unique:users,email'],

            'password' => ['required','confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'sobrenome' => $request->sobrenome,

            'cpf' => preg_replace('/\D/', '', $request->cpf),
            'telefone' => preg_replace('/\D/', '', $request->telefone),

            'data_nascimento' => $request->data_nascimento,

            'cep' => preg_replace('/\D/', '', $request->cep),
            'logradouro' => $request->logradouro,
            'numero' => $request->numero,
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
            'estado' => $request->estado,
            'complemento' => $request->complemento,

            'email' => strtolower($request->email),

            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}