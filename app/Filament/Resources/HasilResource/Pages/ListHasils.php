<?php

namespace App\Filament\Resources\HasilResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use App\Imports\HasilsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Response;
use App\Filament\Resources\HasilResource;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Pages\ListRecords;

class ListHasils extends ListRecords
{
    protected static string $resource = HasilResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
            
            Action::make('importHasil')
                ->label('Import Hasil')
                ->color('danger')
                ->icon('heroicon-o-document-arrow-down')
                ->form([
                    FileUpload::make('attachment'),
                ])
                ->action(function (array $data) {
                    $filePath = public_path('storage/'.$data['attachment']);
                    Excel::import(new HasilsImport, $filePath);

                    Notification::make()
                        ->title('Hasil Berhasil Di Import')
                        ->success()
                        ->send();
                }),

            Action::make('downloadTemplate')
                ->label('Download Template')
                ->color('success')
                ->icon('heroicon-o-arrow-down')
                ->action(function () {
                    $filePath = public_path('storage/templates/template.xlsx'); // Use .xlsx extension

                    // Append a timestamp to the file path to avoid caching issues
                    if (file_exists($filePath)) {
                        $timestamp = filemtime($filePath); // Get file modification time
                        return Response::download($filePath, 'template.xlsx', [
                            'Cache-Control' => 'no-cache, must-revalidate',
                            'Expires' => '0',
                        ])->setContentDisposition('attachment', "template_{$timestamp}.xlsx");
                    } else {
                        Notification::make()
                            ->title('Template Tidak Ditemukan')
                            ->danger()
                            ->send();
                    }
                }),

            Action::make('replaceTemplate')
                ->label('Ganti Template')
                ->color('primary')
                ->icon('heroicon-o-arrows-right-left')
                ->form([
                    FileUpload::make('newTemplate')
                        ->label('Upload New Template')
                        ->directory('templates') // Ensure it saves to the templates folder
                        ->acceptedFileTypes(['text/csv', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']), // Allow CSV and Excel files
                ])
                ->action(function (array $data) {
                    $templateDir = public_path('storage/templates/');
                    $oldTemplate = $templateDir . 'template.xlsx'; // Use .xlsx extension
                    
                    // Delete the old template if it exists
                    if (file_exists($oldTemplate)) {
                        unlink($oldTemplate);
                    }

                    // Store the new template
                    Storage::disk('public')->move($data['newTemplate'], 'templates/template.xlsx'); // Use .xlsx extension

                    Notification::make()
                        ->title('Template Berhasil Diganti')
                        ->success()
                        ->send();
                }),
        ];
    }
}