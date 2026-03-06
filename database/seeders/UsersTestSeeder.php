<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersTestSeeder extends Seeder
{
    public function run(): void
    {
        $nomes = [
            'João','Maria','José','Antônio','Francisco','Carlos','Paulo','Pedro',
            'Lucas','Marcos','Ana','Juliana','Fernanda','Patrícia','Luciana',
            'Ricardo','Eduardo','André','Daniel','Roberto'
        ];

        $sobrenomes = [
            'Silva','Souza','Oliveira','Santos','Rodrigues','Ferreira',
            'Alves','Pereira','Lima','Gomes'
        ];

        for ($i = 1; $i <= 150; $i++) {
            $nome = $nomes[array_rand($nomes)];
            $sobrenome = $sobrenomes[array_rand($sobrenomes)];
            $inicio = Carbon::now()->subDays(14);
            $fim = Carbon::now();

            $dataCadastro = $inicio->copy()->addSeconds(rand(0, $inicio->diffInSeconds($fim)));

            User::create([
                'name' => $nome,
                'sobrenome' => $sobrenome,
                'email' => strtolower($nome) . $i . '@teste.com',
                'cpf' => str_pad((string) $i, 11, '0', STR_PAD_LEFT),
                'telefone' => '1899' . rand(1000000,9999999),

                'data_nascimento' => Carbon::now()
                    ->subYears(rand(18,70))
                    ->subDays(rand(0,365)),

                'cep' => '16700000',
                'logradouro' => 'Rua Teste ' . rand(1,200),
                'numero' => rand(1,500),
                'bairro' => 'Centro',
                'cidade' => 'Guararapes',
                'estado' => 'SP',

                'password' => Hash::make('12345678'),
                'is_admin' => rand(1,100) <= 5,

                'created_at' => $dataCadastro,
                'updated_at' => $dataCadastro
            ]);
        }
    }
}