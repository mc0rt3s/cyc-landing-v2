<?php

namespace Database\Seeders;

use App\Models\Entity;
use App\Models\EntityPartnership;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EntityPartnershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener algunas empresas para crear partnerships
        $companies = Entity::companies()->take(5)->get();
        $persons = Entity::persons()->take(10)->get();
        $otherCompanies = Entity::companies()->skip(5)->take(3)->get();

        if ($companies->isEmpty() || $persons->isEmpty()) {
            $this->command->warn('No hay suficientes entidades para crear partnerships. Ejecuta primero EntitySeeder.');
            return;
        }

        $this->command->info('Creando partnerships de prueba...');

        foreach ($companies as $company) {
            // Crear 2-4 socios por empresa
            $numPartners = rand(2, 4);
            $selectedPartners = $persons->random($numPartners);

            $totalPercentage = 0;
            $partnerships = [];

            foreach ($selectedPartners as $index => $partner) {
                // El último socio recibe el porcentaje restante
                if ($index === $selectedPartners->count() - 1) {
                    $percentage = 100 - $totalPercentage;
                } else {
                    $percentage = rand(10, 40);
                    $totalPercentage += $percentage;
                }

                $partnerships[] = [
                    'id' => \Illuminate\Support\Str::uuid(),
                    'entity_dni' => $company->dni,
                    'partner_dni' => $partner->dni,
                    'participation_percentage' => $percentage,
                    'partnership_type' => EntityPartnership::TYPE_SOCIO,
                    'start_date' => now()->subDays(rand(30, 365)),
                    'end_date' => null,
                    'is_active' => true,
                    'notes' => 'Socio creado automáticamente para pruebas',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            EntityPartnership::insert($partnerships);
            $this->command->info("Partnerships creados para empresa: {$company->display_name}");
        }

        // Crear algunos partnerships entre empresas
        if ($otherCompanies->isNotEmpty()) {
            foreach ($otherCompanies->take(2) as $company) {
                $partnerCompany = $otherCompanies->where('dni', '!=', $company->dni)->first();

                if ($partnerCompany) {
                    EntityPartnership::create([
                        'entity_dni' => $company->dni,
                        'partner_dni' => $partnerCompany->dni,
                        'participation_percentage' => rand(20, 50),
                        'partnership_type' => EntityPartnership::TYPE_ACCIONISTA,
                        'start_date' => now()->subDays(rand(60, 200)),
                        'end_date' => null,
                        'is_active' => true,
                        'notes' => 'Participación entre empresas para pruebas',
                    ]);

                    $this->command->info("Partnership entre empresas creado: {$company->display_name} - {$partnerCompany->display_name}");
                }
            }
        }

        $this->command->info('Partnerships creados exitosamente!');
    }
}
