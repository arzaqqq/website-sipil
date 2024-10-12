<?php

namespace App\Filament\Resources\HeaderLulusanResource\Pages;

use App\Filament\Resources\HeaderLulusanResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageHeaderLulusans extends ManageRecords
{
    protected static string $resource = HeaderLulusanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
