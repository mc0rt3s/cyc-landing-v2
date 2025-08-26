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
        Schema::create('partners', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Empresa que tiene socios
            $table->string('company_dni');

            // Socio (persona o empresa)
            $table->string('partner_dni');

            // Información de la participación
            $table->decimal('ownership', 5, 2)->nullable(); // Porcentaje de participación

            // Información adicional
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Clave única para evitar duplicados
            $table->unique(['company_dni', 'partner_dni']);

            // Índices para optimizar consultas
            $table->index('company_dni');
            $table->index('partner_dni');
            $table->index('ownership');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
