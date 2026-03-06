<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'cpf' => [
                'required',
                'regex:/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/',
                Rule::unique('users', 'cpf')->ignore($user->id, 'id'),
            ],
            'telefone' => ['required', 'regex:/^\(\d{2}\)\s\d{4,5}\-\d{4}$/'],
            'data_nascimento' => ['nullable', 'date'],
            'cep' => ['nullable', 'regex:/^\d{5}\-\d{3}$/'],
            'logradouro' => ['nullable', 'string', 'max:255'],
            'numero' => ['nullable', 'string', 'max:20'],
            'bairro' => ['nullable', 'string', 'max:255'],
            'cidade' => ['nullable', 'string', 'max:255'],
            'estado' => ['nullable', 'string', 'max:2'],
            'complemento' => ['nullable', 'string', 'max:255'],
        ], [
            'name.required' => 'Informe o nome.',
            'email.required' => 'Informe o email.',
            'email.email' => 'Informe um email válido.',
            'email.unique' => 'Este email já está em uso.',

            'cpf.required' => 'Informe o CPF.',
            'cpf.regex' => 'Informe o CPF no formato 000.000.000-00.',
            'cpf.unique' => 'Este CPF já está cadastrado.',

            'telefone.required' => 'Informe o telefone.',
            'telefone.regex' => 'Informe o telefone no formato (00) 00000-0000.',

            'cep.regex' => 'Informe o CEP no formato 00000-000.',
        ]);

        $user->fill([
            'name' => $request->name,
            'email' => $request->email,
            'cpf' => preg_replace('/\D/', '', $request->cpf),
            'telefone' => preg_replace('/\D/', '', $request->telefone),
            'data_nascimento' => $request->data_nascimento,
            'cep' => $request->cep ? preg_replace('/\D/', '', $request->cep) : null,
            'logradouro' => $request->logradouro,
            'numero' => $request->numero,
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
            'estado' => $request->estado ? strtoupper($request->estado) : null,
            'complemento' => $request->complemento,
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return back()->with('success', 'Perfil atualizado com sucesso!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}