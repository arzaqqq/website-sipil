<?php

namespace App\Filament\Resources\RubrikResource\Pages;

use App\Filament\Resources\RubrikResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRubriks extends ListRecords
{
    protected static string $resource = RubrikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
