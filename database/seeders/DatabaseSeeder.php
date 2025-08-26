<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuario administrador
        $this->call([
            AdminUserSeeder::class,
            CcStaffSeeder::class,
        ]);

        // Crear usuarios de prueba (solo en desarrollo)
        if (app()->environment('local')) {
            User::factory(5)->create();
        }
    }
}
