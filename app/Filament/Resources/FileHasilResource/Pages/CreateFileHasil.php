<?php

namespace App\Filament\Resources\FileHasilResource\Pages;

use App\Filament\Resources\FileHasilResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFileHasil extends CreateRecord
{
    protected static string $resource = FileHasilResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}