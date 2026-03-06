<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
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
        $users = User::orderBy('name')->get();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sobrenome' => ['nullable', 'string', 'max:255'],
            'cpf' => ['required', 'regex:/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/', 'unique:users,cpf'],
            'telefone' => ['required', 'regex:/^\(\d{2}\)\s\d{4,5}\-\d{4}$/'],
            'data_nascimento' => ['nullable', 'date'],
            'cep' => ['nullable', 'regex:/^\d{5}\-\d{3}$/'],
            'logradouro' => ['nullable', 'string', 'max:255'],
            'numero' => ['nullable', 'string', 'max:20'],
            'bairro' => ['nullable', 'string', 'max:255'],
            'cidade' => ['nullable', 'string', 'max:255'],
            'estado' => ['nullable', 'string', 'size:2'],
            'complemento' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $validated['cpf'] = $this->onlyDigits($validated['cpf']);
        $validated['telefone'] = $this->onlyDigits($validated['telefone']);
        $validated['cep'] = $this->onlyDigits($validated['cep'] ?? null);
        $validated['estado'] = isset($validated['estado']) ? strtoupper($validated['estado']) : null;
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('users.index')
            ->with('success', 'Usuário criado com sucesso.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sobrenome' => ['nullable', 'string', 'max:255'],
            'cpf' => [
                'required',
                'regex:/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/',
                Rule::unique('users', 'cpf')->ignore($user->id),
            ],
            'telefone' => ['required', 'regex:/^\(\d{2}\)\s\d{4,5}\-\d{4}$/'],
            'data_nascimento' => ['nullable', 'date'],
            'cep' => ['nullable', 'regex:/^\d{5}\-\d{3}$/'],
            'logradouro' => ['nullable', 'string', 'max:255'],
            'numero' => ['nullable', 'string', 'max:20'],
            'bairro' => ['nullable', 'string', 'max:255'],
            'cidade' => ['nullable', 'string', 'max:255'],
            'estado' => ['nullable', 'string', 'size:2'],
            'complemento' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
        ]);

        $validated['cpf'] = $this->onlyDigits($validated['cpf']);
        $validated['telefone'] = $this->onlyDigits($validated['telefone']);
        $validated['cep'] = $this->onlyDigits($validated['cep'] ?? null);
        $validated['estado'] = isset($validated['estado']) ? strtoupper($validated['estado']) : null;

        $user->update($validated);

        return redirect()->route('users.index')
            ->with('success', 'Usuário atualizado com sucesso.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Usuário removido com sucesso.');
    }
}