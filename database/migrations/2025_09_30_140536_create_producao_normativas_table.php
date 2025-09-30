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
        Schema::create('producaonormativas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curriculum_id')->constrained('curriculums')->cascadeOnDelete();
            $table->string('tipo_contribuicao');
            $table->string('nome_projecto');
            $table->string('curso')->nullable();
            $table->string('natureza')->nullable();
            $table->string('area')->nullable();
            $table->string('instituicao')->nullable();
            $table->string('orgao_tutela')->nullable();
            $table->string('funcao')->nullable();
            $table->integer('ano')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producao_normativas');
    }
};
