<?php

namespace App\Filament\Resources\Users\RelationManagers;

use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\AttachAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\BulkActionGroup;
use App\Models\Entity;
use Illuminate\Database\Eloquent\Builder;

class EntitiesRelationManager extends RelationManager
{
    protected static string $relationship = 'entities';

    protected static ?string $recordTitleAttribute = 'display_name';

    protected static ?string $title = 'Clientes Asignados';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('display_name')
            ->columns([
                Tables\Columns\TextColumn::make('formatted_dni')
                    ->label('RUT')
                    ->searchable(['dni'])
                    ->sortable(['dni']),

                Tables\Columns\TextColumn::make('display_name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('type')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'natural' => 'success',
                        'juridica' => 'info',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('city')
                    ->label('Ciudad')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('status')
                    ->label('Estado')
                    ->boolean()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Asignado el')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Tipo')
                    ->options([
                        'natural' => 'Persona Natural',
                        'juridica' => 'Persona Jurídica',
                    ]),

                Tables\Filters\TernaryFilter::make('status')
                    ->label('Estado')
                    ->placeholder('Todos los estados')
                    ->trueLabel('Activos')
                    ->falseLabel('Inactivos'),

                Tables\Filters\Filter::make('search')
                    ->label('Búsqueda general')
                    ->form([
                        Forms\Components\TextInput::make('search')
                            ->label('Buscar por RUT o nombre')
                            ->placeholder('Ej: 12345678 o Juan Pérez'),
                    ])
                    ->query(function ($query, array $data) {
                        if (!empty($data['search'])) {
                            $search = $data['search'];
                            $query->where(function ($q) use ($search) {
                                $q->where('dni', 'like', "%{$search}%")
                                  ->orWhere('first_name', 'like', "%{$search}%")
                                  ->orWhere('last_name', 'like', "%{$search}%")
                                  ->orWhere('company_name', 'like', "%{$search}%");
                            });
                        }
                    }),
            ])
            ->headerActions([
                AttachAction::make()
                    ->label('Asignar Cliente')
                    ->icon('heroicon-o-building-office')
                    ->form([
                        Forms\Components\Select::make('recordId')
                            ->label('Cliente')
                            ->options(function () {
                                return Entity::where('is_client', true)
                                    ->get()
                                    ->mapWithKeys(function ($entity) {
                                        return [$entity->dni => $entity->display_name];
                                    });
                            })
                            ->searchable()
                            ->required()
                            ->placeholder('Seleccionar cliente a asignar'),
                    ])
                    ->successNotificationTitle('Cliente asignado exitosamente'),
            ])
            ->actions([
                DetachAction::make()
                    ->label('Desasignar')
                    ->icon('heroicon-o-building-office-2')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Desasignar Cliente')
                    ->modalDescription('¿Estás seguro de que quieres desasignar a este cliente del usuario?')
                    ->modalSubmitActionLabel('Desasignar')
                    ->successNotificationTitle('Cliente desasignado exitosamente'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DetachBulkAction::make()
                        ->label('Desasignar Seleccionados')
                        ->icon('heroicon-o-building-office-2')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Desasignar Clientes')
                        ->modalDescription('¿Estás seguro de que quieres desasignar a todos los clientes seleccionados?')
                        ->modalSubmitActionLabel('Desasignar'),
                ]),
            ])
            ->emptyStateHeading('No hay clientes asignados')
            ->emptyStateDescription('Este usuario no tiene clientes asignados.')
            ->emptyStateIcon('heroicon-o-building-office')
            ->defaultSort('created_at', 'desc')
            ->searchable()
            ->paginated([10, 25, 50])
            ->striped();
    }
}
