<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información Personal')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nombre')
                                    ->required()
                                    ->maxLength(255)
                                    ->disabled(fn (string $context): bool => $context === 'view'),
                                TextInput::make('email')
                                    ->label('Correo Electrónico')
                                    ->email()
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true)
                                    ->disabled(fn (string $context): bool => $context === 'view'),
                            ]),
                    ]),

                Section::make('Información del Sistema')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('created_at')
                                    ->label('Fecha de Creación')
                                    ->disabled()
                                    ->visible(fn (string $context): bool => $context === 'view'),
                                TextInput::make('updated_at')
                                    ->label('Última Actualización')
                                    ->disabled()
                                    ->visible(fn (string $context): bool => $context === 'view'),
                            ]),
                    ]),

                Section::make('Estado de la Cuenta')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('email_verified_at')
                                    ->label('Verificación de Email')
                                    ->disabled()
                                    ->visible(fn (string $context): bool => $context === 'view'),
                                TextInput::make('id')
                                    ->label('ID del Usuario')
                                    ->disabled()
                                    ->visible(fn (string $context): bool => $context === 'view'),
                            ]),
                    ]),

                Section::make('Seguridad')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('password')
                                    ->label('Contraseña')
                                    ->password()
                                    ->required(fn (string $context): bool => $context === 'create')
                                    ->minLength(8)
                                    ->confirmed()
                                    ->visible(fn (string $context): bool => $context !== 'view'),
                                TextInput::make('password_confirmation')
                                    ->label('Confirmar Contraseña')
                                    ->password()
                                    ->required(fn (string $context): bool => $context === 'create')
                                    ->visible(fn (string $context): bool => $context !== 'view'),
                            ]),
                    ]),
            ]);
    }
}
