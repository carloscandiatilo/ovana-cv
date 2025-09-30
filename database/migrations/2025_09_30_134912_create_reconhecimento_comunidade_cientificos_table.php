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
            Schema::create('reconhecimentocomunidadecientificos', function (Blueprint $table) {
                $table->id();
                $table->foreignId('curriculum_id')->constrained('curriculums')->cascadeOnDelete();
                $table->string('pais');
                $table->string('tipo_reconhecimento');
                $table->string('reconhecimento');
                $table->string('entidade_responsavel')->nullable();
                $table->string('classificacao')->nullable();
                $table->string('tipo_premio')->nullable();
                $table->timestamps();
            });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reconhecimento_comunidade_cientificos');
    }
};
