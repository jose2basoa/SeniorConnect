<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('idosos', function (Blueprint $table) {
            $table->id();

            $table->string('nome');
            $table->date('data_nascimento');
            $table->string('sexo', 20)->nullable();

            // salvar apenas números no backend
            $table->string('cpf', 11)->unique();
            $table->string('telefone', 20)->nullable();

            $table->text('observacoes')->nullable();

            $table->boolean('status_online')->default(false);
            $table->timestamp('ultima_atividade')->nullable();

            $table->timestamps();

            $table->index('nome');
            $table->index('cpf');
            $table->index('status_online');
            $table->index('ultima_atividade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('idosos');
    }
};