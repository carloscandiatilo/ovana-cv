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
        Schema::create('interaccoescomunidade', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curriculum_id')->constrained('curriculums')->cascadeOnDelete();
            $table->string('tipo_realizacao');
            $table->string('nome_projecto');
            $table->string('estrutura')->nullable();
            $table->string('equipa')->nullable();
            $table->string('funcao')->nullable();
            $table->string('local_realizacao')->nullable();
            $table->string('instituicao')->nullable();
            $table->string('instituicoes_envolvidas')->nullable();
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
        Schema::dropIfExists('interacao_comunidades');
    }
};
