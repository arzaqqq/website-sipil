<?php

namespace App\Filament\Resources\RubrikResource\Pages;

use App\Filament\Resources\RubrikResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRubrik extends EditRecord
{
    protected static string $resource = RubrikResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}