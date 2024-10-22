<?php
namespace App\Filament\Resources\EvaluasiResource\Pages;

use App\Filament\Resources\EvaluasiResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEvaluasi extends CreateRecord
{
    protected static string $resource = EvaluasiResource::class;

    protected function beforeSave(): void
    {
        // Pastikan perhitungan dilakukan sebelum record disimpan
        $this->data['average_mahasiswa_persen'] = $this->data['bobot'] * $this->data['average_mahasiswa_angka'] / 100;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}