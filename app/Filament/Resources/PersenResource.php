<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Kelas;
use App\Models\Persen;
use App\Models\Matakuliah;
use Filament\Forms\Form; // Correct namespace
use Filament\Tables\Table; // Pastikan import untuk Table benar
use Filament\Resources\Resource;
use App\Filament\Resources\PersenResource\Pages;

class PersenResource extends Resource
{
    protected static ?string $model = Persen::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $label = 'Bobot Persen nilai';
    protected static ?string $navigationGroup = 'Hasil & Evaluasi';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('matakuliah_id')
                    ->label('Mata Kuliah')
                    ->options(Matakuliah::all()->pluck('nama_mk', 'id'))
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn ($set) => $set('kelas_id', null)),
                
                Forms\Components\Select::make('kelas_id')
                    ->label('Kelas')
                    ->options(function (callable $get) {
                        $matakuliahId = $get('matakuliah_id');
                        return $matakuliahId ? Kelas::where('matakuliah_id', $matakuliahId)->pluck('nama_kelas', 'id') : [];
                    })
                    ->required()
                    ->reactive(),

                Forms\Components\TextInput::make('nama_dosen')
                    ->label('Nama Dosen')
                    ->required(),

                Forms\Components\TextInput::make('persen_absen')
                    ->label('Persen Absen (%)')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn ($set, $get) => self::calculateTotalPersen($set, $get)),

                Forms\Components\TextInput::make('persen_latihan')
                    ->label('Persen Latihan (%)')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn ($set, $get) => self::calculateTotalPersen($set, $get)),

                Forms\Components\TextInput::make('persen_UTS')
                    ->label('Persen UTS (%)')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn ($set, $get) => self::calculateTotalPersen($set, $get)),

                Forms\Components\TextInput::make('persen_UAS')
                    ->label('Persen UAS (%)')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn ($set, $get) => self::calculateTotalPersen($set, $get)),

                    Forms\Components\TextInput::make('total_persen')
                    ->label('Total Persentase (%)')
                    ->numeric()
                    ->disabled()
                    ->default(0)
                    ->required()
                    ->rule(['numeric', 'min:100', 'max:100'])
                    ->validationAttribute('Total Persentase')
                
            ]);
    }

    protected static function calculateTotalPersen($set, $get): void
    {
        $totalPersen = intval($get('persen_absen')) + intval($get('persen_latihan')) + intval($get('persen_UTS')) + intval($get('persen_UAS'));
        $set('total_persen', $totalPersen);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('matakuliah.nama_mk')->label('Mata Kuliah'),
                Tables\Columns\TextColumn::make('kelas.nama_kelas')->label('Kelas'),
                Tables\Columns\TextColumn::make('nama_dosen')->label('Nama Dosen'),
                Tables\Columns\TextColumn::make('persen_absen')->label('Persen Absen (%)'),
                Tables\Columns\TextColumn::make('persen_latihan')->label('Persen Latihan (%)'),
                Tables\Columns\TextColumn::make('persen_UTS')->label('Persen UTS (%)'),
                Tables\Columns\TextColumn::make('persen_UAS')->label('Persen UAS (%)'),
                Tables\Columns\TextColumn::make('total_persen')->label('Total Persentase (%)'),
            ])
            ->filters([
                // Tambahkan filter jika diperlukan
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPersens::route('/'),
            'create' => Pages\CreatePersen::route('/create'),
            'edit' => Pages\EditPersen::route('/{record}/edit'),
        ];
    }
}