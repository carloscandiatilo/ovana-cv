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
        Schema::create('prestacaoservicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curriculum_id')->constrained('curriculums')->cascadeOnDelete();
            $table->string('tipo_acao');
            $table->string('nome_projecto');
            $table->string('curso')->nullable();
            $table->string('equipa')->nullable();
            $table->string('instituicao')->nullable();
            $table->string('instituicao_parceira')->nullable();
            $table->string('coordenador_projecto')->nullable();
            $table->year('inicio')->nullable();
            $table->year('fim')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestacao_servicos');
    }
};
