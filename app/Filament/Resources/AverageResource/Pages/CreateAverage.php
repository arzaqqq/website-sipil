<?php

namespace App\Filament\Resources\AverageResource\Pages;

use App\Filament\Resources\AverageResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAverage extends CreateRecord
{
    protected static string $resource = AverageResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}