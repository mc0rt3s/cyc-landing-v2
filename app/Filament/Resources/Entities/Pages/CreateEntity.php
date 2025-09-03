<?php

namespace App\Filament\Resources\Entities\Pages;

use App\Filament\Resources\Entities\EntityResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEntity extends CreateRecord
{
    protected static string $resource = EntityResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Contribuyente creado exitosamente';
    }
}
