<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Idoso;

class VinculosAleatoriosSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('is_admin', false)->get();
        $idosos = Idoso::all();

        if ($users->isEmpty() || $idosos->isEmpty()) {
            return;
        }

        // 1) Para cada usuário comum, vincula de 0 a 3 idosos aleatórios
        foreach ($users as $user) {
            $quantidade = rand(0, 3);

            if ($quantidade > 0) {
                $idososAleatorios = $idosos->random(min($quantidade, $idosos->count()));

                $user->idosos()->syncWithoutDetaching(
                    collect($idososAleatorios)->pluck('id')->toArray()
                );
            }
        }

        // 2) Para alguns idosos, adiciona um segundo ou terceiro tutor aleatório
        foreach ($idosos as $idoso) {
            if (rand(1, 100) <= 35) { // 35% de chance de ter mais vínculos
                $quantidadeExtra = rand(1, 2);

                $usersExtras = $users->random(min($quantidadeExtra, $users->count()));

                $idoso->users()->syncWithoutDetaching(
                    collect($usersExtras)->pluck('id')->toArray()
                );
            }
        }
    }
}