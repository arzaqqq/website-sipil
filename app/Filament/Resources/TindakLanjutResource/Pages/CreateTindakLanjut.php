<?php

namespace App\Filament\Resources\TindakLanjutResource\Pages;

use App\Filament\Resources\TindakLanjutResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTindakLanjut extends CreateRecord
{
    protected static string $resource = TindakLanjutResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
