<?php

namespace App\Filament\Resources\Entities\Pages;

use App\Filament\Resources\Entities\EntityResource;
use App\Models\Entity;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;

class ListEntities extends ListRecords
{
    protected static string $resource = EntityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Nuevo Contribuyente')
                ->icon('heroicon-o-plus'),

            Action::make('export_csv')
                ->label('Exportar CSV')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(function () {
                    // TODO: Implementar exportación a CSV
                    return redirect()->back()->with('success', 'Exportación iniciada');
                }),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            // TODO: Agregar widgets de estadísticas
        ];
    }
}
