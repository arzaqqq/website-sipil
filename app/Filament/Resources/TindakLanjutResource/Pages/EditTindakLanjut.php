<?php

namespace App\Filament\Resources\TindakLanjutResource\Pages;

use App\Filament\Resources\TindakLanjutResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTindakLanjut extends EditRecord
{
    protected static string $resource = TindakLanjutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
