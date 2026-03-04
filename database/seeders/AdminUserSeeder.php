<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'jose.de.barros0192@gmail.com'],
            [
                'name' => 'Administrador Basoa',
                'cpf' => '59940754850',
                'password' => Hash::make('Js@Bs52a'),
                'is_admin' => true,
            ]
        );
    }
}
