<?php

namespace App\Filament\Resources\HasilResource\Pages;

use App\Filament\Resources\HasilResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Livewire\TemporaryUploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\HasilsImport;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;

class CreateHasil extends CreateRecord
{
    protected static string $resource = HasilResource::class;

    protected function getActions(): array
    {
        return [
            Actions\Action::make('importHasil')
                ->label('Import Hasil')
                ->color('danger')
                ->icon('heroicon-o-document-arrow-down')
                ->form([
                    FileUpload::make('attachment')
                        ->required()
                        ->acceptedFileTypes(['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel']),
                ])
                ->action(function (array $data) {
                    /** @var TemporaryUploadedFile $file */
                    $file = $data['attachment'];
                    $filePath = $file->storeAs('uploads', $file->getClientOriginalName());

                    // Import the Excel file
                    Excel::import(new HasilsImport, storage_path('app/' . $filePath));

                    // Show notification
                    Notification::make()
                        ->title('Hasil Berhasil Di Import')
                        ->success()
                        ->send();
                }),
        ];
    }
}