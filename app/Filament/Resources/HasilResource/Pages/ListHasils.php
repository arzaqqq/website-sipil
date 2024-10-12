<?php
namespace App\Filament\Resources\HasilResource\Pages;

use Filament\Forms;
use App\Models\Kelas;
use Filament\Actions;
use App\Models\Persen;
use App\Models\Matakuliah;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use App\Filament\Resources\HasilResource;
use Filament\Resources\Pages\ListRecords;

class ListHasils extends ListRecords
{
    protected static string $resource = HasilResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            
           
        ];
    }
}