<?php

namespace App\Filament\Resources\SampelJawabanResource\Pages;

use App\Filament\Resources\SampelJawabanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSampelJawaban extends CreateRecord
{
    protected static string $resource = SampelJawabanResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}