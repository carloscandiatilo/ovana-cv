<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('infraestrutura_ensinos')) {
            Schema::create('infraestrutura_ensinos', function (Blueprint $table) {
                $table->id();
                $table->foreignId('curriculum_id')
                      ->constrained('curriculums')
                      ->cascadeOnDelete();
                $table->string('instituicao');
                $table->string('tipo_infraestrutura');
                $table->string('nome_lab_plataforma')->nullable();
                $table->string('registro_responsavel')->nullable();
                $table->integer('ano')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('infraestrutura_ensinos');
    }
};
