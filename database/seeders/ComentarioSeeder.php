<?php

namespace Database\Seeders;

use App\Models\Comentario;
use App\Models\User;
use Illuminate\Database\Seeder;

class ComentarioSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = User::where('is_admin', false)
            ->orderBy('id')
            ->take(3)
            ->get();

        if ($usuarios->count() < 3) {
            return;
        }

        $comentarios = [
            [
                'nome_publico' => $usuarios[0]->name,
                'cargo' => 'Tutor familiar',
                'comentario' => 'A plataforma deixou o acompanhamento muito mais claro no dia a dia. A visualização dos alertas e medicamentos ajuda bastante na rotina.',
            ],
            [
                'nome_publico' => $usuarios[1]->name,
                'cargo' => 'Cuidador',
                'comentario' => 'Gostei da organização das informações e da praticidade para consultar eventos recentes. O sistema transmite uma sensação de controle maior.',
            ],
            [
                'nome_publico' => $usuarios[2]->name,
                'cargo' => 'Responsável',
                'comentario' => 'O Sênior Conecta tem uma proposta muito útil. A centralização dos dados em um só lugar facilita acompanhar a pessoa assistida com mais segurança.',
            ],
        ];

        foreach ($comentarios as $index => $dados) {
            Comentario::updateOrCreate(
                [
                    'user_id' => $usuarios[$index]->id,
                    'comentario' => $dados['comentario'],
                ],
                [
                    'user_id' => $usuarios[$index]->id,
                    'nome_publico' => $dados['nome_publico'],
                    'cargo' => $dados['cargo'],
                    'comentario' => $dados['comentario'],
                    'status' => 'aprovado',
                    'publicado' => true,
                    'aprovado_em' => now(),
                    'aprovado_por' => 1,
                ]
            );
        }
    }
}