<?php

namespace App\Filament\Resources\Clientes\Pages;

use App\Filament\Resources\Clientes\ClienteResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateCliente extends CreateRecord
{
    protected static string $resource = ClienteResource::class;

    protected function getRedirectUrl(): string
    {
        // Redirigir a la lista de contribuyentes con mensaje explicativo
        Notification::make()
            ->title('Crear Cliente')
            ->body('Para crear un nuevo cliente, ve a "Contribuyentes" y marca la opción "Es Cliente" al crear o editar un contribuyente.')
            ->info()
            ->send();

        return route('filament.intranet.resources.entities.index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Cliente creado exitosamente';
    }
}
