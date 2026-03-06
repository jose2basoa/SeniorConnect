<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Idoso;
use App\Models\Medicamento;
use Illuminate\Support\Str;

class MedicamentoSeeder extends Seeder
{
    public function run(): void
    {
        $medicamentos = [
            'Losartana',
            'Dipirona',
            'Paracetamol',
            'Omeprazol',
            'Atenolol',
            'Sinvastatina',
            'Metformina',
            'Amoxicilina',
            'Ibuprofeno',
            'Hidroclorotiazida'
        ];

        $frequencias = [
            '1x ao dia',
            '2x ao dia',
            '3x ao dia',
            'A cada 8 horas',
            'A cada 12 horas'
        ];

        $idosos = Idoso::all();

        foreach ($idosos as $idoso) {

            // quantidade aleatória de medicamentos
            $quantidade = rand(0,5);

            for ($i = 0; $i < $quantidade; $i++) {

                Medicamento::create([
                    'idoso_id' => $idoso->id,
                    'nome' => $medicamentos[array_rand($medicamentos)],
                    'dosagem' => rand(1,2)*50 . ' mg',
                    'horario' => sprintf('%02d:%02d', rand(6,22), [0,30][array_rand([0,30])]),
                    'frequencia' => $frequencias[array_rand($frequencias)],
                    'observacoes' => 'Tomar conforme orientação médica.',
                    'tomado' => rand(0,1)
                ]);

            }
        }
        
        $this->command?->info('Medicamentos adicionados com sucesso.');
    }
}