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
        Schema::create('contatos_emergencia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idoso_id')->constrained()->onDelete('cascade');

            $table->string('nome');
            $table->string('telefone');
            $table->string('parentesco')->nullable();
            $table->integer('prioridade')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contato_emergencias');
    }
};
