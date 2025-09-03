<?php

namespace App\Filament\Resources\Entities\Pages;

use App\Filament\Resources\Entities\EntityResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditEntity extends EditRecord
{
    protected static string $resource = EntityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()
                ->label('Ver')
                ->icon('heroicon-o-eye'),
            DeleteAction::make()
                ->label('Eliminar')
                ->icon('heroicon-o-trash'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Contribuyente actualizado exitosamente';
    }
}
