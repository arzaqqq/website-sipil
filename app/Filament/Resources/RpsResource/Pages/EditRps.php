<?php

namespace App\Filament\Resources\RpsResource\Pages;

use App\Filament\Resources\RpsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRps extends EditRecord
{
    protected static string $resource = RpsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
