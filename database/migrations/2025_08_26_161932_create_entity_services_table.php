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
        Schema::create('entity_services', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Entidad cliente (persona o empresa)
            $table->string('entity_dni');

            // Servicio asignado
            $table->foreignUuid('service_id')->constrained()->onDelete('cascade');

            // Información del servicio para el cliente
            $table->decimal('price', 10, 2)->default(0);
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            // Información adicional
            $table->text('notes')->nullable();
            $table->json('custom_fields')->nullable(); // Campos personalizados

            $table->timestamps();
            $table->softDeletes();

            // Clave única para evitar duplicados
            $table->unique(['entity_dni', 'service_id']);

            // Índices para optimizar consultas
            $table->index('entity_dni');
            $table->index('service_id');
            $table->index('status');
            $table->index(['entity_dni', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entity_services');
    }
};
