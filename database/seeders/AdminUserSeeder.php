<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'soporte@cycisla.cl'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('Password.2025'), // ¡Cambia la contraseña por seguridad!
                'email_verified_at' => now(),
            ]
        );
    }
}
