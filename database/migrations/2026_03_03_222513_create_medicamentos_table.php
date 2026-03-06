<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicamentos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('idoso_id')
                ->constrained('idosos')
                ->cascadeOnDelete();

            $table->string('nome');
            $table->string('dosagem')->nullable();
            $table->time('horario');
            $table->string('frequencia')->nullable();
            $table->text('observacoes')->nullable();

            $table->date('data_inicio')->nullable();
            $table->date('data_fim')->nullable();

            $table->boolean('ativo')->default(true);
            $table->boolean('tomado')->default(false);

            $table->timestamps();

            $table->index('idoso_id');
            $table->index('horario');
            $table->index('ativo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicamentos');
    }
};