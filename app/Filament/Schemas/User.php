<?php

namespace App\Filament\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\TextInput;
use Filament\Schemas\Components\Grid;

class User
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información Personal')
                    ->icon('heroicon-o-user')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nombre')
                                    ->disabled()
                                    ->size('lg'),
                                TextInput::make('email')
                                    ->label('Correo Electrónico')
                                    ->disabled()
                                    ->icon('heroicon-o-envelope'),
                            ]),
                    ])
                    ->collapsible()
                    ->collapsed(false),

                Section::make('Información del Sistema')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('created_at')
                                    ->label('Fecha de Creación')
                                    ->disabled()
                                    ->icon('heroicon-o-calendar'),
                                TextInput::make('updated_at')
                                    ->label('Última Actualización')
                                    ->disabled()
                                    ->icon('heroicon-o-clock'),
                            ]),
                    ])
                    ->collapsible()
                    ->collapsed(true),

                Section::make('Estado de la Cuenta')
                    ->icon('heroicon-o-shield-check')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('email_verified_at')
                                    ->label('Verificación de Email')
                                    ->disabled()
                                    ->icon('heroicon-o-check-circle'),
                                TextInput::make('id')
                                    ->label('ID del Usuario')
                                    ->disabled()
                                    ->icon('heroicon-o-identification'),
                            ]),
                    ])
                    ->collapsible()
                    ->collapsed(true),
            ]);
    }
}
