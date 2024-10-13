<?php

namespace App\Filament\Resources\PersenResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\PersenResource;
use Filament\Notifications\Notification;

class CreatePersen extends CreateRecord
{
    protected static string $resource = PersenResource::class;

    protected function afterCreate(): void
    {
        Notification::make()
            ->title('Data Persentase Berhasil Ditambahkan')
            ->success()
            ->send();
    }
}