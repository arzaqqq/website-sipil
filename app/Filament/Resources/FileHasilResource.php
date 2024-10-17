<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\FileHasil;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\FileHasilResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\FileHasilResource\RelationManagers;

class FileHasilResource extends Resource
{
    protected static ?string $model = FileHasil::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Upload File Hasil ';
    protected static ?string $navigationGroup = 'Hasil & Evaluasi';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('matakuliah_id')
                    ->label('Mata Kuliah')
                    ->relationship('matakuliah', 'nama_mk')
                    ->required()
                    ->reactive(),
                
                Forms\Components\Select::make('kelas_id')
                    ->label('Kelas')
                    ->options(function (callable $get) {
                        $matakuliahId = $get('matakuliah_id');
                        if (!$matakuliahId) {
                            return [];
                        }
                        return \App\Models\Kelas::where('matakuliah_id', $matakuliahId)
                            ->pluck('nama_kelas', 'id');
                    })
                    ->required(),

                    FileUpload::make('file_hasil')
                    ->label('File Hasil Nilai')
                    ->required()
                    ->preserveFilenames()
                    ->directory('hasil'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('mataKuliah.nama_mk')
                    ->label('Mata Kuliah'),

                Tables\Columns\TextColumn::make('kelas.nama_kelas')
                    ->label('Kelas'),
                    
                    TextColumn::make('file_hasil')
                    ->label('File Hasil Nilai')
                    ->formatStateUsing(function ($state) {
                        // Extract the filename from the path
                        return basename($state);
                    })
                    ->url(function ($record) {
                        // Generate a downloadable URL
                        return Storage::url($record->file_hasil);
                    })
                    ,

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListFileHasils::route('/'),
            'create' => Pages\CreateFileHasil::route('/create'),
            'edit' => Pages\EditFileHasil::route('/{record}/edit'),
        ];
    }
}