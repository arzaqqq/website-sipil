<?php

namespace App\Filament\Resources\DokumenResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Storage;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\DokumenResource;
use App\Models\Dokumen;

class EditDokumen extends EditRecord
{
    protected static string $resource = DokumenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->after(
                function (Dokumen $record) {
                    // Cek apakah file_dokumen ada
                    if ($record->file_dokumen) {
                        // Dapatkan path lengkap ke file
                        $fullPath = public_path('storage/' . $record->file_dokumen); // Sesuaikan dengan path yang digunakan

                        // Hapus file fisik jika ada
                        if (file_exists($fullPath)) {
                            unlink($fullPath); // Menghapus file dari folder public
                        }
                    }
                }
            ),
        ];
    }



    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
