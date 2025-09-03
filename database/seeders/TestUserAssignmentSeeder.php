<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Entity;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TestUserAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear algunos usuarios adicionales si no existen
        $users = User::all();

        if ($users->count() < 5) {
            $additionalUsers = [
                ['name' => 'María González', 'email' => 'maria@cyc.cl'],
                ['name' => 'Juan Pérez', 'email' => 'juan@cyc.cl'],
                ['name' => 'Ana Silva', 'email' => 'ana@cyc.cl'],
            ];

            foreach ($additionalUsers as $userData) {
                if (!User::where('email', $userData['email'])->exists()) {
                    User::create([
                        'name' => $userData['name'],
                        'email' => $userData['email'],
                        'password' => bcrypt('password'),
                    ]);
                }
            }

            $users = User::all();
        }

        if ($users->isEmpty()) {
            $this->command->info('No hay usuarios disponibles para asignar.');
            return;
        }

        // Marcar más contribuyentes como clientes
        $entities = Entity::take(10)->get();

        foreach ($entities as $index => $entity) {
            $entity->update(['is_client' => true]);

            // Asignar un usuario a cada cliente usando el método directo
            $user = $users[$index % $users->count()];

            // Verificar si ya existe la relación
            $exists = DB::table('user_entities')
                ->where('user_id', $user->id)
                ->where('entity_dni', $entity->dni)
                ->exists();

            if (!$exists) {
                // Insertar directamente en la tabla pivot
                DB::table('user_entities')->insert([
                    'id' => Str::uuid(),
                    'user_id' => $user->id,
                    'entity_dni' => $entity->dni,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $this->command->info("Cliente '{$entity->display_name}' asignado al usuario '{$user->name}'");
            } else {
                $this->command->info("Cliente '{$entity->display_name}' ya está asignado al usuario '{$user->name}'");
            }
        }

        $this->command->info('Se han asignado usuarios a clientes exitosamente.');
        $this->command->info("Total de clientes: " . Entity::where('is_client', true)->count());
        $this->command->info("Total de usuarios: " . $users->count());
    }
}
