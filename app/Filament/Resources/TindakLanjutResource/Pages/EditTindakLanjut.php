<?php

namespace App\Filament\Resources\TindakLanjutResource\Pages;

use App\Filament\Resources\TindakLanjutResource;
use App\Models\TindakLanjut;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTindakLanjut extends EditRecord
{
    protected static string $resource = TindakLanjutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->after(
                function (TindakLanjut $record) {
                    if ($record->file_tindak_lanjut) {
                        $fullPath = public_path('storage/' . $record->file_tindak_lanjut); // Sesuaikan dengan path yang digunakan
                        if (file_exists($fullPath) && !is_dir($fullPath)) {
                            unlink($fullPath);
                        }
                    }
                }
            ),
        ];
    }
}
