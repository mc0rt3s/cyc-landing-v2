<?php

namespace Database\Seeders;

use App\Models\Entity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class EntitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedFromCsv();
    }

        /**
     * Lee entidades desde los archivos CSV.
     */
    private function seedFromCsv(): void
    {
        $this->seedPersonas();
        $this->seedEmpresas();
    }

    /**
     * Lee personas desde el archivo CSV.
     */
    private function seedPersonas(): void
    {
        $csvPath = base_path('personas_limpio.csv');

        if (!file_exists($csvPath)) {
            Log::warning("Archivo CSV de personas no encontrado en: {$csvPath}");
            return;
        }

        $csvContent = file_get_contents($csvPath);
        $lines = explode("\n", $csvContent);

        // Asumimos que la primera línea contiene los headers
        $headers = str_getcsv(array_shift($lines));

        $imported = 0;
        $errors = 0;

        foreach ($lines as $lineNumber => $line) {
            if (empty(trim($line))) {
                continue;
            }

            try {
                $data = str_getcsv($line);
                $entityData = array_combine($headers, $data);

                // Mapear los datos del CSV a los campos del modelo
                $mappedData = $this->mapPersonaData($entityData);

                // Crear o actualizar la entidad
                Entity::updateOrCreate(
                    ['dni' => $mappedData['dni']], // Buscar por DNI
                    $mappedData
                );

                $imported++;

            } catch (\Exception $e) {
                Log::error("Error procesando línea " . ($lineNumber + 2) . " del archivo de personas: " . $e->getMessage());
                $errors++;
            }
        }

        Log::info("Importación de personas completada: {$imported} entidades importadas, {$errors} errores");
    }

    /**
     * Lee empresas desde el archivo CSV.
     */
    private function seedEmpresas(): void
    {
        $csvPath = base_path('empresas_limpio.csv');

        if (!file_exists($csvPath)) {
            Log::warning("Archivo CSV de empresas no encontrado en: {$csvPath}");
            return;
        }

        $csvContent = file_get_contents($csvPath);
        $lines = explode("\n", $csvContent);

        // Asumimos que la primera línea contiene los headers
        $headers = str_getcsv(array_shift($lines));

        $imported = 0;
        $errors = 0;

        foreach ($lines as $lineNumber => $line) {
            if (empty(trim($line))) {
                continue;
            }

            try {
                $data = str_getcsv($line);
                $entityData = array_combine($headers, $data);

                // Mapear los datos del CSV a los campos del modelo
                $mappedData = $this->mapEmpresaData($entityData);

                // Crear o actualizar la entidad
                Entity::updateOrCreate(
                    ['dni' => $mappedData['dni']], // Buscar por DNI
                    $mappedData
                );

                $imported++;

            } catch (\Exception $e) {
                Log::error("Error procesando línea " . ($lineNumber + 2) . " del archivo de empresas: " . $e->getMessage());
                $errors++;
            }
        }

        Log::info("Importación de empresas completada: {$imported} entidades importadas, {$errors} errores");
    }

    /**
     * Mapea los datos de una persona desde el CSV.
     */
    private function mapPersonaData(array $csvData): array
    {
        // Extraer nombre y apellido del campo Nombre
        $nombreCompleto = $csvData['Nombre'] ?? '';
        $nombres = $this->extractNames($nombreCompleto);

        return [
            'dni' => $csvData['RUT'] ?? null,
            'type' => Entity::TYPE_PERSON,
            'first_name' => $nombres['first_name'] ?? null,
            'last_name' => $nombres['last_name'] ?? null,
            'business_name' => null,
            'commercial_name' => null,
            'company_type' => null,
            'email' => null, // No hay email en el CSV
            'phone' => null, // No hay teléfono en el CSV
            'address' => null, // No hay dirección en el CSV
            'city' => null, // No hay ciudad en el CSV
            'region' => null, // No hay región en el CSV
            'tax_regime' => Entity::TAX_REGIME_18D3, // Por defecto
            'activity_start_date' => null, // No hay fecha en el CSV
            'is_client' => false, // Por defecto, marcar como no clientes para probar la funcionalidad
            'status' => Entity::STATUS_ACTIVE, // Por defecto activo
            'notes' => null, // No hay notas en el CSV
        ];
    }

    /**
     * Mapea los datos de una empresa desde el CSV.
     */
    private function mapEmpresaData(array $csvData): array
    {
        return [
            'dni' => $csvData['RUT'] ?? null,
            'type' => Entity::TYPE_COMPANY,
            'first_name' => null,
            'last_name' => null,
            'business_name' => $csvData['Nombre'] ?? null, // Usar el campo Nombre como razón social
            'commercial_name' => null, // No hay nombre comercial en el CSV
            'company_type' => $this->determineCompanyTypeFromName($csvData['Nombre'] ?? ''),
            'email' => null, // No hay email en el CSV
            'phone' => null, // No hay teléfono en el CSV
            'address' => null, // No hay dirección en el CSV
            'city' => null, // No hay ciudad en el CSV
            'region' => null, // No hay región en el CSV
            'tax_regime' => Entity::TAX_REGIME_18D3, // Por defecto
            'activity_start_date' => null, // No hay fecha en el CSV
            'is_client' => false, // Por defecto, marcar como no clientes para probar la funcionalidad
            'status' => Entity::STATUS_ACTIVE, // Por defecto activo
            'notes' => null, // No hay notas en el CSV
        ];
    }

        /**
     * Determina el tipo de entidad basado en los datos del CSV.
     * Ya no se usa, pero se mantiene por compatibilidad.
     */
    private function determineType(array $csvData): string
    {
        // Este método ya no se usa, pero se mantiene por compatibilidad
        return Entity::TYPE_COMPANY;
    }

        /**
     * Mapea el tipo de empresa desde el CSV.
     */
    private function mapCompanyType(array $csvData): ?string
    {
        $companyType = $csvData['TipoEmpresa'] ?? $csvData['tipo_empresa'] ?? $csvData['company_type'] ?? $csvData['Tipo'] ?? $csvData['tipo'] ?? null;

        if (!$companyType) return null;

        $companyTypeLower = strtolower(trim($companyType));

        return match($companyTypeLower) {
            'individual', 'empresa individual', 'e.i.', 'ei', 'individual' => Entity::COMPANY_TYPE_INDIVIDUAL,
            'partnership', 'sociedad de personas', 'sociedad personas', 's.p.', 'sp', 'sociedad', 'personas' => Entity::COMPANY_TYPE_PARTNERSHIP,
            'corporation', 'sociedad anonima', 's.a.', 'sa', 'anonima', 'corporación', 'corporacion' => Entity::COMPANY_TYPE_CORPORATION,
            'ltda', 'limitada', 'sociedad limitada', 's.l.', 'sl' => Entity::COMPANY_TYPE_PARTNERSHIP,
            default => Entity::COMPANY_TYPE_OTHER
        };
    }

        /**
     * Mapea el régimen tributario desde el CSV.
     */
    private function mapTaxRegime(array $csvData): ?string
    {
        $taxRegime = $csvData['RegimenTributario'] ?? $csvData['regimen_tributario'] ?? $csvData['Regimen'] ?? $csvData['regimen'] ?? $csvData['tax_regime'] ?? null;

        if (!$taxRegime) return null;

        $taxRegimeLower = strtolower(trim($taxRegime));

        return match($taxRegimeLower) {
            '18d3', '18d', 'general', 'regimen general', 'régimen general' => Entity::TAX_REGIME_18D3,
            'd8', 'simplificado', 'regimen simplificado', 'régimen simplificado' => Entity::TAX_REGIME_D8,
            'a', 'agricola', 'regimen agricola', 'régimen agrícola', 'agrícola' => Entity::TAX_REGIME_A,
            'otro', 'other', 'especial' => Entity::TAX_REGIME_OTHER,
            default => Entity::TAX_REGIME_OTHER
        };
    }

        /**
     * Mapea el estado desde el CSV.
     */
    private function mapStatus(array $csvData): string
    {
        $status = $csvData['Estado'] ?? $csvData['estado'] ?? $csvData['Status'] ?? $csvData['status'] ?? 'active';

        if (!$status) return Entity::STATUS_ACTIVE;

        $statusLower = strtolower(trim($status));

        return match($statusLower) {
            'activo', 'active', 'activa', 'habilitado', 'habilitada', 'vigente' => Entity::STATUS_ACTIVE,
            'inactivo', 'inactive', 'inactiva', 'deshabilitado', 'deshabilitada', 'suspendido' => Entity::STATUS_INACTIVE,
            'bloqueado', 'blocked', 'bloqueada', 'cancelado', 'cancelada' => Entity::STATUS_BLOCKED,
            default => Entity::STATUS_ACTIVE
        };
    }

        /**
     * Parsea una fecha desde el CSV.
     */
    private function parseDate(array $csvData): ?string
    {
        $dateField = $csvData['FechaInicio'] ?? $csvData['fecha_inicio'] ?? $csvData['FechaInicioActividad'] ?? $csvData['fecha_inicio_actividad'] ?? $csvData['activity_start_date'] ?? null;

        if (!$dateField) return null;

        try {
            // Intentar diferentes formatos de fecha comunes en Chile
            $date = \Carbon\Carbon::createFromFormat('d/m/Y', $dateField);
            return $date->format('Y-m-d');
        } catch (\Exception $e) {
            try {
                // Intentar formato ISO
                $date = \Carbon\Carbon::parse($dateField);
                return $date->format('Y-m-d');
            } catch (\Exception $e2) {
                // Si no se puede parsear, retornar null
                return null;
            }
        }
    }

        /**
     * Parsea un valor booleano desde el CSV.
     */
    private function parseBoolean(array $csvData): bool
    {
        $clientField = $csvData['EsCliente'] ?? $csvData['es_cliente'] ?? $csvData['Cliente'] ?? $csvData['cliente'] ?? $csvData['is_client'] ?? 'true';

        if (!$clientField) return true; // Por defecto, asumir que es cliente

        $clientFieldLower = strtolower(trim($clientField));

        return in_array($clientFieldLower, [
            'true', '1', 'si', 'sí', 'yes', 'cliente', 'activo', 'activa', 'vigente',
            'verdadero', 'verdadera', 'correcto', 'correcta'
        ]);
    }

    /**
     * Extrae nombre y apellido de un nombre completo.
     */
    private function extractNames(string $nombreCompleto): array
    {
        $nombreCompleto = trim($nombreCompleto);
        $partes = explode(' ', $nombreCompleto);

        if (count($partes) >= 2) {
            // Tomar el primer elemento como nombre
            $firstName = array_shift($partes);
            // Tomar el resto como apellido
            $lastName = implode(' ', $partes);
        } else {
            $firstName = $nombreCompleto;
            $lastName = '';
        }

        return [
            'first_name' => $firstName,
            'last_name' => $lastName
        ];
    }

    /**
     * Determina el tipo de empresa basado en el nombre.
     */
    private function determineCompanyTypeFromName(string $nombre): string
    {
        $nombreLower = strtolower($nombre);

        if (str_contains($nombreLower, 's.a.') || str_contains($nombreLower, 'sa') || str_contains($nombreLower, 'sociedad anonima')) {
            return Entity::COMPANY_TYPE_CORPORATION;
        }

        if (str_contains($nombreLower, 'limitada') || str_contains($nombreLower, 'ltda') || str_contains($nombreLower, 's.l.')) {
            return Entity::COMPANY_TYPE_PARTNERSHIP;
        }

        if (str_contains($nombreLower, 'e.i.') || str_contains($nombreLower, 'empresa individual')) {
            return Entity::COMPANY_TYPE_INDIVIDUAL;
        }

        // Por defecto, asumir sociedad de personas
        return Entity::COMPANY_TYPE_PARTNERSHIP;
    }
}
