<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Filament\Resources\SettingResource\RelationManagers;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static ?string $navigationGroup = 'Setting Website';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema(function (Setting $record) {
                // Pastikan data sudah tersedia sebelum menentukan form
                if ($record->type === 'text') {
                    return [
                        Forms\Components\TextInput::make('label')->disabled(),
                        Forms\Components\TextInput::make('value')->required(),
                    ];
                } elseif ($record->type === 'longtext') {
                    return [
                        Forms\Components\TextInput::make('label')->disabled()->columnSpanFull(),
                        Forms\Components\RichEditor::make('value')->required()->columnSpanFull(),
                    ];
                } else {
                    // Default fallback jika type tidak sesuai
                    return [
                        Forms\Components\TextInput::make('label')->disabled(),
                        Forms\Components\TextInput::make('value')->required(),
                    ];
                }
            });
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('label')->sortable(),
                Tables\Columns\TextColumn::make('value')->sortable()->limit(50),
                // Tables\Columns\TextColumn::make('subjudul2')->sortable(),
                // Tables\Columns\TextColumn::make('teks1')->sortable(),
                // Tables\Columns\TextColumn::make('teks2')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->form(function (Setting $record) {
                    switch ($record->type) {
                        case 'text':
                            return [Forms\Components\TextInput::make('value')->label($record->label)];
                            break;
                        case 'longtext':
                            return [Forms\Components\RichEditor::make('value')->label($record->label)];
                            break;
                    }
                }),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
