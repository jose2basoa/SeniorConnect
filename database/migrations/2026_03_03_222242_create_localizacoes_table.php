<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('localizacoes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('idoso_id')
                ->constrained('idosos')
                ->cascadeOnDelete();

            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);

            $table->string('endereco')->nullable();
            $table->decimal('precisao', 8, 2)->nullable(); // metros, se vier de GPS
            $table->timestamp('capturado_em')->nullable();

            $table->timestamps();

            $table->index('idoso_id');
            $table->index('capturado_em');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('localizacoes');
    }
};