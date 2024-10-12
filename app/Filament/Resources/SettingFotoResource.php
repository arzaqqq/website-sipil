<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingFotoResource\Pages;
use App\Filament\Resources\SettingFotoResource\RelationManagers;
use App\Models\SettingFoto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SettingFotoResource extends Resource
{
    protected static ?string $model = SettingFoto::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Setting Website';
    
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                ->disabled(),
                Forms\Components\FileUpload::make('foto')
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')->sortable(),
                Tables\Columns\ImageColumn::make('foto')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListSettingFotos::route('/'),
            'create' => Pages\CreateSettingFoto::route('/create'),
            'edit' => Pages\EditSettingFoto::route('/{record}/edit'),
        ];
    }
}