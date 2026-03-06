<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Idoso;
use Carbon\Carbon;

class IdososTestSeeder extends Seeder
{
    public function run(): void
    {
        $nomes = [
            'João', 'Maria', 'José', 'Antônio', 'Francisco',
            'Carlos', 'Paulo', 'Pedro', 'Lucas', 'Marcos',
            'Ana', 'Juliana', 'Fernanda', 'Patrícia', 'Luciana',
            'Roberto', 'Ricardo', 'Eduardo', 'André', 'Daniel'
        ];

        $sobrenomes = [
            'Silva', 'Souza', 'Oliveira', 'Santos', 'Rodrigues',
            'Ferreira', 'Alves', 'Pereira', 'Lima', 'Gomes'
        ];

        for ($i = 1; $i <= 150; $i++) {

            $nome = $nomes[array_rand($nomes)] . ' ' . $sobrenomes[array_rand($sobrenomes)];
            $inicio = Carbon::now()->subDays(14);
            $fim = Carbon::now();

            $dataCadastro = $inicio->copy()->addSeconds(rand(0, $inicio->diffInSeconds($fim)));

            Idoso::create([
                'nome' => $nome,
                'sexo' => $i % 2 == 0 ? 'Masculino' : 'Feminino',

                'cpf' => str_pad(rand(0,99999999999), 11, '0', STR_PAD_LEFT),

                'telefone' => '1899' . rand(1000000,9999999),

                'data_nascimento' => Carbon::now()
                    ->subYears(rand(60,95))
                    ->subDays(rand(0,365)),

                'observacoes' => rand(0,3) == 1
                    ? 'Cadastro gerado automaticamente para testes.'
                    : null,

                'created_at' => $dataCadastro,
                'updated_at' => $dataCadastro
            ]);
        }
    }
}