<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class EntityPartnership extends Model
{
    use SoftDeletes, HasUuids;

    protected $fillable = [
        'entity_dni',
        'partner_dni',
        'participation_percentage',
        'partnership_type',
        'start_date',
        'end_date',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'participation_percentage' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Constantes para tipos de participación
    public const TYPE_SOCIO = 'socio';
    public const TYPE_ACCIONISTA = 'accionista';
    public const TYPE_PARTICIPE = 'participe';
    public const TYPE_OTRO = 'otro';

    public static function getPartnershipTypes(): array
    {
        return [
            self::TYPE_SOCIO => 'Socio',
            self::TYPE_ACCIONISTA => 'Accionista',
            self::TYPE_PARTICIPE => 'Participe',
            self::TYPE_OTRO => 'Otro',
        ];
    }

    // Relaciones
    public function entity(): BelongsTo
    {
        return $this->belongsTo(Entity::class, 'entity_dni', 'dni');
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Entity::class, 'partner_dni', 'dni');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForEntity($query, string $entityDni)
    {
        return $query->where('entity_dni', $entityDni);
    }

    public function scopeForPartner($query, string $partnerDni)
    {
        return $query->where('partner_dni', $partnerDni);
    }

    // Accessors
    public function getFormattedPercentageAttribute(): string
    {
        return number_format($this->participation_percentage, 2) . '%';
    }

    public function getPartnershipTypeLabelAttribute(): string
    {
        return self::getPartnershipTypes()[$this->partnership_type] ?? $this->partnership_type;
    }

    // Validaciones
    public static function validateParticipationPercentage(string $entityDni, float $percentage, ?int $excludeId = null): bool
    {
        $query = self::where('entity_dni', $entityDni)
            ->where('is_active', true);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        $currentTotal = $query->sum('participation_percentage');

        return ($currentTotal + $percentage) <= 100.00;
    }
}
