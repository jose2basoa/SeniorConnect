<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('idosos', function (Blueprint $table) {
            $table->id();

            $table->string('nome');
            $table->date('data_nascimento');
            $table->string('sexo');
            $table->string('cpf')->unique();
            $table->string('telefone');
            $table->text('observacoes')->nullable();

            $table->boolean('status_online')->default(false);
            $table->timestamp('ultima_atividade')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('idosos');
    }
};
