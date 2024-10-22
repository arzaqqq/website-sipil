<?php

namespace App\Filament\Resources\AverageResource\Pages;

use App\Filament\Resources\AverageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAverage extends EditRecord
{
    protected static string $resource = AverageResource::class;

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