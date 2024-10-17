<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\TindakLanjut;
use Filament\Resources\Resource;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TindakLanjutResource\Pages;
use App\Filament\Resources\TindakLanjutResource\RelationManagers;

class TindakLanjutResource extends Resource
{
    protected static ?string $model = TindakLanjut::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Survey & Tindak lanjut';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('file_tindak_lanjut')
                    ->required()
                    ->label('File Tindak Lanjut')
                    ->columnSpanFull()
                    ->directory('Tindak Lanjut')
                    ->preserveFilenames(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('file_tindak_lanjut')
                    ->label('File Tindak Lanjut')
                    ->formatStateUsing(fn($state) => $state ? basename($state) : 'No File')
                    ->html()
                    ->extraAttributes(['style' => 'text-align: left;']) // Mengatur teks agar rata kiri
                    ->tooltip(fn($state) => $state ? 'Klik untuk mengunduh' : null) // Menambahkan tooltip jika file ada
                    ->url(fn($record) => $record->file_tindak_lanjut ? asset('storage/' . $record->file_tindak_lanjut) : null) // Mengatur URL untuk unduhan
                    ->openUrlInNewTab(),
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
            'index' => Pages\ListTindakLanjuts::route('/'),
            'create' => Pages\CreateTindakLanjut::route('/create'),
            'edit' => Pages\EditTindakLanjut::route('/{record}/edit'),
        ];
    }
}
