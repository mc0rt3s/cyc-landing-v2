<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Entity extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    /**
     * Los atributos que son asignables masivamente.
     */
    protected $fillable = [
        'dni',
        'type',
        'first_name',
        'last_name',
        'business_name',
        'commercial_name',
        'company_type',
        'email',
        'phone',
        'address',
        'city',
        'region',
        'tax_regime',
        'activity_start_date',
        'is_client',
        'status',
        'notes',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     */
    protected $casts = [
        'activity_start_date' => 'date',
        'is_client' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Los atributos que deben ser agregados al array del modelo.
     */
    protected $appends = [
        'full_name',
        'display_name',
        'type_label',
        'company_type_label',
        'tax_regime_label',
        'status_label',
        'is_active',
        'formatted_dni',
    ];

    /**
     * Los atributos que deben ser ocultos para arrays.
     */
    protected $hidden = [
        'deleted_at',
    ];

    /**
     * Constantes para tipos de entidad
     */
    const TYPE_PERSON = 'person';
    const TYPE_COMPANY = 'company';

    /**
     * Constantes para tipos de empresa
     */
    const COMPANY_TYPE_INDIVIDUAL = 'individual';
    const COMPANY_TYPE_PARTNERSHIP = 'partnership';
    const COMPANY_TYPE_CORPORATION = 'corporation';
    const COMPANY_TYPE_OTHER = 'other';

    /**
     * Constantes para regímenes tributarios
     */
    const TAX_REGIME_18D3 = '18D3';
    const TAX_REGIME_D8 = 'D8';
    const TAX_REGIME_A = 'A';
    const TAX_REGIME_OTHER = 'other';

    /**
     * Constantes para estados
     */
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_BLOCKED = 'blocked';

    /**
     * Obtiene el nombre completo de la entidad.
     */
    public function getFullNameAttribute(): string
    {
        if ($this->type === self::TYPE_PERSON) {
            return trim($this->first_name . ' ' . $this->last_name);
        }

        return $this->business_name ?? $this->commercial_name ?? 'Sin nombre';
    }

    /**
     * Obtiene el nombre de visualización de la entidad.
     */
    public function getDisplayNameAttribute(): string
    {
        if ($this->type === self::TYPE_PERSON) {
            return $this->full_name;
        }

        return $this->commercial_name ?? $this->business_name ?? 'Sin nombre comercial';
    }

    /**
     * Obtiene la etiqueta del tipo de entidad.
     */
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            self::TYPE_PERSON => 'Persona Natural',
            self::TYPE_COMPANY => 'Empresa',
            default => 'Desconocido'
        };
    }

    /**
     * Obtiene la etiqueta del tipo de empresa.
     */
    public function getCompanyTypeLabelAttribute(): ?string
    {
        if ($this->type !== self::TYPE_COMPANY) {
            return null;
        }

        return match($this->company_type) {
            self::COMPANY_TYPE_INDIVIDUAL => 'Empresa Individual',
            self::COMPANY_TYPE_PARTNERSHIP => 'Sociedad de Personas',
            self::COMPANY_TYPE_CORPORATION => 'Sociedad Anónima',
            self::COMPANY_TYPE_OTHER => 'Otro',
            default => null
        };
    }

    /**
     * Obtiene la etiqueta del régimen tributario.
     */
    public function getTaxRegimeLabelAttribute(): ?string
    {
        return match($this->tax_regime) {
            self::TAX_REGIME_18D3 => '18D3 - Contribuyentes del Régimen General',
            self::TAX_REGIME_D8 => 'D8 - Contribuyentes del Régimen Simplificado',
            self::TAX_REGIME_A => 'A - Contribuyentes del Régimen Agrícola',
            self::TAX_REGIME_OTHER => 'Otro Régimen',
            default => null
        };
    }

    /**
     * Obtiene la etiqueta del estado.
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            self::STATUS_ACTIVE => 'Activo',
            self::STATUS_INACTIVE => 'Inactivo',
            self::STATUS_BLOCKED => 'Bloqueado',
            default => 'Desconocido'
        };
    }

    /**
     * Verifica si la entidad está activa.
     */
    public function getIsActiveAttribute(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * Verifica si la entidad es una persona.
     */
    public function isPerson(): bool
    {
        return $this->type === self::TYPE_PERSON;
    }

    /**
     * Verifica si la entidad es una empresa.
     */
    public function isCompany(): bool
    {
        return $this->type === self::TYPE_COMPANY;
    }

    /**
     * Verifica si la entidad es un cliente.
     */
    public function isClient(): bool
    {
        return $this->is_client;
    }

    /**
     * Marca la entidad como cliente.
     */
    public function markAsClient(): void
    {
        $this->update(['is_client' => true]);
    }

    /**
     * Marca la entidad como no cliente.
     */
    public function markAsNonClient(): void
    {
        $this->update(['is_client' => false]);
    }

    /**
     * Activa la entidad.
     */
    public function activate(): void
    {
        $this->update(['status' => self::STATUS_ACTIVE]);
    }

    /**
     * Desactiva la entidad.
     */
    public function deactivate(): void
    {
        $this->update(['status' => self::STATUS_INACTIVE]);
    }

    /**
     * Bloquea la entidad.
     */
    public function block(): void
    {
        $this->update(['status' => self::STATUS_BLOCKED]);
    }

    /**
     * Obtiene la edad de la empresa en años.
     */
    public function getCompanyAgeAttribute(): ?int
    {
        if (!$this->activity_start_date) {
            return null;
        }

        return Carbon::parse($this->activity_start_date)->age;
    }

    /**
     * Relación con los servicios contratados por la entidad.
     */
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'entity_services', 'entity_dni', 'service_id', 'dni', 'id')
            ->withPivot(['price', 'status', 'start_date', 'end_date', 'notes', 'custom_fields'])
            ->withTimestamps();
    }

    /**
     * Relación con los usuarios asignados a la entidad.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_entities', 'entity_dni', 'user_id', 'dni', 'id')
            ->using(UserEntity::class)
            ->withTimestamps();
    }

    /**
     * Relación con las entidades donde esta entidad es socio.
     */
    public function partnerships(): HasMany
    {
        return $this->hasMany(EntityPartnership::class, 'partner_dni', 'dni');
    }

    /**
     * Relación con los socios de esta entidad (si es empresa).
     */
    public function partners(): HasMany
    {
        return $this->hasMany(EntityPartnership::class, 'entity_dni', 'dni');
    }

    /**
     * Relación con los socios activos de esta entidad (si es empresa).
     */
    public function activePartners(): HasMany
    {
        return $this->partners()->where('is_active', true);
    }

    /**
     * Obtiene el porcentaje total de participación de los socios.
     */
    public function getTotalParticipationPercentageAttribute(): float
    {
        return $this->activePartners()->sum('participation_percentage');
    }

    /**
     * Verifica si la empresa tiene socios.
     */
    public function hasPartners(): bool
    {
        return $this->activePartners()->exists();
    }

    /**
     * Relación con las circulares (si es cliente).
     */
    public function circulars(): HasMany
    {
        return $this->hasMany(Circular::class, 'entity_dni', 'dni');
    }

    /**
     * Scope para filtrar por tipo de entidad.
     */
    public function scopeOfType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }

    /**
     * Scope para filtrar solo personas.
     */
    public function scopePersons(Builder $query): Builder
    {
        return $query->ofType(self::TYPE_PERSON);
    }

    /**
     * Scope para filtrar solo empresas.
     */
    public function scopeCompanies(Builder $query): Builder
    {
        return $query->ofType(self::TYPE_COMPANY);
    }

    /**
     * Scope para filtrar solo clientes.
     */
    public function scopeClients(Builder $query): Builder
    {
        return $query->where('is_client', true);
    }

    /**
     * Scope para filtrar solo entidades activas.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope para filtrar por región.
     */
    public function scopeInRegion(Builder $query, string $region): Builder
    {
        return $query->where('region', $region);
    }

    /**
     * Scope para filtrar por régimen tributario.
     */
    public function scopeWithTaxRegime(Builder $query, string $taxRegime): Builder
    {
        return $query->where('tax_regime', $taxRegime);
    }

    /**
     * Scope para buscar por nombre, DNI, email y otros campos.
     * Maneja búsqueda con y sin formato de RUT.
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        if (empty($search)) {
            return $query;
        }

        return $query->where(function ($q) use ($search) {
            // Limpiar el término de búsqueda para DNI
            $cleanSearch = preg_replace('/[^0-9kK]/', '', $search);

            // Búsqueda por DNI (con y sin formato)
            if (!empty($cleanSearch)) {
                $q->where('dni', 'like', "%{$cleanSearch}%");
            }

            // Búsqueda por nombres (personas)
            $q->orWhere('first_name', 'like', "%{$search}%")
              ->orWhere('last_name', 'like', "%{$search}%")
              ->orWhere(function ($subQuery) use ($search) {
                  // Búsqueda por nombre completo (concatenado)
                  $subQuery->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"])
                           ->orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", ["%{$search}%"]);
              });

            // Búsqueda por nombres de empresa
            $q->orWhere('business_name', 'like', "%{$search}%")
              ->orWhere('commercial_name', 'like', "%{$search}%");

            // Búsqueda por email
            $q->orWhere('email', 'like', "%{$search}%");

            // Búsqueda por teléfono
            $q->orWhere('phone', 'like', "%{$search}%");

            // Búsqueda por ciudad
            $q->orWhere('city', 'like', "%{$search}%");
        });
    }

    /**
     * Boot del modelo.
     */
    protected static function boot()
    {
        parent::boot();

        // Antes de guardar, validar que los campos requeridos estén presentes según el tipo
        static::saving(function ($entity) {
            if ($entity->type === self::TYPE_PERSON) {
                if (empty($entity->first_name) || empty($entity->last_name)) {
                    throw new \InvalidArgumentException('Las personas deben tener nombre y apellido.');
                }
            }

            if ($entity->type === self::TYPE_COMPANY) {
                if (empty($entity->business_name)) {
                    throw new \InvalidArgumentException('Las empresas deben tener razón social.');
                }
            }
        });
    }

    /**
     * Obtiene el DNI formateado con puntos y guión.
     * Los RUTs menores a 10.000.000 tendrán un 0 al inicio.
     */
    public function getFormattedDniAttribute(): string
    {
        $dni = $this->dni;

        if (!$dni) {
            return '';
        }

        // Remover cualquier formato existente
        $dni = preg_replace('/[^0-9kK]/', '', $dni);

        if (strlen($dni) < 7) {
            return $dni;
        }

        // Separar número y dígito verificador
        $number = substr($dni, 0, -1);
        $dv = substr($dni, -1);

        // Agregar 0 al inicio si el número es menor a 10.000.000
        if ((int)$number < 10000000) {
            $number = '0' . $number;
        }

        // Formatear número con puntos, manteniendo el 0 al inicio si existe
        if (strlen($number) == 8 && $number[0] == '0') {
            // Para números con 0 al inicio, formatear manualmente
            $formattedNumber = '0' . number_format((int)substr($number, 1), 0, '', '.');
        } else {
            $formattedNumber = number_format((int)$number, 0, '', '.');
        }

        return $formattedNumber . '-' . $dv;
    }

    /**
     * Mutador para formatear automáticamente el DNI al guardar.
     */
    public function setDniAttribute($value): void
    {
        if ($value) {
            // Remover formato existente y guardar solo números y dígito verificador
            $cleanValue = preg_replace('/[^0-9kK]/', '', $value);
            $this->attributes['dni'] = $cleanValue;
        } else {
            $this->attributes['dni'] = $value;
        }
    }
}
