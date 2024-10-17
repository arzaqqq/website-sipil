<?php

namespace App\Filament\Resources\FileHasilResource\Pages;

use App\Filament\Resources\FileHasilResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFileHasils extends ListRecords
{
    protected static string $resource = FileHasilResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
