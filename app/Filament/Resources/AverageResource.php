<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\AverageResource\Pages;
use App\Models\Avarage; // Gunakan model Avarage

class AverageResource extends Resource
{
    protected static ?string $model = Avarage::class; // Gunakan model Avarage

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Hasil & Evaluasi';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('matakuliah.nama_mk')
                    ->label('Mata Kuliah')
                    ->sortable()
                    ->searchable(),
                
                TextColumn::make('average_absen')
                    ->label('Rata-Rata Absen')
                    ->sortable(),
                
                TextColumn::make('average_tugas')
                    ->label('Rata-Rata Tugas')
                    ->sortable(),

                TextColumn::make('average_uts')
                    ->label('Rata-Rata UTS')
                    ->sortable(),

                TextColumn::make('average_uas')
                    ->label('Rata-Rata UAS')
                    ->sortable(),

                TextColumn::make('average_total_nilai')
                    ->label('Rata-Rata Total Nilai')
                    ->sortable(),
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
        return [];
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