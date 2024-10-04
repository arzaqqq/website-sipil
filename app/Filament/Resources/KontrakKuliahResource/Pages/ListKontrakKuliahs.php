<?php

namespace App\Filament\Resources\KontrakKuliahResource\Pages;

use App\Filament\Resources\KontrakKuliahResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKontrakKuliahs extends ListRecords
{
    protected static string $resource = KontrakKuliahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
