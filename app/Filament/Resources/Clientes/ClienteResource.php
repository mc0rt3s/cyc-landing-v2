<?php

namespace App\Filament\Resources\Clientes;

use App\Filament\Resources\Clientes\Pages\CreateCliente;
use App\Filament\Resources\Clientes\Pages\EditCliente;
use App\Filament\Resources\Clientes\Pages\ListClientes;
use App\Filament\Resources\Clientes\Pages\ViewCliente;
use App\Models\Entity;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use UnitEnum;

class ClienteResource extends Resource
{
    protected static ?string $model = Entity::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $recordTitleAttribute = 'display_name';

    protected static string | UnitEnum | null $navigationGroup = 'Gestión de Clientes';
    protected static ?string $navigationLabel = 'Clientes';
    protected static ?string $modelLabel = 'Cliente';
    protected static ?string $pluralModelLabel = 'Clientes';

    protected static ?int $navigationSort = 2;

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->where('is_client', true);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('formatted_dni')
                    ->label('RUT')
                    ->searchable(query: fn (\Illuminate\Database\Eloquent\Builder $query, string $search): \Illuminate\Database\Eloquent\Builder => $query->where('dni', 'like', "%{$search}%"))
                    ->sortable(query: fn (\Illuminate\Database\Eloquent\Builder $query, string $direction): \Illuminate\Database\Eloquent\Builder => $query->orderBy('dni', $direction))
                    ->copyable()
                    ->copyMessage('RUT copiado al portapapeles')
                    ->tooltip('Haz clic para copiar el RUT'),

                TextColumn::make('display_name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                BadgeColumn::make('type')
                    ->label('Tipo')
                    ->colors([
                        'primary' => Entity::TYPE_PERSON,
                        'success' => Entity::TYPE_COMPANY,
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        Entity::TYPE_PERSON => 'Persona Natural',
                        Entity::TYPE_COMPANY => 'Empresa',
                        default => $state,
                    }),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('phone')
                    ->label('Teléfono')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('city')
                    ->label('Ciudad')
                    ->searchable()
                    ->sortable(),

                BadgeColumn::make('tax_regime')
                    ->label('Régimen Tributario')
                    ->colors([
                        'primary' => Entity::TAX_REGIME_18D3,
                        'success' => Entity::TAX_REGIME_D8,
                        'warning' => Entity::TAX_REGIME_A,
                        'gray' => Entity::TAX_REGIME_OTHER,
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        Entity::TAX_REGIME_18D3 => '18D3',
                        Entity::TAX_REGIME_D8 => 'D8',
                        Entity::TAX_REGIME_A => 'A',
                        Entity::TAX_REGIME_OTHER => 'Otro',
                        default => $state,
                    }),

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

                Filter::make('search')
                    ->form([
                        \Filament\Forms\Components\TextInput::make('search')
                            ->label('Buscar')
                            ->placeholder('Buscar por nombre, RUT, email...'),
                    ])
                    ->query(function (\Illuminate\Database\Eloquent\Builder $query, array $data): \Illuminate\Database\Eloquent\Builder {
                        return $query->search($data['search'] ?? '');
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->searchable()
            ->paginated([10, 25, 50, 100])
            ->striped()
            ->deferLoading();
    }

    public static function getRelations(): array
    {
        return [
            \App\Filament\Resources\Clientes\RelationManagers\UsersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListClientes::route('/'),
            'create' => CreateCliente::route('/create'),
            'view' => ViewCliente::route('/{record}'),
            'edit' => EditCliente::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('is_client', true)->count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'success';
    }
}
