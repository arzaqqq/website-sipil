<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Hasil;
use App\Models\Kelas;
use App\Models\Persen;
use Pages\CreateHasils;

use Filament\Forms\Form;
use App\Models\Matakuliah;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\HasilResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\HasilResource\RelationManagers;

class HasilResource extends Resource
{
    protected static ?string $model = Hasil::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Hasil & Evaluasi';
    protected static ?int $navigationSort = 3;

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
           
        ]);
    }
      
    

    

    

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('nama_mahasiswa')
                ->label('Nama Mahasiswa')
                ->sortable()
                ->searchable(),
            
            Tables\Columns\TextColumn::make('nim')
                ->label('NIM')
                ->sortable()
                ->searchable(),
                
            Tables\Columns\TextColumn::make('matakuliah.nama_mk')
                ->label('Mata Kuliah')
                ->sortable()
                ->searchable(),
                
            Tables\Columns\TextColumn::make('kelas.nama_kelas')
                ->label('Kelas')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('absen')
                ->label('Nilai Absen')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('tugas')
                ->label('Nilai Tugas')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('uts')
                ->label('Nilai UTS')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('uas')
                ->label('Nilai UAS')
                ->sortable()
                ->searchable(),
                
            Tables\Columns\TextColumn::make('total_nilai')
                ->label('Total Nilai')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('huruf_mutu')
                ->label('Huruf Mutu')
                ->sortable()
                ->searchable(),
                

                
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


     // Menambahkan tombol dan aksi untuk mengganti template
     

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHasils::route('/'),
            'create' => Pages\CreateHasil::route('/create'),
            'edit' => Pages\EditHasil::route('/{record}/edit'),
        ];
    }
}