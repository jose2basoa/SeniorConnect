<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Idoso;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 🔐 Admin fixo
        User::updateOrCreate(
            ['email' => 'jose.de.barros0192@gmail.com'],
            [
                'name' => 'Administrador Basoa',
                'cpf' => '59940754850',
                'password' => Hash::make('Js@Bs52a'),
                'is_admin' => true,
            ]
        );

        $tutor = User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'cpf' => '00000000000',
                'password' => Hash::make('12345678'),
                'is_admin' => false,
            ]
        );

        $idoso = Idoso::create([
            'nome' => 'João da Silva',
            'data_nascimento' => '1950-05-10',
            'sexo' => 'Masculino',
            'cpf' => '11122233344',
            'telefone' => '18999999999',
            'observacoes' => 'Paciente com acompanhamento mensal.',
        ]);

        // 🔗 VINCULA
        $tutor->idosos()->attach($idoso->id);
    }
}
