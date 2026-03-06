<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('idoso_id')
                ->constrained('idosos')
                ->cascadeOnDelete();

            $table->string('tipo');
            $table->string('nivel', 20)->default('medio'); // baixo, medio, alto, critico
            $table->string('origem', 20)->default('manual'); // manual, sistema, app
            $table->text('descricao');

            $table->boolean('resolvido')->default(false);
            $table->timestamp('resolvido_em')->nullable();

            $table->timestamp('data_evento')->nullable();

            $table->timestamps();

            $table->index('idoso_id');
            $table->index('tipo');
            $table->index('nivel');
            $table->index('resolvido');
            $table->index('data_evento');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};