<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $label = 'Admin & Dosen';
    protected static ?string $navigationGroup = 'Data Akses';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('avatar_url')
                    ->avatar()
                    ->label('avatar')
                    ->directory('avatars'),
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->required()
                    ->unique(User::class, 'email', ignoreRecord: true),
                Forms\Components\TextInput::make('password')
                    ->revealable()
                    ->password()
                    ->placeholder(fn($record) => $record ? 'Password telah diatur. Isi untuk mengubah.' : null) // Tampilkan placeholder saat edit
                    ->dehydrateStateUsing(fn($state) => filled($state) ? Hash::make($state) : null)
                    ->dehydrated(fn($state) => filled($state))
                    ->required(fn(string $context): bool => $context === 'create'), // Wajib hanya saat create,   
                Forms\Components\Select::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'dosen' => 'Dosen',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar_url')
                    ->label('Foto')
                    ->circular()
                    ->getStateUsing(function ($record) {
                        return $record->avatar_url ?: 'path_to_placeholder_image'; // Ganti dengan path gambar placeholder jika gambar tidak ada
                    }),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->label('Role')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data dibuat')

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->after(function (User $record) {
                    if ($record->avatar_url) {
                        $avatarPath = public_path('storage/' . $record->avatar_url); // Sesuaikan dengan path yang digunakan
                        if (file_exists($avatarPath) && !is_dir($avatarPath)) {
                            unlink($avatarPath);
                        }
                    }
                }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                Tables\Actions\ForceDeleteBulkAction::make()->after(function (User $records) {
                    foreach ($records as $record) {
                        if ($record->avatar_url) {
                            $avatarPath = public_path('storage/' . $record->avatar_url); // Sesuaikan dengan path yang digunakan
                            if (file_exists($avatarPath) && !is_dir($avatarPath)) {
                                unlink($avatarPath);
                            }
                        }
                    }
                }),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
