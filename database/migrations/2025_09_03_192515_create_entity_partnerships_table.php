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
        Schema::create('entity_partnerships', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('entity_dni'); // DNI de la empresa
            $table->string('partner_dni'); // DNI del socio (persona u otra empresa)
            $table->decimal('participation_percentage', 5, 2)->default(0); // Porcentaje de participación (0.00 a 100.00)
            $table->string('partnership_type')->default('socio'); // Tipo de participación: socio, accionista, etc.
            $table->date('start_date')->nullable(); // Fecha de inicio de la participación
            $table->date('end_date')->nullable(); // Fecha de fin de la participación (si aplica)
            $table->boolean('is_active')->default(true); // Si la participación está activa
            $table->text('notes')->nullable(); // Notas adicionales
            $table->timestamps();
            $table->softDeletes();

            // Índices y constraints
            $table->index(['entity_dni', 'partner_dni']);
            $table->index(['partner_dni', 'entity_dni']);
            $table->index('participation_percentage');
            $table->index('is_active');

            // Foreign keys
            $table->foreign('entity_dni')->references('dni')->on('entities')->onDelete('cascade');
            $table->foreign('partner_dni')->references('dni')->on('entities')->onDelete('cascade');

            // Constraint único para evitar duplicados
            $table->unique(['entity_dni', 'partner_dni', 'start_date'], 'unique_partnership');

            // Nota: La validación de porcentajes se manejará a nivel de aplicación
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entity_partnerships');
    }
};
