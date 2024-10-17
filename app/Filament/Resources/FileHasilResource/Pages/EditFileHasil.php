<?php

namespace App\Filament\Resources\FileHasilResource\Pages;

use App\Filament\Resources\FileHasilResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFileHasil extends EditRecord
{
    protected static string $resource = FileHasilResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}