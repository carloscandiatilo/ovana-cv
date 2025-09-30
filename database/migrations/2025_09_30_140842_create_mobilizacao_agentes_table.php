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
        Schema::create('mobilizacoesagente', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curriculum_id')->constrained('curriculums')->cascadeOnDelete();
            $table->string('tipo_acao');
            $table->string('instituicao_parceira')->nullable();
            $table->string('local_actividade')->nullable();
            $table->string('nome_mecanismo')->nullable();
            $table->integer('ano')->nullable();
            $table->string('coordenador_protocolo')->nullable();
            $table->string('instituicao')->nullable();
            $table->integer('inicio')->nullable();
            $table->integer('fim')->nullable();
            $table->string('instituicoes_envolvidas')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobilizacao_agentes');
    }
};
