<?php

namespace Database\Seeders;

use App\Models\Evento;
use App\Models\Idoso;
use Illuminate\Database\Seeder;

class EventoSeeder extends Seeder
{
    public function run(): void
    {
        $idosos = Idoso::all();

        if ($idosos->isEmpty()) {
            $this->command?->warn('Nenhum idoso encontrado. Cadastre idosos antes de rodar o EventoSeeder.');
            return;
        }

        $eventosPorTipo = [
            'queda' => [
                'Queda leve no banheiro durante a manhã. Responsável foi avisado e foi feito acompanhamento nas horas seguintes.',
                'Tropeço ao levantar da cama. Sem ferimentos aparentes, mas ficou em observação.',
                'Desequilíbrio na área externa da casa. Relatou dor leve no joelho após o ocorrido.',
            ],
            'medicacao' => [
                'Medicamento da tarde administrado com atraso de aproximadamente 40 minutos.',
                'Dose da manhã não foi tomada no horário habitual. Tutor registrou para acompanhamento.',
                'Houve recusa momentânea da medicação noturna, mas depois foi administrada corretamente.',
            ],
            'sintoma' => [
                'Relato de tontura no início da tarde, com melhora após repouso e hidratação.',
                'Queixa de dor de cabeça leve durante a manhã.',
                'Apresentou indisposição e cansaço fora do padrão habitual.',
            ],
            'consulta' => [
                'Consulta médica realizada para avaliação de rotina. Mantido acompanhamento.',
                'Retorno agendado após avaliação clínica recente.',
                'Atendimento realizado para revisão de sintomas e orientações gerais.',
            ],
            'comportamento' => [
                'Apresentou agitação acima do habitual no período da noite.',
                'Mostrou confusão momentânea ao acordar, com melhora após alguns minutos.',
                'Dia com comportamento mais retraído e pouca interação.',
            ],
            'rotina' => [
                'Rotina da manhã concluída normalmente, com alimentação e hidratação adequadas.',
                'Sono irregular durante a madrugada, com despertares frequentes.',
                'Caminhada leve realizada com supervisão.',
            ],
            'outro' => [
                'Registro geral de acompanhamento realizado pelo tutor.',
                'Observação adicionada para controle e histórico da pessoa acompanhada.',
                'Evento administrativo lançado para organização do acompanhamento.',
            ],
        ];

        foreach ($idosos as $idoso) {
            $quantidade = rand(4, 8);

            for ($i = 0; $i < $quantidade; $i++) {
                $tipo = array_rand($eventosPorTipo);
                $descricao = $eventosPorTipo[$tipo][array_rand($eventosPorTipo[$tipo])];
                $resolvido = (bool) rand(0, 1);

                $createdAt = now()
                    ->subDays(rand(0, 45))
                    ->subHours(rand(0, 23))
                    ->subMinutes(rand(0, 59));

                Evento::create([
                    'idoso_id' => $idoso->id,
                    'tipo' => $tipo,
                    'descricao' => $descricao,
                    'resolvido' => $resolvido,
                    'created_at' => $createdAt,
                    'updated_at' => (clone $createdAt)->addHours(rand(0, 72)),
                ]);
            }
        }

        $this->command?->info('Eventos criados com sucesso.');
    }
}