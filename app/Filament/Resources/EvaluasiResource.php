<?php
namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Evaluasi;
use Filament\Forms\Form;
use App\Models\Matakuliah;
use App\Models\Avarage;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\EvaluasiResource\Pages;

class EvaluasiResource extends Resource
{
    protected static ?string $model = Evaluasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Hasil & Evaluasi';
    protected static ?int $navigationSort = 5;
    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('matakuliah_id')
                    ->label('Mata Kuliah')
                    ->options(Matakuliah::pluck('nama_mk', 'id'))
                    ->searchable()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn (Forms\Set $set) => $set('soal', null)),

                Forms\Components\TextInput::make('mg')
                    ->label('MG')
                    ->required(),

                Forms\Components\TextInput::make('cpl')
                    ->label('CPL')
                    ->required(),

                Forms\Components\TextInput::make('cpmk')
                    ->label('CPMK')
                    ->required(),

                Forms\Components\TextInput::make('sub_cpmk')
                    ->label('Sub CPMK')
                    ->required(),

                Forms\Components\TextInput::make('indikator')
                    ->required(),

                Forms\Components\Select::make('soal')
                    ->options([
                        'Tugas' => 'Tugas',
                        'UTS' => 'UTS',
                        'UAS' => 'UAS',
                    ])
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
                        $matakuliahId = $get('matakuliah_id');
                        $soal = $get('soal');
                        
                        if ($matakuliahId && $soal) {
                            $average = Avarage::where('matakuliah_id', $matakuliahId)->first();
                            if ($average) {
                                $averageValue = match ($soal) {
                                    'Tugas' => $average->average_tugas,
                                    'UTS' => $average->average_uts,
                                    'UAS' => $average->average_uas,
                                    default => null,
                                };
                                $set('average_mahasiswa_angka', $averageValue);
                            }
                        }
                    }),

                Forms\Components\TextInput::make('bobot')
                    ->numeric()
                    ->suffix('%')
                    ->required()
                    ->minValue(0)
                    ->maxValue(100)
                    ->reactive()
                    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
                        $bobot = floatval($get('bobot'));
                        $average = floatval($get('average_mahasiswa_angka'));
                        $set('average_mahasiswa_persen', number_format($bobot * $average / 100, 2));
                    }),

                Forms\Components\TextInput::make('average_mahasiswa_angka')
                    ->label('Rata-rata Nilai Mahasiswa')
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->maxValue(100)
                    ->reactive()
                    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
                        $bobot = floatval($get('bobot'));
                        $average = floatval($get('average_mahasiswa_angka'));
                        $set('average_mahasiswa_persen', number_format($bobot * $average / 100, 2));
                    }),

                // Hapus dehydrated(false) supaya field ini disertakan dalam proses insert
                Forms\Components\TextInput::make('average_mahasiswa_persen')
    ->label('Persentase Nilai Mahasiswa')
    ->numeric()
    ->required()  // Tambahkan ini untuk memastikan field ini menjadi wajib
    ->disabled(false)  // Pastikan field ini tidak di-disable sehingga tetap ter-hydrate
    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
        // Kalkulasi persentase dari bobot dan rata-rata mahasiswa angka
        $bobot = floatval($get('bobot'));
        $average = floatval($get('average_mahasiswa_angka'));
        $set('average_mahasiswa_persen', number_format($bobot * $average / 100, 2));
    }),

            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('matakuliah.nama_mk')
                    ->label('Mata Kuliah')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mg')
                    ->label('MG')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cpl')
                    ->label('CPL')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cpmk')
                    ->label('CPMK')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sub_cpmk')
                    ->label('Sub CPMK')
                    ->searchable(),
                Tables\Columns\TextColumn::make('indikator')
                    ->searchable(),
                Tables\Columns\TextColumn::make('soal')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bobot')
                    ->numeric()
                    ->suffix('%'),
                Tables\Columns\TextColumn::make('average_mahasiswa_angka')
                    ->label('Rata-rata Nilai')
                    ->numeric(),
                Tables\Columns\TextColumn::make('average_mahasiswa_persen')
                    ->label('Persentase Nilai')
                    ->numeric()
                    ->suffix('%'),
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
        return [
            // Tambahkan relasi jika diperlukan
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvaluasis::route('/'),
            'create' => Pages\CreateEvaluasi::route('/create'),
            'edit' => Pages\EditEvaluasi::route('/{record}/edit'),
        ];
    }
}