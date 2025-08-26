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
        Schema::create('user_entities', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Usuario asignado
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Entidad asignada (persona o empresa)
            $table->string('entity_dni');

            $table->timestamps();
            $table->softDeletes();

            // Clave única para evitar duplicados
            $table->unique(['user_id', 'entity_dni']);

            // Índices para optimizar consultas
            $table->index('user_id');
            $table->index('entity_dni');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_entities');
    }
};
