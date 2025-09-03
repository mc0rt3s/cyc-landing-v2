<?php

namespace App\Filament\Resources\Clientes\RelationManagers;

use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\AttachAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\BulkActionGroup;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $title = 'Usuarios Responsables';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Asignado el')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado el')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user')
                    ->label('Usuario')
                    ->options(User::pluck('name', 'id'))
                    ->searchable()
                    ->placeholder('Filtrar por usuario'),
            ])
            ->headerActions([
                AttachAction::make()
                    ->label('Asignar Usuario')
                    ->icon('heroicon-o-user-plus')
                    ->form([
                        Forms\Components\Select::make('recordId')
                            ->label('Usuario')
                            ->options(User::pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->placeholder('Seleccionar usuario a asignar'),
                    ])
                    ->successNotificationTitle('Usuario asignado exitosamente'),
            ])
            ->actions([
                DetachAction::make()
                    ->label('Desasignar')
                    ->icon('heroicon-o-user-minus')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Desasignar Usuario')
                    ->modalDescription('¿Estás seguro de que quieres desasignar a este usuario del cliente?')
                    ->modalSubmitActionLabel('Desasignar')
                    ->successNotificationTitle('Usuario desasignado exitosamente'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DetachBulkAction::make()
                        ->label('Desasignar Seleccionados')
                        ->icon('heroicon-o-user-minus')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Desasignar Usuarios')
                        ->modalDescription('¿Estás seguro de que quieres desasignar a todos los usuarios seleccionados?')
                        ->modalSubmitActionLabel('Desasignar'),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->searchable()
            ->paginated([10, 25, 50])
            ->striped();
    }
}
