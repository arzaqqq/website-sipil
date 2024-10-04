<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Matakuliah;
use Filament\Tables\Table;
use App\Models\KontrakKuliah;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Storage;
use App\Filament\Resources\KontrakKuliahResource\Pages;
use Filament\Forms\Components\Modal;

class KontrakKuliahResource extends Resource
{
    protected static ?string $model = KontrakKuliah::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Perkuliahan';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('id_mk')
                    ->label('Mata Kuliah')
                    ->options(Matakuliah::all()->pluck('nama_mk', 'id'))
                    ->required()
                    ->searchable()
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('file')
                    ->label('Unggah File')
                    ->required()
                    ->directory('matakuliah')
                    ->preserveFilenames() 
                    ->columnSpanFull(),
                Forms\Components\TextArea::make('deskripsi')
                    ->label('Deskripsi')
                    ->placeholder('Masukkan deskripsi (opsional)')
                    ->nullable()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('matakuliah.nama_mk')
                    ->label('Mata Kuliah'),
                Tables\Columns\TextColumn::make('file')
                    ->label('File')
                    ->formatStateUsing(fn ($state) => basename($state))
                    ->html(),    
                Tables\Columns\TextColumn::make('deskripsi')
                    ->label('Deskripsi')
                    ->formatStateUsing(fn ($state) => strlen($state) > 30 ? substr($state, 0, 30) . '...' : $state)
                    ->extraAttributes(['class' => 'max-w-xs truncate'])
                    ->tooltip(fn ($record) => $record->deskripsi),
              
            ])
            ->filters([
                // Tambahkan filter jika perlu
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            Tables\Actions\Action::make('view')
                ->label('View File')
                ->url(fn ($record) => Storage::url($record->file))
                ->icon('heroicon-o-eye')
                ->color('warning')
                ->openUrlInNewTab(),
    
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
            // Hubungan model jika ada
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKontrakKuliahs::route('/'),
            'create' => Pages\CreateKontrakKuliah::route('/create'),
            'edit' => Pages\EditKontrakKuliah::route('/{record}/edit'),
        ];
    }
}