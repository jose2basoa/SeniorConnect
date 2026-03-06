<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('medicamentos', function (Blueprint $table) {
            $table->string('dosagem')->nullable()->after('nome');
            $table->string('frequencia')->nullable()->after('horario');
            $table->text('observacoes')->nullable()->after('frequencia');
        });
    }

    public function down(): void
    {
        Schema::table('medicamentos', function (Blueprint $table) {
            $table->dropColumn(['dosagem', 'frequencia', 'observacoes']);
        });
    }
};