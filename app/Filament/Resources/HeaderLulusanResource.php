<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeaderLulusanResource\Pages;
use App\Filament\Resources\HeaderLulusanResource\RelationManagers;
use App\Models\HeaderLulusan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HeaderLulusanResource extends Resource
{
    protected static ?string $model = HeaderLulusan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('label')->sortable(),
                Tables\Columns\TextColumn::make('value')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->form(function (HeaderLulusan $record) {
                    switch ($record->type) {
                        case 'text':
                            return [Forms\Components\TextInput::make('value')->label($record->label)];
                            break;
                            // case 'longtext':
                            //     return [Forms\Components\RichEditor::make('value')->label($record->label)];
                            //     break;
                    }
                }),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageHeaderLulusans::route('/'),
        ];
    }
}
