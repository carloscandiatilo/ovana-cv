<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('responsabilidade_orientacoes')) {
            Schema::create('responsabilidade_orientacoes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('curriculum_id')
                      ->constrained('curriculums')
                      ->cascadeOnDelete();
                $table->string('pais');
                $table->string('instituicao');
                $table->string('tipo_responsabilidade');
                $table->string('nome_estudante');
                $table->integer('ano_conclusao')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('responsabilidade_orientacoes');
    }
};
