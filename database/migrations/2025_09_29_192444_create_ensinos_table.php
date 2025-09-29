<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ensinos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curriculum_id')->constrained('curriculums')->cascadeOnDelete();
            $table->string('disciplina');
            $table->string('instituicao')->nullable();
            $table->year('ano')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ensinos');
    }
};
