<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('material_pedagogicos')) {
            Schema::create('material_pedagogicos', function (Blueprint $table) {
                $table->id();
                $table->foreignId('curriculum_id')
                      ->constrained('curriculums')
                      ->cascadeOnDelete();
                $table->string('tipo_material');
                $table->year('ano_publicacao')->nullable();
                $table->string('coautor')->nullable();
                $table->string('registro')->nullable();
                $table->string('link')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('material_pedagogicos');
    }
};
