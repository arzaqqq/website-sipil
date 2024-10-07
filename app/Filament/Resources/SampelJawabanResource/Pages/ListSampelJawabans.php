<?php

namespace App\Filament\Resources\SampelJawabanResource\Pages;

use App\Filament\Resources\SampelJawabanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSampelJawabans extends ListRecords
{
    protected static string $resource = SampelJawabanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
