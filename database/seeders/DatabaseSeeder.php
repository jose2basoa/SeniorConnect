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
        // 🔐 ADMIN DO SISTEMA
        $admin = User::updateOrCreate(
            ['email' => 'admin@seniorconecta.com'],
            [
                'name' => 'Administrador Basoa',
                'cpf' => '123.456.789-09',
                'password' => Hash::make('Js@Bs52a'),
                'is_admin' => true,
            ]
        );

        // 👤 TUTOR DE TESTE
        $tutor = User::updateOrCreate(
            ['email' => 'tutor@seniorconecta.com'],
            [
                'name' => 'Paulo Palhuzi Júnior',
                'cpf' => '987.654.321-00',
                'password' => Hash::make('12345678'),
                'is_admin' => false,
            ]
        );

        // 👴 IDOSO DE TESTE
        $idoso = Idoso::updateOrCreate(
            ['cpf' => '111.444.777-35'],
            [
                'nome' => 'Paulo Palhuzi',
                'data_nascimento' => '1950-05-10',
                'sexo' => 'Masculino',
                'telefone' => '(18)99999-9999',
                'observacoes' => 'Cadastro gerado automaticamente para testes.',
            ]
        );

        // 🔗 VINCULA IDOSO AO TUTOR
        $tutor->idosos()->syncWithoutDetaching([$idoso->id]);
    }
}