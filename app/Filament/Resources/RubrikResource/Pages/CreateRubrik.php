<?php

namespace App\Filament\Resources\RubrikResource\Pages;

use App\Filament\Resources\RubrikResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRubrik extends CreateRecord
{
    protected static string $resource = RubrikResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}