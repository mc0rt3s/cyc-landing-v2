<?php

namespace App\Filament\Resources\Entities\Schemas;

use App\Models\Entity;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class EntityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Radio::make('type')
                    ->label('Tipo de Contribuyente')
                    ->options([
                        Entity::TYPE_PERSON => 'Persona Natural',
                        Entity::TYPE_COMPANY => 'Empresa',
                    ])
                    ->default(Entity::TYPE_PERSON)
                    ->required()
                    ->inline(),

                TextInput::make('dni')
                    ->label('RUT')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(12)
                    ->helperText('Formato: 12345678-9 o 12.345.678-9 (RUTs menores a 10.000.000 tendrán 0 al inicio)')
                    ->placeholder('Ej: 12345678-9')
                    ->afterStateHydrated(function ($state, $set) {
                        if ($state) {
                            // Formatear el RUT cuando se carga el formulario
                            $clean = preg_replace('/[^0-9kK]/', '', $state);
                            if (strlen($clean) >= 7) {
                                $number = substr($clean, 0, -1);
                                $dv = substr($clean, -1);

                                // Agregar 0 al inicio si el número es menor a 10.000.000
                                if ((int)$number < 10000000) {
                                    $number = '0' . $number;
                                }

                                // Formatear número con puntos, manteniendo el 0 al inicio si existe
                                if (strlen($number) == 8 && $number[0] == '0') {
                                    $formatted = '0' . number_format((int)substr($number, 1), 0, '', '.') . '-' . $dv;
                                } else {
                                    $formatted = number_format((int)$number, 0, '', '.') . '-' . $dv;
                                }

                                $set('dni', $formatted);
                            }
                        }
                    })
                    ->afterStateUpdated(function ($state, $set) {
                        if ($state) {
                            // Formatear automáticamente mientras se escribe
                            $clean = preg_replace('/[^0-9kK]/', '', $state);
                            if (strlen($clean) >= 7) {
                                $number = substr($clean, 0, -1);
                                $dv = substr($clean, -1);

                                // Agregar 0 al inicio si el número es menor a 10.000.000
                                if ((int)$number < 10000000) {
                                    $number = '0' . $number;
                                }

                                // Formatear número con puntos, manteniendo el 0 al inicio si existe
                                if (strlen($number) == 8 && $number[0] == '0') {
                                    $formatted = '0' . number_format((int)substr($number, 1), 0, '', '.') . '-' . $dv;
                                } else {
                                    $formatted = number_format((int)$number, 0, '', '.') . '-' . $dv;
                                }

                                $set('dni', $formatted);
                            }
                        }
                    }),

                TextInput::make('first_name')
                    ->label('Nombre')
                    ->maxLength(100),

                TextInput::make('last_name')
                    ->label('Apellido')
                    ->maxLength(100),

                TextInput::make('business_name')
                    ->label('Razón Social')
                    ->maxLength(200),

                TextInput::make('commercial_name')
                    ->label('Nombre Comercial')
                    ->maxLength(200),

                Select::make('company_type')
                    ->label('Tipo de Empresa')
                    ->options([
                        Entity::COMPANY_TYPE_INDIVIDUAL => 'Empresa Individual',
                        Entity::COMPANY_TYPE_PARTNERSHIP => 'Sociedad de Personas',
                        Entity::COMPANY_TYPE_CORPORATION => 'Sociedad Anónima',
                        Entity::COMPANY_TYPE_OTHER => 'Otro',
                    ])
                    ->default(Entity::COMPANY_TYPE_PARTNERSHIP),

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->maxLength(255),

                TextInput::make('phone')
                    ->label('Teléfono')
                    ->tel()
                    ->maxLength(20),

                TextInput::make('address')
                    ->label('Dirección')
                    ->maxLength(500),

                TextInput::make('city')
                    ->label('Ciudad')
                    ->maxLength(100),

                TextInput::make('region')
                    ->label('Región')
                    ->maxLength(100),

                Select::make('tax_regime')
                    ->label('Régimen Tributario')
                    ->options([
                        Entity::TAX_REGIME_18D3 => '18D3 - Contribuyentes del Régimen General',
                        Entity::TAX_REGIME_D8 => 'D8 - Contribuyentes del Régimen Simplificado',
                        Entity::TAX_REGIME_A => 'A - Contribuyentes del Régimen Agrícola',
                        Entity::TAX_REGIME_OTHER => 'Otro Régimen',
                    ])
                    ->default(Entity::TAX_REGIME_18D3),

                DatePicker::make('activity_start_date')
                    ->label('Fecha de Inicio de Actividad')
                    ->displayFormat('d/m/Y')
                    ->format('Y-m-d'),

                Toggle::make('is_client')
                    ->label('Es Cliente')
                    ->default(false)
                    ->helperText('Marcar si esta entidad es un cliente activo'),

                Select::make('status')
                    ->label('Estado')
                    ->required()
                    ->options([
                        Entity::STATUS_ACTIVE => 'Activo',
                        Entity::STATUS_INACTIVE => 'Inactivo',
                        Entity::STATUS_BLOCKED => 'Bloqueado',
                    ])
                    ->default(Entity::STATUS_ACTIVE),

                Textarea::make('notes')
                    ->label('Notas')
                    ->rows(3)
                    ->maxLength(1000)
                    ->helperText('Información adicional sobre el contribuyente')
                    ->columnSpanFull(),
            ]);
    }
}
