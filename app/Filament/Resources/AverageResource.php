<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Hasil;
use App\Models\Average;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\AverageResource\Pages;

class AverageResource extends Resource
{
    protected static ?string $model = Average::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $label = 'Rata-rata Nilai';
   
    protected static ?string $navigationGroup = 'Hasil & Evaluasi';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('matakuliah_id')
                    ->label('Mata Kuliah')
                    ->relationship('matakuliah', 'nama_mk')
                    ->required()
                    ->reactive(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('matakuliah.nama_mk')
                    ->label('Mata Kuliah')
                    ->sortable()
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('matakuliah.tahun_ajaran')
                    ->label('Tahun Ajaran')
                    ->sortable()
                    ->searchable(),    

                TextColumn::make('jumlah_mahasiswa')
                    ->label('Jumlah Mahasiswa')
                    ->getStateUsing(function ($record) {
                        return Hasil::where('matakuliah_id', $record->matakuliah_id)->count();
                    }),

                TextColumn::make('average_absen')
                    ->label('Rata-Rata Absen')
                    ->getStateUsing(function ($record) {
                        return Hasil::where('matakuliah_id', $record->matakuliah_id)->avg('absen');
                    }),

                TextColumn::make('average_tugas')
                    ->label('Rata-Rata Tugas')
                    ->getStateUsing(function ($record) {
                        return Hasil::where('matakuliah_id', $record->matakuliah_id)->avg('tugas');
                    }),

                TextColumn::make('average_uts')
                    ->label('Rata-Rata UTS')
                    ->getStateUsing(function ($record) {
                        return Hasil::where('matakuliah_id', $record->matakuliah_id)->avg('uts');
                    }),

                TextColumn::make('average_uas')
                    ->label('Rata-Rata UAS')
                    ->getStateUsing(function ($record) {
                        return Hasil::where('matakuliah_id', $record->matakuliah_id)->avg('uas');
                    }),

                TextColumn::make('average_total_nilai')
                    ->label('Rata-Rata Total Nilai')
                    ->getStateUsing(function ($record) {
                        return Hasil::where('matakuliah_id', $record->matakuliah_id)->avg('total_nilai');
                    }),
            ])
            ->filters([
                // Tambahkan filter jika diperlukan
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListAverages::route('/'),
            'create' => Pages\CreateAverage::route('/create'),
            'edit' => Pages\EditAverage::route('/{record}/edit'),
        ];
    }
}