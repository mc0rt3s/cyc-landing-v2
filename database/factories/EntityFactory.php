<?php

namespace Database\Factories;

use App\Models\Entity;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entity>
 */
class EntityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement([Entity::TYPE_PERSON, Entity::TYPE_COMPANY]);
        
        $baseData = [
            'dni' => $this->generateChileanRut(),
            'type' => $type,
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->randomElement(['Santiago', 'Valparaíso', 'Concepción', 'La Serena', 'Antofagasta', 'Temuco', 'Viña del Mar', 'Rancagua']),
            'region' => $this->faker->randomElement(['Metropolitana', 'Valparaíso', 'Biobío', 'Coquimbo', 'Antofagasta', 'La Araucanía', 'O\'Higgins', 'Maule']),
            'tax_regime' => $this->faker->randomElement([Entity::TAX_REGIME_18D3, Entity::TAX_REGIME_D8, Entity::TAX_REGIME_A, Entity::TAX_REGIME_OTHER]),
            'activity_start_date' => $this->faker->dateTimeBetween('-20 years', 'now'),
            'is_client' => $this->faker->boolean(80), // 80% de probabilidad de ser cliente
            'status' => $this->faker->randomElement([Entity::STATUS_ACTIVE, Entity::STATUS_ACTIVE, Entity::STATUS_ACTIVE, Entity::STATUS_INACTIVE]), // Mayor probabilidad de estar activo
            'notes' => $this->faker->optional(0.3)->paragraph(),
        ];

        if ($type === Entity::TYPE_PERSON) {
            $baseData = array_merge($baseData, [
                'first_name' => $this->faker->firstName(),
                'last_name' => $this->faker->lastName(),
                'business_name' => null,
                'commercial_name' => null,
                'company_type' => null,
            ]);
        } else {
            $companyType = $this->faker->randomElement([
                Entity::COMPANY_TYPE_INDIVIDUAL,
                Entity::COMPANY_TYPE_PARTNERSHIP,
                Entity::COMPANY_TYPE_CORPORATION,
                Entity::COMPANY_TYPE_OTHER
            ]);
            
            $baseData = array_merge($baseData, [
                'first_name' => null,
                'last_name' => null,
                'business_name' => $this->faker->company(),
                'commercial_name' => $this->faker->optional(0.7)->companySuffix(),
                'company_type' => $companyType,
            ]);
        }

        return $baseData;
    }

    /**
     * Indica que la entidad es una persona.
     */
    public function person(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => Entity::TYPE_PERSON,
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'business_name' => null,
            'commercial_name' => null,
            'company_type' => null,
        ]);
    }

    /**
     * Indica que la entidad es una empresa.
     */
    public function company(): static
    {
        $companyType = $this->faker->randomElement([
            Entity::COMPANY_TYPE_INDIVIDUAL,
            Entity::COMPANY_TYPE_PARTNERSHIP,
            Entity::COMPANY_TYPE_CORPORATION,
            Entity::COMPANY_TYPE_OTHER
        ]);

        return $this->state(fn (array $attributes) => [
            'type' => Entity::TYPE_COMPANY,
            'first_name' => null,
            'last_name' => null,
            'business_name' => $this->faker->company(),
            'commercial_name' => $this->faker->optional(0.7)->companySuffix(),
            'company_type' => $companyType,
        ]);
    }

    /**
     * Indica que la entidad es un cliente.
     */
    public function client(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_client' => true,
        ]);
    }

    /**
     * Indica que la entidad no es un cliente.
     */
    public function nonClient(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_client' => false,
        ]);
    }

    /**
     * Indica que la entidad está activa.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => Entity::STATUS_ACTIVE,
        ]);
    }

    /**
     * Indica que la entidad está inactiva.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => Entity::STATUS_INACTIVE,
        ]);
    }

    /**
     * Indica que la entidad está bloqueada.
     */
    public function blocked(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => Entity::STATUS_BLOCKED,
        ]);
    }

    /**
     * Genera un RUT chileno válido.
     */
    private function generateChileanRut(): string
    {
        // Generar número base del RUT (7-8 dígitos)
        $number = $this->faker->numberBetween(1000000, 99999999);
        
        // Calcular dígito verificador
        $dv = $this->calculateDv($number);
        
        return $number . '-' . $dv;
    }

    /**
     * Calcula el dígito verificador de un RUT chileno.
     */
    private function calculateDv(int $number): string
    {
        $sum = 0;
        $multiplier = 2;
        
        // Convertir número a array y revertirlo
        $digits = array_reverse(str_split($number));
        
        foreach ($digits as $digit) {
            $sum += $digit * $multiplier;
            $multiplier = $multiplier == 7 ? 2 : $multiplier + 1;
        }
        
        $remainder = $sum % 11;
        $dv = 11 - $remainder;
        
        if ($dv == 11) return '0';
        if ($dv == 10) return 'K';
        
        return (string) $dv;
    }
}


