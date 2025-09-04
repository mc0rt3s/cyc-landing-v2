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

            protected static ?string $recordTitleAttribute = null;

    protected static string | UnitEnum | null $navigationGroup = 'Gestión de Clientes';
    protected static ?string $navigationLabel = 'Contribuyentes';
    protected static ?string $modelLabel = 'Contribuyente';
    protected static ?string $pluralModelLabel = 'Contribuyentes';

        protected static ?int $navigationSort = 1;
    protected static bool $globallySearchable = false;

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

    }
