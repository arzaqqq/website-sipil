<?php

namespace App\Filament\Resources;

use App\Models\Rps;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Matakuliah;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Storage;
use App\Filament\Resources\RpsResource\Pages;

class RpsResource extends Resource
{
    protected static ?string $model = Rps::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Perkuliahan';
    protected static ?string $label = 'RPS';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('id_mk')
                    ->label('Mata Kuliah')
                    ->options(Matakuliah::all()->pluck('nama_mk', 'id'))
                    ->required()
                    ->searchable(),
                Forms\Components\FileUpload::make('rps')
                    ->label('Unggah RPS')
                    ->required()
                    ->directory('rps_files')
                    ->preserveFilenames(),
                Forms\Components\TextArea::make('deskripsi')
                    ->label('Deskripsi')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('matakuliah.nama_mk')
                    ->label('Mata Kuliah'),
                Tables\Columns\TextColumn::make('rps')
                    ->label('RPS File')
                    ->formatStateUsing(fn ($state) => basename($state)),
                Tables\Columns\TextColumn::make('deskripsi')
                    ->label('Deskripsi')
                    ->formatStateUsing(fn ($state) => strlen($state) > 20 ? substr($state, 0, 20) . '...' : $state)
                    ->tooltip(fn ($record) => $record->deskripsi),
            ])
            ->filters([
                // Add any necessary filters here
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('view')
                    ->label('View RPS')
                    ->url(fn ($record) => Storage::url($record->rps))
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
            // Define any relationships here
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRps::route('/'),
            'create' => Pages\CreateRps::route('/create'),
            'edit' => Pages\EditRps::route('/{record}/edit'),
        ];
    }
}