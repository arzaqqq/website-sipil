<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ProfilLulusan;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProfilLulusanResource\Pages;
use App\Filament\Resources\ProfilLulusanResource\RelationManagers;

class ProfilLulusanResource extends Resource
{
    protected static ?string $model = ProfilLulusan::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Setting Website';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\TextInput::make('header_profil'),
                // Forms\Components\TextInput::make('header_deskripsi'),
                TextInput::make('nama_profil')
                    ->required()
                    ->columnSpanFull(),
                RichEditor::make('deskripsi_profil')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('header_profil')->sortable(),
                // Tables\Columns\TextColumn::make('header_deskripsi')->sortable(),
                Tables\Columns\TextColumn::make('nama_profil')->sortable(),
                Tables\Columns\TextColumn::make('deskripsi_profil')->limit(50),
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
            'index' => Pages\ListProfilLulusans::route('/'),
            'create' => Pages\CreateProfilLulusan::route('/create'),
            'edit' => Pages\EditProfilLulusan::route('/{record}/edit'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
