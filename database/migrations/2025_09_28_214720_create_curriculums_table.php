<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('curriculums', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('status')->default('pendente');
            $table->string('avatar')->nullable();
            
            // Dados pessoais (JSON)
            $table->json('pessoal')->nullable();

            // Blocos repetíveis (JSON)
            $table->json('formacoes_academicas')->nullable();
            $table->json('formacoes_complementares')->nullable();
            $table->json('premios')->nullable();
            $table->json('actuacoes_profissionais')->nullable();
            $table->json('actuacoes_docencias')->nullable();
            $table->json('investigacoes_cientificas')->nullable();
            $table->json('extensoes_universitarias')->nullable();
            $table->json('captacoes_financiamentos')->nullable();

            $table->timestamps();
        });

        // Tabela de idiomas
        Schema::create('idiomas', function (Blueprint $table) {
            $table->id();
            $table->string('nome'); // ex: "Português", "Inglês"
            $table->timestamps();
        });

        // Tabela pivô para relacionamento muitos-para-muitos
        Schema::create('curriculum_idioma', function (Blueprint $table) {
        $table->id();
        $table->foreignId('curriculum_id')->constrained('curriculums')->onDelete('cascade');
        $table->foreignId('idioma_id')->constrained('idiomas')->onDelete('cascade');
        $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('curriculum_idioma');
        Schema::dropIfExists('idiomas');
        Schema::dropIfExists('curriculums');
    }
};