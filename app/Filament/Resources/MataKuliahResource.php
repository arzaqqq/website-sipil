<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\MataKuliah;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MataKuliahResource\Pages;
use App\Filament\Resources\MataKuliahResource\RelationManagers;

class MataKuliahResource extends Resource
{
    protected static ?string $model = MataKuliah::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

  
    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                 
            Forms\Components\TextInput::make('user_id')
            ->default(Auth::user()->id) 
                ->label('ID Pembuat')
                ->disabled()
                ->required()
                ->visibleOn('create'),

            Forms\Components\TextInput::make('nama_user')
             ->default(Auth::user()->name) 
                ->label('Nama Pembuat')
                ->disabled()
                ->required()
                ->visibleOn('create'),
              
                    
                Forms\Components\TextInput::make('nama_mk')
                ->label('Nama Mata Kuliah')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('user.name') 
                ->label('Nama Pembuat'), 
            Tables\Columns\TextColumn::make('nama_mk')
                ->label('Nama Mata Kuliah'), 
        ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListMataKuliahs::route('/'),
            'create' => Pages\CreateMataKuliah::route('/create'),
            'edit' => Pages\EditMataKuliah::route('/{record}/edit'),
        ];
    }
}