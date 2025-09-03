<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserEntity extends Pivot
{
    use HasUuids;

    /**
     * La tabla asociada al modelo.
     */
    protected $table = 'user_entities';

    /**
     * Los atributos que son asignables masivamente.
     */
    protected $fillable = [
        'user_id',
        'entity_dni',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Indica si el modelo debe ser timestamped.
     */
    public $timestamps = true;

    /**
     * Indica si los IDs son auto-incrementales.
     */
    public $incrementing = false;

    /**
     * El tipo de clave primaria.
     */
    protected $keyType = 'string';

    /**
     * Boot del modelo.
     */
    protected static function boot()
    {
        parent::boot();

        // Asegurar que se genere un UUID antes de guardar
        static::creating(function ($pivot) {
            if (empty($pivot->id)) {
                $pivot->id = \Illuminate\Support\Str::uuid();
            }
        });
    }
}

