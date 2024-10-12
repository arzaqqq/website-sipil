<?php

namespace App\Filament\Resources\AverageResource\Pages;

use App\Filament\Resources\AverageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAverages extends ListRecords
{
    protected static string $resource = AverageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
