<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Rubrik;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\RubrikResource\Pages;
use App\Filament\Resources\RubrikResource\RelationManagers;

class RubrikResource extends Resource
{
    protected static ?string $model = Rubrik::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Perkuliahan';
    protected static ?int $navigationSort = 3;

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

                FileUpload::make('file_rubrik')
                    ->label('File Rubrik')
                    ->required()
                    ->preserveFilenames()
                    ->directory('rubrik'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('matakuliah.nama_mk')
                    ->label('Mata Kuliah'),

                Tables\Columns\TextColumn::make('kelas.nama_kelas')
                    ->label('Kelas'),

                    Tables\Columns\TextColumn::make('file_rubrik')
                     ->label('File Rubrik')
                        ->formatStateUsing(fn ($state) => $state ? 'Lihat File' : 'No File')
                        ->html()    
                        ->extraAttributes(['style' => 'text-align: left;']) // Mengatur teks agar rata kiri
                        ->tooltip(fn ($state) => $state ? 'Klik untuk mengunduh' : null) // Menambahkan tooltip jika file ada
                        ->url(fn ($record) => $record->file_rubrik ? asset('storage/' . $record->file_rubrik) : null) // Mengatur URL untuk unduhan
                        ->openUrlInNewTab(), // Membuka URL di tab baru
            ])
            ->filters([
                // Tambahkan filter jika diperlukan
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
            // Tambahkan relasi jika diperlukan
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRubriks::route('/'),
            'create' => Pages\CreateRubrik::route('/create'),
            'edit' => Pages\EditRubrik::route('/{record}/edit'),
        ];
    }
}