<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            $table->string('nome_publico');
            $table->string('cargo')->nullable();
            $table->text('comentario');

            $table->enum('status', ['pendente','aprovado','rejeitado'])
                ->default('pendente');

            $table->boolean('publicado')->default(false);

            $table->timestamp('aprovado_em')->nullable();

            $table->foreignId('aprovado_por')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comentarios');
    }
};