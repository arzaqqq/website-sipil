<?php

namespace App\Filament\Resources\SampelJawabanResource\Pages;

use App\Filament\Resources\SampelJawabanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSampelJawaban extends EditRecord
{
    protected static string $resource = SampelJawabanResource::class;

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