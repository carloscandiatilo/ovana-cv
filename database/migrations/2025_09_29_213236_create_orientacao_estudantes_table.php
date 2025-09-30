<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('orientacao_estudantes')) {
            Schema::create('orientacao_estudantes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('curriculum_id')
                      ->constrained('curriculums')
                      ->cascadeOnDelete();
                $table->string('pais');
                $table->string('tipo_orientacao');
                $table->string('nome_estudante');
                $table->integer('ano_conclusao')->nullable();
                $table->string('instituicao')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('orientacao_estudantes');
    }
};
