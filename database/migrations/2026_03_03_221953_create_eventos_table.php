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
            $table->foreignId('idoso_id')->constrained('idosos')->onDelete('cascade');
            $table->string('tipo'); // ex: queda, sintoma, alerta
            $table->text('descricao')->nullable();
            $table->boolean('resolvido')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
