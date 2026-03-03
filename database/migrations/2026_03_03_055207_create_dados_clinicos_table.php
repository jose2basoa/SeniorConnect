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
        Schema::create('dados_clinicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idoso_id')->constrained()->onDelete('cascade');

            $table->string('cartao_sus')->nullable();
            $table->string('plano_saude')->nullable();
            $table->string('numero_plano')->nullable();
            $table->string('tipo_sanguineo')->nullable();

            $table->text('alergias')->nullable();
            $table->text('doencas_cronicas')->nullable();
            $table->text('restricoes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dados_clinicos');
    }
};
