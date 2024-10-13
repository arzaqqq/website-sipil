<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Kelas;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;

use Filament\Resources\Components\Tab;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\KelasResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\KelasResource\RelationManagers;
use Illuminate\Database\Eloquent\Collection;



class KelasResource extends Resource
{
    protected static ?string $model = Kelas::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $navigationGroup = 'Perkuliahan';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('matakuliah_id')
                    ->relationship('matakuliah', 'nama_mk')
                    ->required()
                    ->columnSpanFull()
                    ->searchable(),
                Forms\Components\TextInput::make('nama_kelas')
                    ->required()
                    ->minLength(2)
                    ->columnSpanFull(),
               
                FileUpload::make('file_kelas')
                    ->label('File Kontak')
                    ->required()
                    ->columnSpanFull()
                    ->directory('kelas')
                    ->preserveFilenames() 
                    
            ]);
    }
    

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('nama_kelas')->sortable(),
            Tables\Columns\TextColumn::make('matakuliah.nama_mk')->sortable(),
            Tables\Columns\TextColumn::make('matakuliah.semester')->label('semester'),
            Tables\Columns\TextColumn::make('status')
                ->label('Status')
                ->formatStateUsing(fn ($state) => $state ? 'Aktif' : 'Tidak Aktif'),
                Tables\Columns\TextColumn::make('file_kelas')
                ->label('File Kontrak')
                ->formatStateUsing(fn ($state) => $state ? 'File Kontrak' : 'No File')
                ->url(fn ($record) => $record->file_kelas ? asset("storage/{$record->file_kelas}") : null)
                ->openUrlInNewTab() 
                ->extraAttributes([
                    'style' => 'cursor: pointer; ',
                    'title' => 'Download File Kontrak',
                    'class' => 'hover-underline-primary',
                    
                ]),
        ])
        ->filters([
            Tables\Filters\Filter::make('Semester Ganjil')
                ->query(fn (Builder $query) => $query->whereHas('matakuliah', fn (Builder $query) => 
                    $query->where('semester', 'ganjil'))), // Join ke tabel matakuliah
            Tables\Filters\Filter::make('Semester Genap')
                ->query(fn (Builder $query) => $query->whereHas('matakuliah', fn (Builder $query) => 
                    $query->where('semester', 'genap'))), // Join ke tabel matakuliah
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                // Tables\Actions\DeleteBulkAction::make(),
                BulkAction::make('Aktif')
                ->action(function (Collection $records) {
                    $records->each->update(['status' => 1]); // Set to Aktif
                })
                ->label('Status Aktif')
                ->icon('heroicon-o-check-circle')  // Add success icon
                ->requiresConfirmation()
                ->color('success'),
            
            BulkAction::make('Tidak Aktif')
                ->action(function (Collection $records) {
                    $records->each->update(['status' => 0]); // Set to Tidak Aktif
                })
                ->label('Status Tidak Aktif')
                ->icon('heroicon-o-x-circle')  // Add danger icon
                ->requiresConfirmation()
                ->color('danger'),
            
            ]),
        ]);
}


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKelas::route('/'),
            'create' => Pages\CreateKelas::route('/create'),
            'edit' => Pages\EditKelas::route('/{record}/edit'),
        ];
    }

  
 

  
 

}