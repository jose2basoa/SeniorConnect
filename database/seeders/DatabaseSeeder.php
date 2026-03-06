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
        // ADMIN DO SISTEMA
        $admin = User::updateOrCreate(
            ['email' => 'admin@seniorconecta.com'],
            [
                'name' => 'Administrador Basoa',
                'sobrenome' => 'Sistema',
                'cpf' => '12345678909',
                'telefone' => '18999999999',
                'data_nascimento' => '1995-01-15',
                'cep' => '16700000',
                'logradouro' => 'Rua Benjamin Constant',
                'numero' => '433',
                'bairro' => 'Centro',
                'cidade' => 'Guararapes',
                'estado' => 'SP',
                'complemento' => 'Administração',
                'password' => Hash::make('Js@Bs52a'),
                'is_admin' => true,
            ]
        );

        // TUTOR DE TESTE
        $tutor = User::updateOrCreate(
            ['email' => 'tutor@seniorconecta.com'],
            [
                'name' => 'Paulo',
                'sobrenome' => 'Palhuzi Júnior',
                'cpf' => '98765432100',
                'telefone' => '18981112222',
                'data_nascimento' => '1988-06-20',
                'cep' => '16700000',
                'logradouro' => 'Rua Marechal Deodoro',
                'numero' => '120',
                'bairro' => 'Centro',
                'cidade' => 'Guararapes',
                'estado' => 'SP',
                'complemento' => 'Casa',
                'password' => Hash::make('12345678'),
                'is_admin' => false,
            ]
        );

        // IDOSO FIXO DE TESTE
        $idoso = Idoso::updateOrCreate(
            ['cpf' => '11144477735'],
            [
                'nome' => 'Paulo Palhuzi',
                'data_nascimento' => '1950-05-10',
                'sexo' => 'Masculino',
                'cpf' => '11144477735',
                'telefone' => '18999999999',
                'observacoes' => 'Cadastro gerado automaticamente para testes.',
            ]
        );

        // vínculo fixo do tutor de teste
        $tutor->idosos()->syncWithoutDetaching([$idoso->id]);

        $this->call([
            IdososTestSeeder::class,
            UsersTestSeeder::class,
            VinculosAleatoriosSeeder::class,
            MedicamentoSeeder::class,
            EventoSeeder::class,
        ]);
    }
}