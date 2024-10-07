<?php

namespace App\Filament\Resources\KelasResource\Pages;

use Filament\Actions;
use Filament\Resources\Components\Tab;
use App\Filament\Resources\KelasResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListKelas extends ListRecords
{
    protected static string $resource = KelasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
{
    return [
        'all' => Tab::make(),
        'Semester Ganjil' => Tab::make()
    ->modifyQueryUsing(fn (Builder $query) => 
        $query->whereHas('matakuliah', fn (Builder $query) => 
            $query->where('semester', 'ganjil'))
    ),
'Semester Genap' => Tab::make()
    ->modifyQueryUsing(fn (Builder $query) => 
        $query->whereHas('matakuliah', fn (Builder $query) => 
            $query->where('semester', 'genap'))
    ),
    ];
}

}