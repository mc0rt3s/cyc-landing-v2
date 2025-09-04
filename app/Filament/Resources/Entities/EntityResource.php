<?php

namespace App\Filament\Resources\Entities;

use App\Filament\Resources\Entities\Pages\CreateEntity;
use App\Filament\Resources\Entities\Pages\EditEntity;
use App\Filament\Resources\Entities\Pages\ListEntities;
use App\Filament\Resources\Entities\Pages\ViewEntity;
use App\Filament\Resources\Entities\Schemas\EntityForm;
use App\Filament\Resources\Entities\Tables\EntitiesTable;
use App\Models\Entity;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class EntityResource extends Resource
{
    protected static ?string $model = Entity::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice;

    protected static ?string $recordTitleAttribute = 'first_name';

    protected static string | UnitEnum | null $navigationGroup = 'Gestión de Clientes';
    protected static ?string $navigationLabel = 'Contribuyentes';
    protected static ?string $modelLabel = 'Contribuyente';
    protected static ?string $pluralModelLabel = 'Contribuyentes';

    protected static ?int $navigationSort = 1;

    protected static int $globalSearchResultsLimit = 20;

    public static function form(Schema $schema): Schema
    {
        return EntityForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EntitiesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            \App\Filament\Resources\Entities\RelationManagers\PartnersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEntities::route('/'),
            'create' => CreateEntity::route('/create'),
            'view' => ViewEntity::route('/{record}'),
            'edit' => EditEntity::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'success';
    }

    public static function getGlobalSearchResultTitle($record): string
    {
        return $record->display_name;
    }

    public static function getGlobalSearchResultDetails($record): array
    {
        return [
            'RUT' => $record->formatted_dni,
            'Tipo' => $record->type_label,
            'Email' => $record->email,
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['dni', 'first_name', 'last_name', 'business_name', 'commercial_name', 'email'];
    }

    public static function getGlobalSearchEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getGlobalSearchEloquentQuery()->where('is_client', true);
    }
}
