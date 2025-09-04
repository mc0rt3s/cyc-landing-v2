<?php

namespace App\Filament\Resources\Entities\RelationManagers;

use App\Models\Entity;
use App\Models\EntityPartnership;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PartnersRelationManager extends RelationManager
{
    protected static string $relationship = 'partners';

    protected static ?string $title = 'Socios de la Empresa';

    protected static ?string $recordTitleAttribute = 'partner.display_name';

    // La mejor funcion para verificar si se puede ver el relation manager
    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return $ownerRecord->type === 'company';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('partner_dni')
                    ->label('Socio')
                    ->options(function () {
                        return Entity::where('dni', '!=', $this->ownerRecord->dni)
                            ->get()
                            ->mapWithKeys(function ($entity) {
                                return [$entity->dni => $entity->display_name . ' (' . $entity->formatted_dni . ')'];
                            });
                    })
                    ->searchable()
                    ->required()
                    ->placeholder('Seleccionar socio'),

                TextInput::make('participation_percentage')
                    ->label('Porcentaje de Participación')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->step(0.01)
                    ->suffix('%')
                    ->required()
                    ->helperText('Porcentaje de participación en la empresa'),

                Select::make('partnership_type')
                    ->label('Tipo de Participación')
                    ->options(EntityPartnership::getPartnershipTypes())
                    ->default(EntityPartnership::TYPE_SOCIO)
                    ->required(),

                DatePicker::make('start_date')
                    ->label('Fecha de Inicio')
                    ->default(now())
                    ->required(),

                DatePicker::make('end_date')
                    ->label('Fecha de Fin')
                    ->nullable()
                    ->helperText('Dejar vacío si la participación está activa'),

                Toggle::make('is_active')
                    ->label('Activo')
                    ->default(true)
                    ->helperText('Indica si la participación está activa'),

                Textarea::make('notes')
                    ->label('Notas')
                    ->rows(3)
                    ->nullable()
                    ->helperText('Notas adicionales sobre la participación'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('partner.display_name')
            ->columns([
                TextColumn::make('partner.formatted_dni')
                    ->label('RUT del Socio')
                    ->searchable(['partner.dni'])
                    ->sortable(['partner.dni']),

                TextColumn::make('partner.display_name')
                    ->label('Nombre del Socio')
                    ->searchable(['partner.first_name', 'partner.last_name', 'partner.business_name', 'partner.commercial_name'])
                    ->sortable(),

                TextColumn::make('partner.type')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'person' => 'success',
                        'company' => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'person' => 'Persona',
                        'company' => 'Empresa',
                        default => 'Desconocido',
                    }),

                TextColumn::make('participation_percentage')
                    ->label('Participación')
                    ->suffix('%')
                    ->sortable()
                    ->alignEnd()
                    ->weight('bold'),

                BadgeColumn::make('partnership_type')
                    ->label('Tipo')
                    ->colors([
                        'primary' => EntityPartnership::TYPE_SOCIO,
                        'success' => EntityPartnership::TYPE_ACCIONISTA,
                        'warning' => EntityPartnership::TYPE_PARTICIPE,
                        'gray' => EntityPartnership::TYPE_OTRO,
                    ])
                    ->formatStateUsing(fn (string $state): string => EntityPartnership::getPartnershipTypes()[$state] ?? $state),

                TextColumn::make('start_date')
                    ->label('Fecha de Inicio')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('end_date')
                    ->label('Fecha de Fin')
                    ->date('d/m/Y')
                    ->sortable()
                    ->placeholder('Activo'),

                IconColumn::make('is_active')
                    ->label('Estado')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                TextColumn::make('created_at')
                    ->label('Registrado el')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('partnership_type')
                    ->label('Tipo de Participación')
                    ->options(EntityPartnership::getPartnershipTypes()),

                TernaryFilter::make('is_active')
                    ->label('Estado')
                    ->placeholder('Todos los estados')
                    ->trueLabel('Activos')
                    ->falseLabel('Inactivos'),

                SelectFilter::make('partner_type')
                    ->label('Tipo de Socio')
                    ->options([
                        'person' => 'Persona',
                        'company' => 'Empresa',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (empty($data['value'])) {
                            return $query;
                        }
                        return $query->whereHas('partner', function (Builder $query) use ($data) {
                            $query->where('type', $data['value']);
                        });
                    }),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Agregar Socio')
                    ->icon('heroicon-o-plus')
                    ->modalHeading('Agregar Nuevo Socio')
                    ->modalDescription('Agregar un nuevo socio a esta empresa')
                    ->successNotificationTitle('Socio agregado exitosamente'),
            ])
            ->actions([
                EditAction::make()
                    ->label('Editar')
                    ->icon('heroicon-o-pencil')
                    ->modalHeading('Editar Participación del Socio')
                    ->successNotificationTitle('Participación actualizada exitosamente'),

                DeleteAction::make()
                    ->label('Eliminar')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Eliminar Socio')
                    ->modalDescription('¿Estás seguro de que quieres eliminar a este socio de la empresa?')
                    ->modalSubmitActionLabel('Eliminar')
                    ->successNotificationTitle('Socio eliminado exitosamente'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Eliminar Seleccionados')
                        ->icon('heroicon-o-trash')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Eliminar Socios')
                        ->modalDescription('¿Estás seguro de que quieres eliminar a todos los socios seleccionados?')
                        ->modalSubmitActionLabel('Eliminar'),
                ]),
            ])
            ->emptyStateHeading('No hay socios registrados')
            ->emptyStateDescription('Esta empresa no tiene socios registrados. Agrega el primer socio para comenzar.')
            ->emptyStateIcon('heroicon-o-users')
            ->defaultSort('participation_percentage', 'desc')
            ->searchable()
            ->paginated([10, 25, 50])
            ->striped();
    }
}
