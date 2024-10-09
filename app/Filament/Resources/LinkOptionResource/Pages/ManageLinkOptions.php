<?php

namespace App\Filament\Resources\LinkOptionResource\Pages;

use App\Filament\Resources\LinkOptionResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageLinkOptions extends ManageRecords
{
    protected static string $resource = LinkOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
