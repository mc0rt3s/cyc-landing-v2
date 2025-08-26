<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CcStaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $staff = [
            [
                'name' => 'Carlos Isla Mateluna',
                'email' => 'cim@cycisla.cl',
                'password' => 'Password.2025',
            ],
            [
                'name' => 'Sergio Vicencio',
                'email' => 'svicencio@cycisla.cl',
                'password' => 'Password.2025',
            ],
            [
                'name' => 'Rolando Belmar',
                'email' => 'rbelmar@cycisla.cl',
                'password' => 'Password.2025',
            ],
            [
                'name' => 'Camila Parra',
                'email' => 'cparra@cycisla.cl',
                'password' => 'Password.2025',
            ],
            [
                'name' => 'Cecilia Salvatierra',
                'email' => 'csalvatierra@cycisla.cl',
                'password' => 'Password.2025',
            ],
            [
                'name' => 'Valentina Aguilera',
                'email' => 'vaguilera@cycisla.cl',
                'password' => 'Password.2025',
            ],
            [
                'name' => 'Froilan Cuevas',
                'email' => 'fcuevas@cycisla.cl',
                'password' => 'Password.2025',
            ],
            [
                'name' => 'Patricia Vicencio',
                'email' => 'pvicencio@cycisla.cl',
                'password' => 'Password.2025',
            ],
            [
                'name' => 'Jaqueline Vicencio',
                'email' => 'jvicencio@cycisla.cl',
                'password' => 'Password.2025',
            ],
            [
                'name' => 'Ernesto Tellez',
                'email' => 'etellez@cycisla.cl',
                'password' => 'Password.2025',
            ],
            [
                'name' => 'Oscar Zamorano',
                'email' => 'ozamorano@cycisla.cl',
                'password' => 'Password.2025',
            ],
            [
                'name' => 'Victor Vega',
                'email' => 'vvega@cycisla.cl',
                'password' => 'Password.2025',
            ],
            [
                'name' => 'Raul Vargas',
                'email' => 'rvargas@cycisla.cl',
                'password' => 'Password.2025',
            ],
            [
                'name' => 'Enrique Pozo',
                'email' => 'epozo@cycisla.cl',
                'password' => 'Password.2025',
            ],
            [
                'name' => 'Jorge Poblete',
                'email' => 'jpoblete@cycisla.cl',
                'password' => 'Password.2025',
            ],
            [
                'name' => 'Patricia Vasquez',
                'email' => 'pvasquez@cycisla.cl',
                'password' => 'Password.2025',
            ],
            [
                'name' => 'Fabian Gonzalez',
                'email' => 'fgonzalez@cycisla.cl',
                'password' => 'Password.2025',
            ],
            [
                'name' => 'Sebastian Alegria',
                'email' => 'salegria@cycisla.cl',
                'password' => 'Password.2025',
            ],
        ];

        foreach ($staff as $userData) {
            // Verificar si el usuario ya existe
            $existingUser = User::where('email', $userData['email'])->first();

            if (!$existingUser) {
                User::create([
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'password' => Hash::make($userData['password']),
                    'email_verified_at' => now(), // Marcar como verificado
                ]);

                $this->command->info("Usuario creado: {$userData['name']} ({$userData['email']})");
            } else {
                $this->command->info("Usuario ya existe: {$userData['name']} ({$userData['email']})");
            }
        }

        $this->command->info('Seeder de plantilla C&C completado exitosamente.');
    }
}
