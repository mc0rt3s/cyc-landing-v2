<?php

namespace Database\Seeders;

use App\Models\Entity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateRutFormatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Actualizando formato de RUTs para demostración...');

        // Crear algunas entidades de prueba con RUTs menores a 10.000.000
        $testEntities = [
            [
                'dni' => '85767202',
                'type' => 'person',
                'first_name' => 'Juan Carlos',
                'last_name' => 'Pérez González',
                'email' => 'juan.perez@email.com',
                'status' => 'active',
            ],
            [
                'dni' => '12345678',
                'type' => 'person',
                'first_name' => 'María Elena',
                'last_name' => 'Rodríguez Silva',
                'email' => 'maria.rodriguez@email.com',
                'status' => 'active',
            ],
            [
                'dni' => '98765432',
                'type' => 'company',
                'business_name' => 'Empresa Demo Limitada',
                'commercial_name' => 'Demo Ltda',
                'email' => 'info@demo.cl',
                'status' => 'active',
            ],
        ];

        foreach ($testEntities as $entityData) {
            // Verificar si ya existe
            $existing = Entity::where('dni', $entityData['dni'])->first();

            if (!$existing) {
                Entity::create($entityData);
                $this->command->info("Entidad creada: {$entityData['dni']} - " . ($entityData['first_name'] ?? $entityData['business_name']));
            } else {
                $this->command->info("Entidad ya existe: {$entityData['dni']}");
            }
        }

        $this->command->info('Formato de RUTs actualizado exitosamente!');
        $this->command->info('Los RUTs menores a 10.000.000 ahora se mostrarán con 0 al inicio.');
    }
}
