<?php

namespace App\Filament\Resources\SettingFotoResource\Pages;

use App\Filament\Resources\SettingFotoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSettingFoto extends EditRecord
{
    protected static string $resource = SettingFotoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}