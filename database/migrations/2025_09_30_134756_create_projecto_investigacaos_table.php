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
        Schema::create('projectoinvestigacaos', function (Blueprint $table) {
                $table->id();
                $table->foreignId('curriculum_id')->constrained('curriculums')->cascadeOnDelete();
                $table->string('tipo_participacao');
                $table->string('nome_projecto');
                $table->text('objectivo')->nullable();
                $table->string('instituicao')->nullable();
                $table->text('membros_equipa')->nullable();
                $table->date('inicio')->nullable();
                $table->timestamps();
            });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projecto_investigacaos');
    }
};
