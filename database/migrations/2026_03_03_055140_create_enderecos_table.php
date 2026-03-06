<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enderecos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('idoso_id')
                ->constrained('idosos')
                ->cascadeOnDelete();

            $table->string('cep', 8)->nullable();
            $table->string('logradouro')->nullable();
            $table->string('numero', 20)->nullable();
            $table->string('complemento')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->char('estado', 2)->nullable();

            $table->timestamps();

            $table->unique('idoso_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enderecos');
    }
};