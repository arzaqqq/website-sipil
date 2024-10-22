<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Forms;
use Filament\Tables;
use App\Models\Dokumen;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\DokumenResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DokumenResource\RelationManagers;

class DokumenResource extends Resource
{
    protected static ?string $model = Dokumen::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('jenis_dokumen')
                    ->options([
                        'Kurikulum' => 'Kurikulum',
                        'SK' => 'SK',
                        'SPMI' => 'SPMI',
                        'AMI' => 'AMI',
                    ])
                    ->label('Jenis Dokumen')
                    ->required()
                    ->reactive()
                    ->columnSpanFull(),
                FileUpload::make('file_dokumen')
                    ->required()
                    ->label('Dokumen')
                    ->columnSpanFull()
                    ->directory(fn($get) => $get('jenis_dokumen'))
                    ->preserveFilenames(),
                TextInput::make('tahun')
                    ->required()
                    ->label('Tahun')
                    ->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('jenis_dokumen')
                    ->label('Jenis Dokumen')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('file_dokumen')
                    ->label('File Dokumen')
                    ->searchable()
                    ->formatStateUsing(fn($state) => $state ? basename($state) : 'No File')
                    ->html()
                    ->extraAttributes(['style' => 'text-align: left;'])
                    ->tooltip(fn($state) => $state ? 'Klik untuk mengunduh' : null)
                    ->url(fn($record) => $record->file_dokumen ? asset('storage/' . $record->file_dokumen) : null)
                    ->openUrlInNewTab(),

                TextColumn::make('tahun')
                    ->label('Tahun')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('jenis_dokumen')
                    ->label('Jenis Dokumen')
                    ->options([
                        'Kurikulum' => 'Kurikulum',
                        'SK' => 'SK',
                        'SPMI' => 'SPMI',
                        'AMI' => 'AMI',
                    ]),
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
            'index' => Pages\ListDokumens::route('/'),
            'create' => Pages\CreateDokumen::route('/create'),
            'edit' => Pages\EditDokumen::route('/{record}/edit'),
        ];
    }
}
