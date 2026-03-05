<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contato_emergencias', function (Blueprint $table) {
            $table->id();

            $table->foreignId('idoso_id')
                ->constrained('idosos')
                ->cascadeOnDelete();

            $table->string('nome');
            $table->string('telefone', 20);
            $table->string('parentesco')->nullable();

            // ordem de contato (1 = principal)
            $table->unsignedInteger('prioridade')->default(1);

            $table->timestamps();

            // melhora performance
            $table->index('idoso_id');

            // evita dois contatos com mesma prioridade para o mesmo idoso
            $table->unique(['idoso_id', 'prioridade']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contato_emergencias');
    }
};