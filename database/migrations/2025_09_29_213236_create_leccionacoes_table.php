<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('leccionacoes')) {
            Schema::create('leccionacoes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('curriculum_id')
                      ->constrained('curriculums')
                      ->cascadeOnDelete();
                $table->string('pais');
                $table->string('instituicao');
                $table->string('tipo_participacao');
                $table->string('disciplina');
                $table->integer('ano')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('leccionacoes');
    }
};
