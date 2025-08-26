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
        Schema::create('entities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Identificación única
            $table->string('dni')->unique(); // RUT único para personas y empresas
            
            // Tipo de entidad
            $table->enum('type', ['person', 'company']);
            
            // Campos para personas
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            
            // Campos para empresas
            $table->string('business_name')->nullable();
            $table->string('commercial_name')->nullable();
            $table->enum('company_type', ['individual', 'partnership', 'corporation', 'other'])->nullable();
            
            // Campos comunes
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('region')->nullable();
            $table->enum('tax_regime', ['18D3', 'D8', 'A', 'other'])->nullable();
            $table->date('activity_start_date')->nullable();
            
            // Estado y configuración
            $table->boolean('is_client')->default(false);
            $table->enum('status', ['active', 'inactive', 'blocked'])->default('active');
            $table->text('notes')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Índices para optimizar consultas
            $table->index('dni');
            $table->index('type');
            $table->index('is_client');
            $table->index('status');
            $table->index(['type', 'is_client']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entities');
    }
};
