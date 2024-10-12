<?php

namespace App\Filament\Resources;

use stdClass;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Matakuliah;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Notifications\Collection;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\HasManyRepeater;
use App\Filament\Resources\MatakuliahResource\Pages;


class MatakuliahResource extends Resource
{
    protected static ?string $model = Matakuliah::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Perkuliahan';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_mk')
                    ->required()
                    ->label('Nama Mata Kuliah')
                    ->columnSpanFull(),
                Select::make('semester')
                    ->options([
                       'Ganjil' => 'Ganjil',
                       'Genap' => 'Genap',
                    ])
                ->label('Semester')
                ->required()
                ->columnSpanFull(),    
                FileUpload::make('file_rps')
                    ->required()
                    ->label('File RPS')
                    ->columnSpanFull()
                    ->directory('RPS')
                    ->preserveFilenames() ,
                Repeater::make('materis')
                    ->relationship('materis')
                    ->schema([
                        Select::make('pertemuan')
                         ->options(array_combine(range(1, 16), range(1, 16)))
                          ->required()
                          ->label('Pertemuan'),
                        TextInput::make('judul_materi')->required(),
                        FileUpload::make('file_materi')->required()
                          ->directory('Materi')
                          ->preserveFilenames() ,
                    ])
                    ->minItems(1)
                    ->maxItems(16)
                    ->label('Materi Pertemuan')
                  
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No')->state(
                    static function (HasTable $livewire, stdClass $rowLoop): string {
                        return (string) (
                            $rowLoop->iteration +
                            ($livewire->getTableRecordsPerPage() * (
                                $livewire->getTablePage() - 1
                            ))
                        );
                    }
                ),
                TextColumn::make('nama_mk')
                    ->label('Nama Mata Kuliah')
                    ->searchable(),
                TextColumn::make('semester')
                    ->label('Semester')
                    ->formatStateUsing(fn ($state) => ucfirst($state)),    
                TextColumn::make('file_rps')
                ->label('File RPS')
                ->formatStateUsing(fn ($state) => $state ? '<a href="' . asset('storage/' . $state) . '" target="_blank">Download</a>' : 'No File')
                ->html()    
                ->extraAttributes(['onclick' => 'event.stopPropagation();']),
                
                TextColumn::make('materis')
                    ->label('Materi')
                    ->formatStateUsing(function ($record) {
                      return $record->materis()->orderBy('pertemuan', 'asc')->get()->map(function ($materi) {
                      return 'Pertemuan ' . $materi->pertemuan . ': <a href="' . asset('storage/' . $materi->file_materi) . '" target="_blank">' . $materi->judul_materi . '</a>';
                 })->implode('<br>');
                 })
                     ->html()
                     ->extraAttributes(['onclick' => 'event.stopPropagation();']),
            ])
            ->filters([
                
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                
            ]);
            
    }

    public static function getRelations(): array
    {
        return [
            // Define your relations here
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMatakuliahs::route('/'),
            'create' => Pages\CreateMatakuliah::route('/create'),
            ' edit' => Pages\EditMatakuliah::route('/{record}/edit'),
        ];
    }
}