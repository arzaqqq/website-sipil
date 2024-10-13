<?php

namespace App\Filament\Resources\PersenResource\Pages;

use App\Filament\Resources\PersenResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use App\Models\Persen;

class EditPersen extends EditRecord
{
    protected static string $resource = PersenResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Menghitung total persentase sebelum menyimpan
        $totalPersen = intval($data['persen_absen']) + intval($data['persen_latihan']) + intval($data['persen_UTS']) + intval($data['persen_UAS']);
        $data['total_persen'] = $totalPersen;

        // Validasi bahwa total persentase harus 100%
        if ($totalPersen !== 100) {
            Notification::make()
                ->title('Total persentase harus 100%')
                ->danger()
                ->send();
            $this->halt(); // Hentikan proses penyimpanan jika total tidak 100%
        }

        return $data;
    }

    protected function afterSave(): void
    {
        Notification::make()
            ->title('Data berhasil diperbarui!')
            ->success()
            ->send();
    }
}