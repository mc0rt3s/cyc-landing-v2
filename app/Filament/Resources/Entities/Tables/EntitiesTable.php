<?php

namespace App\Filament\Resources\Entities\Tables;

use App\Filament\Resources\Entities\EntityResource;
use App\Models\Entity;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class EntitiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('formatted_dni')
                    ->label('RUT')
                    ->searchable(['dni'])
                    ->sortable(query: fn (Builder $query, string $direction): Builder => $query->orderBy('dni', $direction))
                    ->copyable()
                    ->copyMessage('RUT copiado al portapapeles')
                    ->tooltip('Haz clic para copiar el RUT'),

                TextColumn::make('display_name')
                    ->label('Nombre')
                    ->searchable(['first_name', 'last_name', 'business_name', 'commercial_name'])
                    ->sortable()
                    ->limit(50),

                BadgeColumn::make('type')
                    ->label('Tipo')
                    ->colors([
                        'primary' => Entity::TYPE_PERSON,
                        'success' => Entity::TYPE_COMPANY,
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        Entity::TYPE_PERSON => 'Persona',
                        Entity::TYPE_COMPANY => 'Empresa',
                        default => $state,
                    }),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('phone')
                    ->label('Teléfono')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('city')
                    ->label('Ciudad')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                BadgeColumn::make('tax_regime')
                    ->label('Régimen')
                    ->colors([
                        'warning' => Entity::TAX_REGIME_18D3,
                        'info' => Entity::TAX_REGIME_D8,
                        'success' => Entity::TAX_REGIME_A,
                        'gray' => Entity::TAX_REGIME_OTHER,
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        Entity::TAX_REGIME_18D3 => '18D3',
                        Entity::TAX_REGIME_D8 => 'D8',
                        Entity::TAX_REGIME_A => 'A',
                        Entity::TAX_REGIME_OTHER => 'Otro',
                        default => $state,
                    })
                    ->toggleable(isToggledHiddenByDefault: true),

                ToggleColumn::make('is_client')
                    ->label('Cliente')
                    ->sortable(),

                BadgeColumn::make('status')
                    ->label('Estado')
                    ->colors([
                        'success' => Entity::STATUS_ACTIVE,
                        'warning' => Entity::STATUS_INACTIVE,
                        'danger' => Entity::STATUS_BLOCKED,
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        Entity::STATUS_ACTIVE => 'Activo',
                        Entity::STATUS_INACTIVE => 'Inactivo',
                        Entity::STATUS_BLOCKED => 'Bloqueado',
                        default => $state,
                    }),

                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Tipo de Contribuyente')
                    ->options([
                        Entity::TYPE_PERSON => 'Persona Natural',
                        Entity::TYPE_COMPANY => 'Empresa',
                    ]),

                SelectFilter::make('status')
                    ->label('Estado')
                    ->options([
                        Entity::STATUS_ACTIVE => 'Activo',
                        Entity::STATUS_INACTIVE => 'Inactivo',
                        Entity::STATUS_BLOCKED => 'Bloqueado',
                    ]),

                SelectFilter::make('tax_regime')
                    ->label('Régimen Tributario')
                    ->options([
                        Entity::TAX_REGIME_18D3 => '18D3 - Régimen General',
                        Entity::TAX_REGIME_D8 => 'D8 - Régimen Simplificado',
                        Entity::TAX_REGIME_A => 'A - Régimen Agrícola',
                        Entity::TAX_REGIME_OTHER => 'Otro Régimen',
                    ]),

                TernaryFilter::make('is_client')
                    ->label('Es Cliente')
                    ->placeholder('Todos los contribuyentes')
                    ->trueLabel('Solo clientes')
                    ->falseLabel('Solo no clientes'),

                Filter::make('advanced_search')
                    ->form([
                        TextInput::make('search')
                            ->label('Búsqueda Avanzada')
                            ->placeholder('RUT, nombre, email, teléfono, ciudad...')
                            ->helperText('Busca en todos los campos: RUT (con o sin formato), nombres, emails, teléfonos y ciudades'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->search($data['search'] ?? '');
                    })
                    ->indicateUsing(function (array $data): ?string {
                        if (empty($data['search'])) {
                            return null;
                        }
                        return 'Búsqueda: ' . $data['search'];
                    }),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make()
                        ->label('Ver')
                        ->icon('heroicon-o-eye'),
                    EditAction::make()
                        ->label('Editar')
                        ->icon('heroicon-o-pencil'),
                    Action::make('toggle_client')
                        ->label('Cambiar Estado Cliente')
                        ->icon('heroicon-o-user')
                        ->color('warning')
                        ->action(function (Entity $record): void {
                            $record->is_client ? $record->markAsNonClient() : $record->markAsClient();
                        })
                        ->requiresConfirmation()
                        ->modalHeading('Cambiar Estado de Cliente')
                        ->modalDescription(fn (Entity $record): string =>
                            $record->is_client
                                ? "¿Estás seguro de que quieres marcar a '{$record->display_name}' como NO cliente?"
                                : "¿Estás seguro de que quieres marcar a '{$record->display_name}' como cliente?"
                        )
                        ->modalSubmitActionLabel('Confirmar'),
                    Action::make('toggle_status')
                        ->label('Cambiar Estado')
                        ->icon('heroicon-o-arrow-path')
                        ->color('info')
                        ->form([
                            Select::make('status')
                                ->label('Nuevo Estado')
                                ->options([
                                    Entity::STATUS_ACTIVE => 'Activo',
                                    Entity::STATUS_INACTIVE => 'Inactivo',
                                    Entity::STATUS_BLOCKED => 'Bloqueado',
                                ])
                                ->required()
                                ->default(fn (Entity $record): string => $record->status),
                        ])
                        ->action(function (Entity $record, array $data): void {
                            $record->update(['status' => $data['status']]);
                        })
                        ->requiresConfirmation()
                        ->modalHeading('Cambiar Estado de Contribuyente'),
                ])
                ->icon('heroicon-m-ellipsis-vertical')
                ->tooltip('Acciones'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    BulkAction::make('mark_as_clients')
                        ->label('Marcar como Clientes')
                        ->icon('heroicon-o-user')
                        ->color('success')
                        ->action(function (Collection $records): void {
                            $records->each->markAsClient();
                        })
                        ->requiresConfirmation()
                        ->modalHeading('Marcar como Clientes')
                        ->modalDescription('¿Estás seguro de que quieres marcar todos los contribuyentes seleccionados como clientes?')
                        ->modalSubmitActionLabel('Confirmar'),

                    BulkAction::make('mark_as_non_clients')
                        ->label('Marcar como No Clientes')
                        ->icon('heroicon-o-user-minus')
                        ->color('warning')
                        ->action(function (Collection $records): void {
                            $records->each->markAsNonClient();
                        })
                        ->requiresConfirmation()
                        ->modalHeading('Marcar como No Clientes')
                        ->modalDescription('¿Estás seguro de que quieres marcar todos los contribuyentes seleccionados como no clientes?')
                        ->modalSubmitActionLabel('Confirmar'),

                    BulkAction::make('activate')
                        ->label('Activar')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function (Collection $records): void {
                            $records->each->activate();
                        })
                        ->requiresConfirmation()
                        ->modalHeading('Activar Contribuyentes')
                        ->modalDescription('¿Estás seguro de que quieres activar todos los contribuyentes seleccionados?')
                        ->modalSubmitActionLabel('Confirmar'),

                    DeleteBulkAction::make()
                        ->label('Eliminar Seleccionadas')
                        ->requiresConfirmation()
                        ->modalHeading('Eliminar Contribuyentes')
                        ->modalDescription('¿Estás seguro de que quieres eliminar todos los contribuyentes seleccionados? Esta acción no se puede deshacer.')
                        ->modalSubmitActionLabel('Eliminar'),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->searchable()
            ->searchPlaceholder('Buscar por RUT, nombre, email, teléfono, ciudad...')
            ->paginated([10, 25, 50, 100])
            ->striped()
            ->deferLoading();
    }
}
